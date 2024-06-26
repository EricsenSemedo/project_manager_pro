<?php
    session_start(); 

    require 'includes/database-connection.php'; 

    $statusMessage = "";

    function insertUser(PDO $pdo, string $firstname, string $lastname, string $email, string $password){

        $sql = "INSERT INTO Users (first_name, last_name, password_hash, email) VALUES (:firstname, :lastname, :password, :email);";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(["firstname" => $firstname, "lastname" => $lastname, "email" => $email, "password" => $password]);
            return true; // Return true if insertion is successful
        } catch (PDOException $e) {
            // Check if the error is due to duplicate user_id
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
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
        $password = $_POST["password"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userInserted = insertUser($pdo, $firstname, $lastname, $email, $hashedPassword); 		// Get the user from the database
        
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
        <header>
            <nav>
                <a class="top-left-button" href="login.php">Back to Login</a>
            </nav>
            <p class="app-title">Project Manager Pro</p>
        </header>
        <div>
            <h1>Add New User</h1>
            <form action="register.php" method="POST">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" required>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" required>

                <label for="email">Email:</label>
                <input type="text" name="email" id="email" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>

                <label for="password_check">Re-enter Password:</label>
                <input type="password" name="password_check" id="password_check" required>

                <button type="submit">Add User</button>
                <?php if ($statusMessage): ?>
                    <p class="status-message"><?= $statusMessage ?></p>
                <?php endif;?>
            </form>
        </div>
    </body>
</html>