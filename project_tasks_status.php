<?php
    session_start();

    require 'includes/database-connection.php'; // Require the database connection file

    //function to get task details
    function getTaskDetails (PDO $pdo, int $task_id){
        $sql = "SELECT title, description, status
            FROM Task
            WHERE task_id = :task_id;";
        $project = pdo($pdo, $sql, ["task_id" => $task_id])->fetch();

        return $project;
    }

    // Get the user_id from the session
    $user_id = $_SESSION["user_id"];

    //get the project id 
    $task_id = $_GET["id"];

    $task_details = getTaskDetails($pdo, $task_id);

   
    if(!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $task_status = $_POST["task_status"];
      
        //check if description is empty
        if(empty($task_status)){
            $errorMessage = "Please fill out all fields";
            exit;
        }

        //sql statement updates task status using the task ID 
        $sql = "UPDATE Task
                SET status = :status
                WHERE task_id = :task_id;"; 

        try{
            pdo($pdo, $sql, ["status" => $task_status, "task_id" => $task_id]);
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
        <TITLE>Update task status</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Current task status</h1>
            <form action="project_tasks_status.php?id=<?= $task_id ?>" method="post">
                <input type="text" name="task_status" value="<?php echo $task_details["status"]; ?>">
                <input type="submit" name="submit" value="update">
            </form>
        </div>
    </BODY>
    <a href="project_tasks.php?id=<?= $task_id ?>"><p>Back to Task</p></a>
</HTML>
