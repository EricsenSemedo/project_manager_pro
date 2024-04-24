<?php
    require 'includes/database-connection.php'; // Require the database connection file

    session_start();

    $errorMessage = "";

    // Check if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        // Redirect the user to the login page
        header("Location: login.php");
        exit;
    }
    
    $project_id = $_GET["id"];

    //check if the user is a member of the project

    //get the user_id from the session 
    $user_id = $_SESSION["user_id"];

    // Check if the form has been submitted
    if(!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        
        //check if first name and last name and email are not empty
        if(empty($first_name) || empty($last_name) || empty($email)){
            $errorMessage = "Please fill in all fields";
        }
        
        //sql statement to get the user_id of the member
        $sql = "SELECT user_id
            FROM Users
            WHERE first_name = :first_name AND last_name = :last_name AND email = :email;";

        //sql statement to add member to project
        $sql2 = "INSERT INTO Project_members (project_id, user_id, role)
            VALUES (:project_id, :user_id, 0);";
     
        try{
            //execute sql statement to get the user_id of the member
            $user = pdo($pdo, $sql, ["first_name" => $first_name, "last_name" => $last_name, "email" => $email])->fetch();
            
            //execute sql statement to add member to project_members
            pdo($pdo, $sql2, ["project_id" => $project_id, "user_id" => $user["user_id"]]);

            //redirect to project_view.php
            header("Location: project_view.php?id=$project_id");
            exit;
        }catch(PDOException $e){
            
            //if member is already in project
            if($e->errorInfo[1] == 1062){
                $errorMessage = "Member is already in project";
            }
            else{
                //display error message
                $errorMessage = "Error adding member to project";
            }
        }    
    }

?>

<!DOCTYPE>
<HTML>
    <HEAD>
        <TITLE>Add member</TITLE>
        <link rel="stylesheet" href="css/style.css">
    </HEAD>
    <BODY>
        <div class="project">
            <h1>Add member to Project</h1>
            <form action="project_add_member_form.php?id=<?= $project_id ?>" method="post">
                <input type="text" name="first_name" placeholder="Member First Name">
                <input type="text" name="last_name" placeholder="Member Last Name">
                <input type="text" name="email" placeholder="Member Email">
                <input type="submit" name="submit" value="Add Member">
            </form>
        </div>
        <p><?= $errorMessage ?></p>
    </BODY>
    <a href="project_view.php?id=<?= $project_id ?>">Back to Project View</a>
</HTML>