<!-- A form to insert sprints into database -->
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
        <TITLE>Add Sprints</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Add Sprint to Project</h1>
            <form action="project_sprints_form.php" method="post">
                <input type="text" name="sprint_title" placeholder="Sprint Name">
                <input type="text" name="sprint_description" placeholder="Sprint Description">
                <label>Start Date</label>
                <input type="datetime-local" name="sprint_startdatetime">
                <label>End Date</label>
                <input type="datetime-local" name="sprint_enddatetime">
                <input type="submit" name="submit" value="Add Event">
            </form>
        </div>
    </BODY>
</HTML>