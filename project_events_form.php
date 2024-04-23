<!-- A form to insert event into database -->
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
        $event_title = $_POST["event_title"];
        $event_description = $_POST["event_description"];
        $event_location = $_POST["event_location"];
        $event_start_dateTime = $_POST["event_start_dateTime"];
        $event_end_dateTime = $_POST["event_end_dateTime"];

        //check if any of the fields are empty 
        if(empty($event_title) || empty($event_description) || empty($event_location) || empty($event_start_dateTime) || empty($event_end_dateTime)){
            $errorMessage = "Please fill out all fields";
            exit;
        }

        //sql statement insets into events
        $sql = "INSERT INTO Event (location, project_id, event_title, event_description, start_date, end_date)
            VALUES (:location, :project_id, :event_title, :event_description, :start_date, :end_date);";

        try{
            pdo($pdo, $sql, ["location" => $event_location, "project_id" => $project_id, "event_title" => $event_title, "event_description" => $event_description, "start_date" => $event_start_dateTime, "end_date" => $event_end_dateTime]);
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
        <TITLE>Add Events</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Add a Event to project</h1>
            <form action="project_events_form.php?id=<?= $project_id ?>" method="post">
                <input type="text" name="event_title" placeholder="Event Title:">
                <input type="text" name="event_description" placeholder="Event Description:">
                <input type="text" name="event_location" placeholder="Event Location:">
                <label>Start Date</label>
                <input type="datetime-local" name="event_start_dateTime">
                <label>End Date</label>
                <input type="datetime-local" name="event_end_dateTime">
                <input type="submit" name="submit" value="Add Event">
            </form>
        </div>
    </BODY>
</HTML>

