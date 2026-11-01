<?php 
// in my sql there will be a table for users and table for posts 

//first a sign up create account page 

//for the css and boiler plates i will just ask codex to design it for me I dont wanna waste my time centering forms although I already mastered it using display flex 



$cann = mysqli_connect('localhost' , 'root' , '' , 'simpleFacebook_db');

if(!$cann){ // check if user connected to database
die("Connection Failed");
}

$error = false; // checker boolean
$lack = ''; //lacking placeholder 

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty($_POST['username']) || empty($_POST['password'])){
            //if there is empty inputs then error is true and lacking will be given value 

            $error = true;
            $lack = 'Error lacking inputs';
        }
        if(!$error){
            //if there is no error then we get that input values and put it inside our database

            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "INSERT INTO users (username , password) 
            VALUES ('$username' , '$password')";

            mysqli_query($cann , $sql);
            
            header('location: login.php');
            exit();

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up Page</title>
    <link rel="stylesheet" href="../assets/auth.css">
</head>
<body>
    <form method="post">
        <h1>CREATE ACCOUNT</h1>

        <input type="text" placeholder="create username" name="username">
        <input type="password" placeholder="create password" name="password">

        <button type="submit">CREATE</button>
         <div class="login-link">
            <p>Already have an account?</p>
            <a href="login.php">Log in</a>
        </div>
        <p><?= $lack; ?></p>
       
    </form>
</body>
</html>
