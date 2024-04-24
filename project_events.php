<!-- A form to insert event into database -->
<!-- Project settings button
    Add user
    Remove user
-->
<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit;
    }
    elseif (!isset($_GET["id"])) {
        // Redirect the user to the login page
        header("Location: project_view.php");
        exit;
    }

    function getEventDetails (PDO $pdo, int $event_id){
        $sql = "SELECT location, event_title AS title, event_description AS description, start_date, end_date
            FROM Event
            WHERE event_id = :event_id;";
        $project = pdo($pdo, $sql, ["event_id" => $event_id])->fetch();

        return $project;
    }
    
    $event_id = $_GET["id"];
    $eventDetails = getEventDetails($pdo, $event_id);
?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Project Events</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <header>
            <h1><?php echo $eventDetails["title"]; ?></h1>
            <a class="logout-button" href="logout.php">Logout</a>
        </header>

        <main>
            <p><?php echo "Start: ", $eventDetails["start_date"]; ?> </p>
            <p><?php echo "End: ", $eventDetails["end_date"]; ?> </p>
            <p><?php echo $eventDetails["location"]; ?></p>
            <p><?php echo $eventDetails["description"]; ?></p>
        </main>
    </BODY>
</HTML>