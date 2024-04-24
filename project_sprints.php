<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit;
    }
    elseif (!isset($_GET["id"])) {
        // Redirect the user to the login page
        header("Location: project_view.php");
        exit;
    }

    function getSprintDetails (PDO $pdo, int $sprint_id){
        $sql = "SELECT sprint_title AS title, sprint_description AS description, start_date, end_date
            FROM Sprint
            WHERE sprint_id = :sprint_id;";
        $project = pdo($pdo, $sql, ["sprint_id" => $sprint_id])->fetch();

        return $project;
    }
    
    $sprint_id = $_GET["id"];
    $sprintDetails = getSprintDetails($pdo, $sprint_id);
?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Project Sprints</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <header>
            <h1><?php echo $sprintDetails["title"]; ?></h1>
            <a class="logout-button" href="logout.php">Logout</a>
        </header>

        <main>
            <p><?php echo "Start: ", $sprintDetails["start_date"]; ?> </p>
            <p><?php echo "End: ", $sprintDetails["end_date"]; ?> </p>
            <p><?php echo $sprintDetails["description"]; ?></p>
        </main>
    </BODY>
</HTML>