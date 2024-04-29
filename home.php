<?php
    require "includes/database-connection.php"; // Require the database connection file

    session_start(); // Start a new session so that we can save and retrieve the user's data across multiple pages

    // Check if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        $_SESSION["error_message"] = "You must be logged in to access that page.";

        // Redirect the user to the login page
        header("Location: login.php");
        exit;
    }

    // Get the user_id from the session
    $user_id = $_SESSION["user_id"];

    function getUserFirstName(PDO $pdo, int $user_id) {
        $sql = "SELECT first_name
            FROM Users
            WHERE user_id = :user_id;";
        $user = pdo($pdo, $sql, ["user_id" => $user_id])->fetch();

        return $user["first_name"];
    }


    //function that grabs projects user owns 
    function getUserProjects(PDO $pdo, int $user_id) {
        $sql = "SELECT project_id, title, description
            FROM Projects
            WHERE user_id = :user_id;";
        $projects = pdo($pdo, $sql, [":user_id" => $user_id]);

        return $projects;
    }
    
    //function that grabs projects user is a part of 
    function getUserPartOfProjects(PDO $pdo, int $user_id) {
        //get the projects user is a member of but isnt the owner
        $sql = "SELECT p.title, p.description
            FROM Projects p
            JOIN Project_members pm ON p.project_id = pm.project_id  
            WHERE pm.user_id = :user_id1
            AND p.user_id != :user_id2;";
        
        try{
            $projects = pdo($pdo, $sql, ["user_id1" => $user_id, "user_id2" => $user_id] )->fetchAll();  
            return $projects;
        }catch(PDOException $e){
            echo $e->getMessage();
            return [];
        }
       
    }

    $errorMessage = NULL;

    // Check if the form has been submitted
    if (!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Retrieve the name and description from the form
        $title = $_POST["project-name"];
        $description = $_POST["project-description"];
        //check name and description of the project are not empty
        if(empty($title) || empty($description)){
            echo "Name and description of the project cannot be empty";
            exit;
        }

        //create sql statement to insert project into the database
        $sql = "INSERT INTO Projects (title, description, user_id)
            VALUES (:title, :description, :user_id);";
        
        try {
            // Execute the SQL statement
            pdo($pdo, $sql, [":title" => $title, ":description" => $description, ":user_id" => $user_id]);   
        } catch (PDOException $e) {
            // display error message if there is an error
            $errorMessage = $e->getMessage();
        }

        unset($title, $description); // Unset the variables to clear the form (optional
    }

    // Get the user's first name
    $first_name = getUserFirstName($pdo, $user_id);

    //get the projects user owns
    $owned_projects = getUserProjects($pdo, $user_id);

    //get the projects user is a member of but isnt the owner 
    $projects_user_part_of = getUserPartOfProjects($pdo, $user_id);
?>

<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="css/style.css">

        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #285b99; /* Background color */
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center; /* Center align horizontally */
                align-items: center; /* Center align vertically */
                height: 100vh; /* Full height of viewport */
                position: relative;
            }

            button {
                width: calc(100% - 20px);
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #cccccc; /* Input border color */
                border-radius: 5px;
                box-sizing: border-box;
            }

            button {
                background-color: #007bff; /* Button background color */
                color: #ffffff; /* Button text color */
                cursor: pointer;
            }

            button:hover {
                background-color: #0056b3; /* Button background color on hover */
            }

            h1 {
                text-align: center;
                color: #290000; /* Heading color */
            }

            form {
                background-color: #dedede; /* Form background color */
                padding: 50px;
                border-radius: 25px;
                box-shadow: 0px 0px 40px 0px rgba(150, 170, 250,0.25); /* Shadow effect */
                width: calc(33.33% - 20px); /* Each form takes up roughly one-third of the available space */
                margin: 0 25px; /* Added margin between forms */
            }

            label {
                display: block;
                margin-bottom: 10px;
                color: #000000; /* Label color */
            }

            .top_left_text {
                position: absolute; /* Position absolute to place it at the top left corner */
                top: 20px; /* Adjust top position as needed */
                left: 20px; /* Adjust left position as needed */
            }

            .logout-button {
                display: block;
                width: 68%;
                background-color: #dc3545;
                color: #fff;
                border: none;
                padding: 10px;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                text-align: center;
                margin-top: 20px;
            }

            .create-project {
                width: 30%;
            }

            .logout-button:hover {
                background-color: #c82333;
            }

        </style>
        
    </head>
    <body>
        
        <div class="top_left_text">
            <h1><?= "Hello, ", $first_name, " this is your home page"?></h1>
        </div>
        
        <form class="home">
            <div class="projects-you-own">
                <h2>Projects you own</h2>
                <ul>
                    <?php foreach ($owned_projects as $project): ?>
                        <li>
                            <a href="project_view.php?id=<?= $project["project_id"] ?>"><h3><?= $project["title"] ?></h3></a>
                            <p><?= $project["description"] ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </form>

        <form class="home">
            <div class="projects-you-are-part-of">
                <h2>Projects you are a member of</h2>
                <ul>
                    <?php foreach ($projects_user_part_of as $project): ?>
                        <li>
                        
                            <a href="project_view.php?id=<?= $project["project_id"] ?>"><h3><?= $project["title"] ?></h3></a>
                            <p><?= $project["description"] ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </form>
            
        <div class="create-project">
            <form action="home.php" method="POST">
                <h1>Create Project</h1>
                <label for="project-name">Project Name:</label>
                <input type="text" name="project-name" id="project-name" required>
                <label for="project-description">Project Description:</label>
                <input type="text" name="project-description" id="project-description" required>
                <button type="submit">Create</button>
            </form>
            <div class="container">
                <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>
        
        <?php if ($errorMessage): ?>
            <p class="error"><?= $errorMessage ?></p>
        <?php endif;?>

    </body>
</html>