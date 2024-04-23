<?php
    session_start();

    // Unset all of the session variables
    unset($_SESSION["user_id"]);

    // Redirect the user to the login page
    header("Location: login.php")