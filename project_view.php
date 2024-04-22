<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit;
    }
    
    $errorMessage = "";
?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Project View</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <a class="logout-button" href="logout.php">Logout</a>
    </BODY>

</HTML>