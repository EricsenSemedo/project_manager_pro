<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit;
    }
    
    $projectId = $_GET["id"];

    $errorMessage = "";
?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE><?= $projectId ?></TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <h1></h1>
        
        <a class="logout-button" href="logout.php">Logout</a>
    </BODY>

</HTML>