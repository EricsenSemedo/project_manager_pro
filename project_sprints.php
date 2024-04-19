<?php

?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Project Sprints</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Project Sprints</h1>
            <form action="project_sprints.php" method="post">
                <input type="text" name="sprint_name" placeholder="Sprint Name">
                <input type="text" name="sprint_description" placeholder="Sprint Description">
                <input type="date" name="sprint_start_date">
                <input type="date" name="sprint_end_date">
                <input type="submit" name="submit" value="Add Sprint">
            </form>
        </div>
    </BODY>
</HTML>