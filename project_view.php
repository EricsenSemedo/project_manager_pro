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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #285b99; /* Background color */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center align horizontally */
            align-items: center; /* Center align vertically */
            height: 100vh; /* Full height of viewport */
            position: relative;
        }
        main {
            display: flex;
            justify-content: space-between; /* Distribute forms evenly */
            width: 100%;
            margin-top: auto;
        }
        form {
            background-color: #285b99; /* Form background color */
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0px 0px 40px 0px rgba(150, 170, 250,0); /* Shadow effect */
            width: calc(33.33% - 20px); /* Each form takes up roughly one-third of the available space */
            margin: 0 25px; /* Added margin between forms */
        }
        button {
            margin-top: 20px; /* Add some space between the main content and the button */
        }
        .description {
            margin-top: 100px; /* Add margin to separate from forms */
            text-align: center; /* Center align text */
        }
    </style>
    <BODY>
        <header>
            <h1><?php echo $projectDetails["title"]; ?></h1>
            <a class="logout-button" href="logout.php">Logout</a>
        </header>

        <main>
            <br><br><br> 
            
            <form class="khanban-column">
                <h2>Tasks</h2>
                <a href="project_tasks_form.php?id=<?= $project_id ?>"><h3>Add task</h3></a>
                <?php foreach ($associatedTasks as $task): ?>
                    <li class="khanban-card">
                        <a href="project_tasks.php?id=<?= $task["id"] ?>"><h3><?php echo $task["title"]; ?></h3></a>
                    </li>
                <?php endforeach; ?>
            </form>

            <form class="khanban-column">
                <h2>Events</h2>
                <a href="project_events_form.php?id=<?= $project_id ?>"><h3>Add Events</h3></a>
                <?php foreach ($associatedEvents as $event): ?>
                    <li class="khanban-card">
                        <a href="project_events.php?id=<?= $event["id"] ?>"><h3><?php echo $event["title"]; ?></h3></a>
                    </li>
                <?php endforeach; ?>
                </form>
                
            <form class="khanban-column">
                <h2>Sprints</h2>
                <a href="project_Sprints_form.php?id=<?= $project_id ?>"><h3>Add Sprints</h3></a>
                <?php foreach ($associatedSprints as $sprint): ?>
                    <li class="khanban-card">
                        <a href="project_sprints.php?id=<?= $sprint["id"] ?>"><h3><?php echo $sprint["title"]; ?></h3></a>
                    </li>
                <?php endforeach; ?>
            </form>

            <p class="description"><?= $projectDetails["description"]; ?></p>

            <button onclick="window.location.href='home.php'">Go to Home</button>

        </main>
    </BODY>
</HTML>
