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

    //check if the user is a member of the project
    

    //get the user_id from the session 
    $user_id = $_SESSION["user_id"];

    function getProjectDetails(PDO $pdo, int $projectId){
        $sql = "SELECT title, description
            FROM Projects
            WHERE project_id = :project_id;";
        $project = pdo($pdo, $sql, ["project_id" => $projectId])->fetch();

        return $project;
    }

    function getAssociatedTasks(PDO $pdo, int $projectId){
        $sql = "SELECT task_id, title, description, due_date
            FROM Tasks
            WHERE project_id = :project_id;";
        $tasks = pdo($pdo, $sql, ["project_id" => $projectId])->fetchAll();

        return $tasks;
    }

    $projectDetails = getProjectDetails($pdo, $projectId);
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
        <TITLE></TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>

        <h1><?= $projectDetails["title"] ?></h1>
        <p><?= $projectDetails["description"] ?></p>
        
        <a href="project_tasks.php?id=<?= $projectId ?>"><h3>Tasks</h3></a>

        <a href="project_events.php?id=<?= $projectId ?>"><h3>Events</h3></a>
        
        <a href="project_sprints.php?id=<?= $projectId ?>"><h3>Sprints</h3></a>


        <div class="topBar">
            <a class="logout-button" href="logout.php">Logout</a>
            <h1 class="project-name"><?php echo "PROJ NAME HERE";?></h1>
        </div>

    </BODY>
</HTML>