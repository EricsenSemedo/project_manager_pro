<!-- A form to insert tasks into database -->
<!-- Project settings button
    Add user
    Remove user
-->
<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start();

    // Get the user_id from the session
    $user_id = $_SESSION["user_id"];

    //get the project id 
    $project_id = $_GET["id"];

    if(!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $task_title = $_POST["task_title"];
        $task_description = $_POST["task_description"];
        $task_status = $_POST["task_status"];

        //check title,description,status are not empty
        if(empty($task_title) || empty($task_description) || empty($task_status)){
            $errorMessage = "Please fill out all fields";
            exit;
        }

        //sql statement insets into task
        $sql = "INSERT INTO Task (user_id,title, description, status, project_id)
            VALUES (:user_id,:title, :description, :status, :project_id);";

        try{
            pdo($pdo, $sql, ["user_id" => $user_id,"title" => $task_title, "description" => $task_description, "status" => $task_status, "project_id" => $project_id]);
            header("Location: project_view.php?id=$project_id");
            exit;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Add Tasks</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Add task to Project</h1>
            <form action="project_tasks_form.php?id=<?= $project_id ?>" method="post">
                <input type="text" name="task_title" placeholder="Task Name">
                <input type="text" name="task_description" placeholder="Task Description">
                <input type="text" name="task_status" placeholder="Task Status">
                <input type="submit" name="submit" value="Add Task">
            </form>
        </div>
    </BODY>
</HTML>