<?php

?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Project Tasks</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Project Tasks</h1>
            <form action="project_tasks.php" method="post">
                <input type="text" name="task_name" placeholder="Task Name">
                <input type="text" name="task_description" placeholder="Task Description">
                <input type="date" name="task_start_date">
                <input type="date" name="task_end_date">
                <input type="submit" name="submit" value="Add Task">
            </form>
        </div>
    </BODY>
</HTML>