<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit;
    }
    
    $project_id = $_GET["id"];

    //check if the user is a member of the project
    

    //get the user_id from the session 
    $user_id = $_SESSION["user_id"];

    function getProjectDetails(PDO $pdo, int $project_id){
        $sql = "SELECT title, description
            FROM Projects
            WHERE project_id = :project_id;";
        $project = pdo($pdo, $sql, ["project_id" => $project_id])->fetch();

        return $project;
    }

    function getAssociatedTasks(PDO $pdo, int $project_id){
        $sql = "SELECT task_id, title, description
            FROM Task
            WHERE project_id = :project_id;";
        $tasks = pdo($pdo, $sql, ["project_id" => $project_id])->fetchAll();

        return $tasks;
    }

    $projectDetails = getProjectDetails($pdo, $project_id);
    $errorMessage = "";

    function getProjectEvents(PDO $pdo, int $project_id) {
        $sql = "SELECT *
            FROM Event
            WHERE project_id = :project_id;";
        $events = pdo($pdo, $sql, ["project_id" => $project_id])->fetch();

        return $events;
    }

    $events = getProjectEvents($pdo, $project_id);
    $associatedTasks = getAssociatedTasks($pdo, $project_id);
?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE></TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <header>
            <h1><?php echo $projectDetails["title"]; ?></h1>
            <a class="logout-button" href="logout.php">Logout</a>
        </header>

        <main>
            <p><?= $projectDetails["description"] ?></p>
            
            <section class="khanban-board">
                <ul class="khanban-column">
                    <?php foreach ($associatedTasks as $task): ?>
                        <li class="khanban-card">
                            <h3><?= $task["title"] ?></h3>
                            <p><?= $task["description"] ?></p>
                        </li>
                    <?php endforeach; ?>
                    <a href="project_tasks.php?id=<?= $project_id ?>"><h3>Tasks</h3></a>
                </ul>

                <ul class="khanban-column">
                    <a href="project_events.php?id=<?= $project_id ?>"><h3>Events</h3></a>
                </ul>
                
                <ul class="khanban-column">
                    <a href="project_sprints.php?id=<?= $project_id ?>"><h3>Sprints</h3></a>
                </ul>
            </section>
        </main>
    </BODY>
</HTML>