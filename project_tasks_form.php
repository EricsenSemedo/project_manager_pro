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
            <form action="project_tasks_form.php" method="post">
                <input type="text" name="task_title" placeholder="Task Name">
                <input type="text" name="task_description" placeholder="Task Description">
                <input type="text" name="task_status" placeholder="Task Status">
                <input type="submit" name="submit" value="Add Task">
            </form>
        </div>
    </BODY>
</HTML>