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
?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE></TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <header>
            <h1><?= $projectDetails["title"] ?></h1>
        </header>

        <main>
            <p><?= $projectDetails["description"] ?></p>
            
            <section>
                <h2>Tasks</h2>
                <a href="project_tasks.php?id=<?= $projectId ?>"><h3>Tasks</h3></a>
            </section>
            
            <section>
                <h2>Events</h2>
                <a href="project_events.php?id=<?= $projectId ?>"><h3>Events</h3></a>
            </section>
            
            <section>
                <a href="project_sprints.php?id=<?= $projectId ?>"><h3>Sprints</h3></a>
            </section>

            <a class="logout-button" href="logout.php">Logout</a>
        </main>
    </BODY>

</HTML>