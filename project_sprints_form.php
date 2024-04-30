<?php
    session_start();

    require 'includes/database-connection.php'; // Require the database connection file

    // Get the user_id from the session
    $user_id = $_SESSION["user_id"];

    //get the project id 
    $project_id = $_GET["id"];


    // Check if the form has been submitted
    if(!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $sprint_title = $_POST["sprint_title"];
        $sprint_description = $_POST["sprint_description"];
        $sprint_start_dateTime = $_POST["sprint_start_dateTime"];
        $sprint_end_dateTime = $_POST["sprint_end_dateTime"];

        //check if any of the fields are empty 
        if(empty($sprint_title) || empty($sprint_description) || empty($sprint_start_dateTime) || empty($sprint_end_dateTime)){
            $errorMessage = "Please fill out all fields";
            exit;
        }

        //sql statement insets into sprints
        $sql = "INSERT INTO Sprint (project_id, sprint_title, sprint_description, start_date, end_date)
            VALUES (:project_id, :sprint_title, :sprint_description, :start_date, :end_date);";

        try{
            pdo($pdo, $sql, ["project_id" => $project_id, "sprint_title" => $sprint_title, "sprint_description" => $sprint_description, "start_date" => $sprint_start_dateTime, "end_date" => $sprint_end_dateTime]);
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
        <TITLE>Add Sprints</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Add Sprint to Project</h1>
            <form action="project_Sprints_form.php?id=<?= $project_id ?>" method="post">
                <input type="text" name="sprint_title" placeholder="Sprint Name">
                <input type="text" name="sprint_description" placeholder="Sprint Description">
                <label>Start Date</label>
                <input type="datetime-local" name="sprint_start_dateTime">
                <label>End Date</label>
                <input type="datetime-local" name="sprint_end_dateTime">
                <input type="submit" name="submit" value="Add Sprint">
            </form>
        </div>
    </BODY>
    <a href="project_view.php?id=<?= $project_id ?>">Back to Project View</a>
</HTML>