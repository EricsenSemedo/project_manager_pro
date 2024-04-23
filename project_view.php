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

    // This function gets all the tasks associated with a project
    function getAssociatedTasks(PDO $pdo, int $project_id){
        $sql = "SELECT task_id AS id, title
            FROM Task
            WHERE project_id = :project_id;";
        $tasks = pdo($pdo, $sql, ["project_id" => $project_id])->fetchAll();

        return $tasks;
    }
    
    // This function gets all the events associated with a project
    function getProjectEvents(PDO $pdo, int $project_id) {
        $sql = "SELECT event_id AS id, event_title AS title
            FROM Event
            WHERE project_id = :project_id;";
        $events = pdo($pdo, $sql, ["project_id" => $project_id])->fetchAll();

        return $events;
    }

    // This function gets all the sptrints associated with a project
    function getAssociatedSprints(PDO $pdo, int $project_id) {
        $sql = "SELECT sprint_id AS id, sprint_title AS title
            FROM Sprint
            WHERE project_id = :project_id;";
        $sprints = pdo($pdo, $sql, ["project_id" => $project_id])->fetchAll();

        return $sprints;
    }

    $errorMessage = "";
    $projectDetails = getProjectDetails($pdo, $project_id);
    $associatedEvents = getProjectEvents($pdo, $project_id);
    $associatedTasks = getAssociatedTasks($pdo, $project_id);
    $associatedSprints = getAssociatedSprints($pdo, $project_id);
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
            <a class="logout-button right-element" href="logout.php">Logout</a>
        </header>

        <main>
            <br><br><br> 
            <p><?= $projectDetails["description"]; ?></p>
            
            <section class="khanban-board">
                <ul class="khanban-column">
                    <h2>Tasks</h2>
                    <a href="project_tasks_form.php?id=<?= $project_id ?>"><h3>Add task</h3></a>
                    <?php foreach ($associatedTasks as $task): ?>
                        <li class="khanban-card">
                            <a href="project_sprints.php?id=<?= $task["id"] ?>"><h3><?php echo $task["title"]; ?></h3></a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <ul class="khanban-column">
                    <h2>Events</h2>
                    <a href="project_events_form.php?id=<?= $project_id ?>"><h3>Add Events</h3></a>
                    <?php foreach ($associatedEvents as $event): ?>
                        <li class="khanban-card">
                            <a href="project_sprints.php?id=<?= $event["id"] ?>"><h3><?php echo $event["title"]; ?></h3></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <ul class="khanban-column">
                    <h2>Sprints</h2>
                    <a href="project_Sprints_form.php?id=<?= $project_id ?>"><h3>Add Sprints</h3></a>
                    <?php foreach ($associatedSprints as $sprint): ?>
                        <li class="khanban-card">
                            <a href="project_sprints.php?id=<?= $sprint["id"] ?>"><h3><?php echo $sprint["title"]; ?></h3></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <button onclick="window.location.href='home.php'">Go to Home</button>

        </main>


    </BODY>
</HTML>