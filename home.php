<?php
    require "includes/database-connection.php"; // Require the database connection file

    session_start(); // Start a new session so that we can save and retrieve the user's data across multiple pages

    // Check if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit;
    }

    // Get the user_id from the session
    $user_id = $_SESSION["user_id"];

    function getUserFirstName(PDO $pdo, int $user_id) {
        $sql = "SELECT first_name
            FROM Users
            WHERE user_id = :user_id;";
        $user = pdo($pdo, $sql, ["user_id" => $user_id])->fetch();

        return $user["first_name"];
    }

    $first_name = getUserFirstName($pdo, $user_id);
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
        <div class="home">
            <h1>Home</h1>
            <p><?= "Hello, ", $first_name, " this is your home page"?></p>
        </div>
    </body>
</html>