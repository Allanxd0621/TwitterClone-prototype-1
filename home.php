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


//POSTINGGGG 

$empty = false;
$emptyReply = '';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST['postTitle']) || empty($_POST['postBody']) || empty($_POST['poster'])){

        //check if user inputted something if not then error gud 
        $empty = true;
        $emptyReply = 'Title or Body needs input';

    }
    if(!$empty){
        //if nothing is wrong then upload it into table and then the data from the table echoed in the post holders

        $postTitle = $_POST['postTitle'];
        $postBody = $_POST['postBody'];
        $poster = $_POST['poster'];

        $postSql = "INSERT INTO posts (postTitle, postBody , poster) VALUES ('$postTitle' , '$postBody' , '$poster')";

        mysqli_query($cann , $postSql);


    }
}

    $postSql = "SELECT * FROM posts ORDER BY postId DESC";

    $postResult = mysqli_query($cann , $postSql);

    //I will now use while loops to get every row on each column in post table to be put inside our post holders 

   




    


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
        <img src="../assets/profileIcon.webp" alt="" id="profileCheck">
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
        <p>This is a website I created as a project to test my php and MySQL skills. The CSS was built by Codex because I hate doing CSS it's so time consuming and repeatative. But ofcourse I edited some designs since I know every single code it gives me I did start with CSS after all. I just did the JavaScript Php, html, and ofcourse the Database.</p>
    </div>

<!-- This shall be the holder for all of the posts -->

<?php while($dataPost = mysqli_fetch_assoc($postResult)){ ?>
    <div class="postContainer">
        <h3 class="poster">
            <?= htmlspecialchars($dataPost['poster'])??'' ?>
         </h3>
        <h1 class="postTitle">
            <?= htmlspecialchars($dataPost['postTitle'])??''  ?>
        </h1>
        <p class="postBody">
            <?= htmlspecialchars($dataPost['postBody'])??'' ?>
        </p>
    </div>

<?php }?>

</main>

<footer>
    <button id="postBtn">+</button>
</footer>


<!--POST SECTION HERE-->

<header>
    <h1>POST SECTION</h1>
    <div class="postForm">
        <form method="post">
            <input type="text" name="postTitle" placeholder="Enter Title">
            <input type="text" name="postBody" placeholder="What's on your Mind? shesh">
            <input type="hidden" name="poster" value="<?= htmlspecialchars($userData['username'])??'' ?>" readonly> <!--TO KNOW WHO POSTS-->
            <p id="emptyReply"><?= $emptyReply; ?></p>
            <button type="submit">POST</button>
        </form>
    </div>
</header>



<script src="../src/profile.js"></script>
</body>
</html>
