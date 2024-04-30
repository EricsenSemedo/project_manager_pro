<?php
    session_start();

    require 'includes/database-connection.php'; // Require the database connection file

    // Get the user_id from the session
    $user_id = $_SESSION["user_id"];

    //get the project id 
    $task_id = $_GET["id"];

    if(!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $note_description = $_POST["note_description"];
      
        //check if description is empty
        if(empty($note_description)){
            $errorMessage = "Please fill out all fields";
            exit;
        }

        //sql statement insets into task
        $sql = "INSERT INTO Note (user_id, date, info, task_id)
                VALUES (:user_id, NOW(), :info, :task_id);";

        try{
            pdo($pdo, $sql, ["user_id" => $user_id, "info" => $note_description, "task_id" => $task_id]);
            header("Location: project_tasks.php?id=$task_id");
            exit;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Add Note</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Add note to Task</h1>
            <form action="project_tasks_notes.php?id=<?= $task_id ?>" method="post">
                <input type="text" name="note_description" placeholder="Note Description">
                <input type="submit" name="submit" value="Add Note">
            </form>
        </div>
    </BODY>
    <a href="project_tasks.php?id=<?= $task_id ?>"><p>Back to Task</p></a>
</HTML>
