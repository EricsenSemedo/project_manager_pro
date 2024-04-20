<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start(); // Start a new session so that we can save the user's data across multiple pages

    $errorMessage = "";

    /*
     * Retrieves a user from the database using the provided email and password.
     * 
     * @param PDO $pdo          An instance of the PDO class.
     * @param string $email  The email of the user to retrieve.
     * @param string $password  The password of the user to retrieve.
     * @return array|null       An associative array containing the user's data, or null if no user is found.
     */
    function getUser(PDO $pdo, string $email, string $password){
        $sql = "SELECT user_id
            FROM Users
            WHERE email = :email and password_hash = :password;";
        $user = pdo($pdo, $sql, ["email" => $email, "password" => $password])->fetch();
        
        return $user;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the email and password from the form
        $email = $_POST["email"];
        // TODO: Hash the password before storing it in the variable to then compare it with the database
        $password = $_POST["password"];

        $user = getUser($pdo, $email, $password); // Get the user from the database
        
        if ($user) {
            // Login is successful, save the user's ID in the session
            $_SESSION["user_id"] = $user["user_id"];

            // Redirect to the home page
            header("Location: home.php");
        }
        else {
            // Invalid email or password
            $errorMessage = "Invalid email or password. Please try again.";
        }
    }
?>

<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="login">
            <h1>Login</h1>

            <?php if ($errorMessage): ?>
                <p class="error"><?= $errorMessage ?></p>
            <?php endif;?>

            <form action="login.php" method="POST">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Login</button>
            </form>
            <p class="register_link">Don't have an account? <a href="register.php">Register</a></p>
        </div>

    </body>
</html>