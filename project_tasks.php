<?php
    session_start();

    require 'includes/database-connection.php'; // Require the database connection file

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
    
    function getTaskNotes (PDO $pdo, int $task_id){
        $sql = "SELECT  n.date, n.info, u.email 
            FROM Note n
            JOIN Users u ON n.user_id = u.user_id
            WHERE task_id = :task_id;";
        $notes = pdo($pdo, $sql, ["task_id" => $task_id])->fetchAll();

        return $notes;
    }

    $task_id = $_GET["id"];
    $taskDetails = getTaskDetails($pdo, $task_id);
    $taskNotes = getTaskNotes($pdo, $task_id);
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
            <p>Task Status:<?php echo $taskDetails["status"]; ?></p>

            <a  href="project_tasks_status.php?id=<?= $task_id ?>"><p>Update Status</p></a>

            <p>Task Description:<?php echo $taskDetails["description"]; ?></p>


            <!-- note list -->
            <h2>Notes:</h2>
            <a href="project_tasks_notes.php?id=<?= $task_id ?>"><h3>Add Notes</h3></a>
            <ul>
                <?php foreach ($taskNotes as $note): ?>
                    <li>
                        <p><?php echo $note["info"]; ?></p>
                        <p><b>Date:</b> <?php echo $note["date"]; ?></p>
                        <p><b>Author:</b> <?php echo $note["email"]; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            
                
        </main>
    </BODY>
</HTML>
