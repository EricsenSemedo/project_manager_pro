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
        $password = $_POST["password"];
        // TODO: Hash the password before storing it in the variable to then compare it with the database

        $userInserted = insertUser($pdo, $firstname, $lastname, $email, $userid, $password); 		// Get the user from the database
        
        if ($_POST["password"] != $_POST["password_check"]) {
            $statusMessage = "Passwords do not match.  Please try again.";
        } 
        else if (!$userInserted) {
            $statusMessage = "User ID already exists.  Please choose another.";
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
    <link rel="stylesheet" href="css/style.css">
    <style></style>
</head>
    <body>
        <div class="top-left-button">
            <a class="top-left-button" href="http://localhost/project_manager_pro/login.php">Back to Login</a>
        </div>

        <div class="register">
            <h1>Create New Account</h1>
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
