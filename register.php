<?php
    require 'includes/database-connection.php'; 

    session_start(); 

    $statusMessage = "";

    function insertUser(PDO $pdo, string $firstname, string $lastname, string $email, string $userid, string $password){

        $sql = "INSERT INTO Users (user_id, first_name, last_name, password_hash, email) VALUES (:userid, :firstname, :lastname, :password, :email);";

        //$user = pdo($pdo, $sql, ["firstname" => $firstname, "lastname" => $lastname, "email" => $email, "userid" => $userid, "password" => $password])->fetch();
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(["firstname" => $firstname, "lastname" => $lastname, "email" => $email, "userid" => $userid, "password" => $password]);
            return true; // Return true if insertion is successful
        } catch (PDOException $e) {
            // Check if the error is due to duplicate user_id
            if ($e->errorInfo[1] == 1062) {
                return false; // Return false if user_id already exists
            } else {
                throw $e; // Re-throw the exception if it's not a duplicate user_id error
            }
        }

        return $user;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the user values from the form
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $userid = $_POST["userid"];
        $password = $_POST["password"];								// TODO: Hash the password before storing it in the variable to then compare it with the database

        $userInserted = insertUser($pdo, $firstname, $lastname, $email, $userid, $password); 		// Get the user from the database
        
        if (!$userInserted) {
            $statusMessage = "User ID already exists.  Please choose another.";
        } else {
            $statusMessage = "New User ID has been added to the system.";
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #285b99; /* Background color */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center align horizontally */
            align-items: center; /* Center align vertically */
            height: 100vh; /* Full height of viewport */
            position: relative;
        }

        .top-left-button {
            position: absolute; /* Position absolute to place it at the top left corner */
            top: 20px; /* Adjust top position as needed */
            left: 20px; /* Adjust left position as needed */
        }

        form {
            background-color: #dedede; /* Form background color */
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 0px 40px 0px rgba(150, 170, 250,1); /* Shadow effect */
            width: calc(33.33% - 20px); /* Each form takes up roughly one-third of the available space */
            margin: 0 10px; /* Added margin between forms */
        }

        h1 {
            text-align: center;
            color: #290000; /* Heading color */
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #666666; /* Label color */
        }

        input[type="text"],
        input[type="password"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cccccc; /* Input border color */
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff; /* Button background color */
            color: #ffffff; /* Button text color */
            cursor: pointer;
            width: calc(100% - 20px);
        }

        button:hover {
            background-color: #0056b3; /* Button background color on hover */
        }

        .top-left-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Button background color */
            color: #ffffff; /* Button text color */
            text-decoration: none; /* Remove underline */
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .top-left-button a:hover {
            background-color: #0056b3; /* Button background color on hover */
        }

    </style>
</head>
<body>
    <div class="top-left-button">
        <a href="http://localhost/project_manager_pro/login.php">Back to Login</a>
    </div>
    <div>
        <h1>Add New User</h1>
        <form action="register.php" method="POST">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" required>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" required>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>

            <label for="userid">Select a User ID:</label>
            <input type="text" name="userid" id="userid" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Add User</button>
            <?php if ($statusMessage): ?>
                <p class="status-message"><?= $statusMessage ?></p>
            <?php endif;?>
        </form>
    </div>
</body>
</html>