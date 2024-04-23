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

    getProjectEvents(PDO $pdo, int $project_id) {
        $sql = "SELECT *
            FROM Event
            WHERE project_id = :project_id;"
        $events = pdo($pdo, $sql, ["project_id" => $project_id])->fetch();

        return $events;
    }

    $events = getProjectEvents($pdo, $project_id);
?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Project View</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="topBar">
            <a class="logout-button" href="logout.php">Logout</a>
            <h1 class="project-name"><?php echo "PROJ NAME HERE";?></h1>
        </div>
    </BODY>
</HTML>