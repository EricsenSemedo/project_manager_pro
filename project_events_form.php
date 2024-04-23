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
            <form action="project_events_form.php" method="post">
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

<!-- gotta add datetime to start date end date of the event 