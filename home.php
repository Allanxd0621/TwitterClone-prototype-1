<?php 
//HOme page 
//for the post table there will be Post title the Post content and finally the number of likes and dislikes 

//i wont put comment section and photos for now since this is just a prototype

//the whole posting containers will be done using while loops that would get the datas from the post table that i will just echo 

//there will be posting section button at the bottom like a plus button that will be centered for easy access 

//the profile section will allow user to update their profile informations like username password and soon will be the profile pictures


//the table
/*

create table posts(
postId INT AUTO_INCREMENT PRIMARY KEY,
poster VARCHAR(200) NOT NULL,
postTitle VARCHAR(100) NOT NULL,
postBody VARCHAR(1000) NOT NULL,
likes INT, 
dislikes INT
);

*/

//also using sessions so that the user will be automatically have his datas inputted in the home page after logging in 

//i was thinking to update my user table to include a userPost column that would include the post title so that there will be the same post will be connected from the user table and the post table 

//so i just alter table users add postTitle varchar  

session_start();

$id = $_SESSION['$id'];

$cann = mysqli_connect('localhost' , 'root' , '' , 'simpleFacebook_db');


if(!$cann){
    die("Connection Failed");
}

$userSQL = "SELECT * FROM users WHERE id = $id ";

$resultUser = mysqli_query($cann , $userSQL);

$userData = mysqli_fetch_assoc($resultUser); 
//same idea on my log in page but i just name it as user because there will be another fetch assoc for the posts 

   $username = $userData['username'];





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../assets/profile.css">
</head>
<body>
    
    <header>
        <h1>Allan's Twitter </h1>
        <img src="profileIcon.webp" alt="" id="profileCheck">
<!-- THis will be a button to show the profile section-->
    </header>

    <section id="profileSection">
        <header>
            <h1>PROFILE SECTION </h1>
            <button id="exitProfileBtn">X</button>
        </header>
        <h1> <?= htmlspecialchars($userData['username'])??''?></h1>
        <h1>POST: <?= htmlspecialchars($userData['postTitle'])??''?></h1>

    </section>


<main class="newsFeed">
<!-- This wll hold all the posts -->

<!-- MEssage from me -->

    <div class="devMessage">
        <h1>Hi I am Allan!</h1>
        <p>This is a website I created as a project to test my php and MySQL skills. The CSS was built by Codex because I hate doing CSS it's so time consuming and repeatative. But I know every single code it gives me I did start with CSS after all. I just did the JavaScript Php, html, and ofcourse the Database.</p>
    </div>

<!-- This shall be the holder for all of the posts -->


    <div class="postContainer">
        <h1 class="postTitle"></h1>
    </div>

</main>


<script src="../src/profile.js"></script>
</body>
</html>