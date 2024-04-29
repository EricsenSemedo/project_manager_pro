<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start(); // Start a new session so that we can save the user's data across multiple pages


    $errorMessage = "";

    if (isset($_SESSION["error_message"])) {
        $errorMessage = $_SESSION["error_message"];
        unset($_SESSION["error_message"]);
    }

    /*
     * Retrieves a user from the database using the provided email and password.
     * 
     * @param PDO $pdo          An instance of the PDO class.
     * @param string $email  The email of the user to retrieve.
     * @param string $password  The password of the user to retrieve.
     * @return array|null       An associative array containing the user's data, or null if no user is found.
     */
    function getUser(PDO $pdo, string $email, string $password){
        $sql = "SELECT user_id, password_hash
            FROM Users
            WHERE email = :email;";
        $user = pdo($pdo, $sql, ["email" => $email])->fetch();

        if ($user && password_verify($password, $user["password_hash"])) {
            return $user;
        }
        
        return null;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the email and password from the form
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = getUser($pdo, $email, $password); // Get the user from the database
        
        if ($user) {
            // Login is successful, save the user's ID in the session
            $_SESSION["user_id"] = $user["user_id"];

            // Redirect to the home page
            header("Location: home.php");
            exit();
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
        <header>
            <nav>
                <a class="top-left-button" href="register.php">Create New Account</a>
            </nav>
            <p class="app-title">Project Manager Pro</p>
        </header>

        <main>
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
        </main>
    </body>
</html>