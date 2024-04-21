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
        <TITLE>Project Events</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Project Events</h1>
            <form action="project_events.php" method="post">
                <input type="text" name="event_name" placeholder="Event Name">
                <input type="text" name="event_description" placeholder="Event Description">
                <input type="date" name="event_date">
                <input type="time" name="event_time">
                <input type="submit" name="submit" value="Add Event">
            </form>
        </div>
    </BODY>
</HTML>