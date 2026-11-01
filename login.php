<?php 
//same log in 

session_start();

$cann = mysqli_connect('localhost' , 'root' , '' , 'simpleFacebook_db');

if(!$cann){
    die("Connection Failed");
}

$error = false;
$lack = '';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(empty($_POST['username']) || empty($_POST['password'])){

            $error = true;
            $lack = 'Error inputs are empty.';


        }

        if(!$error){

            $username = $_POST['username'];
            $password = $_POST['password'];


            $sql = "SELECT * FROM users WHERE username = '$username' ";


            $result = mysqli_query($cann , $sql);
            //bring request to db and we gonna get the whole row

            $data = mysqli_fetch_assoc($result);


            if($username == $data['username'] && $data['password'] == $password){


                $id = $data['id']; //using sessions to transfer data from login to home page 
                $_SESSION['$id'] = $id; // i will bring this session to home page
                header('location: ../home/home.php');
                exit();

            }else{
                $lack = 'wrong credentials bitch';
            }
        

        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In Page</title>
    <link rel="stylesheet" href="../assets/login.css">
</head>
<body>
    
    <form method="post">
        <h1>LOG IN</h1>

        <input type="text" placeholder="Enter your username" name="username">
        <input type="password" placeholder="Enter your password" name="password">

        <button type="submit">Log In</button>
         <div class="login-link">
            <p>Dont have an account?</p>
            <a href="index.php">Sign up</a>
        </div>
        <p><?= $lack; ?></p>
       
    </form>

</body>
</html>