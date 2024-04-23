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

    function getTaskDetails (PDO $pdo, int $task_id){
        $sql = "SELECT title, description, status
            FROM Task
            WHERE task_id = :task_id;";
        $project = pdo($pdo, $sql, ["task_id" => $task_id])->fetch();

        return $project;
    }
    
    $task_id = $_GET["id"];
    $taskDetails = getTaskDetails($pdo, $task_id);
?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Project Tasks</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <header>
            <h1><?php echo $taskDetails["title"]; ?></h1>
            <a class="logout-button" href="logout.php">Logout</a>
        </header>

        <main>
            <p><?php echo $taskDetails["status"]; ?></p>
            <p><?php echo $taskDetails["description"]; ?></p>
        </main>
    </BODY>
</HTML>