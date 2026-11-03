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

$cann = mysqli_connect('sql303.infinityfree.com' , 'if0_43331319' , 'mIlktea12' , 'if0_43331319_allanTwitter_db');


if(!$cann){
    die("Connection Failed");
}

$userSQL = "SELECT * FROM users WHERE id = $id ";

$resultUser = mysqli_query($cann , $userSQL);

$userData = mysqli_fetch_assoc($resultUser); 
//same idea on my log in page but i just name it as user because there will be another fetch assoc for the posts 

   $username = $userData['username'];


//POSTINGGGG 

// POSTING

$empty = false;
$emptyReply = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty($_POST['postTitle']) || empty($_POST['postBody'])) {
        $empty = true;
        $emptyReply = 'Title or Body needs input';
    }

    if (!$empty) {

        $postTitle = trim($_POST['postTitle']);
        $postBody = trim($_POST['postBody']);
        $poster = $username;

        // No photo by default
        $photoName = null;

        // CHECK IF USER UPLOADED A PHOTO
        if (isset($_FILES['postPhoto']) &&
            $_FILES['postPhoto']['error'] != UPLOAD_ERR_NO_FILE) {

            if ($_FILES['postPhoto']['error'] != UPLOAD_ERR_OK) {
                $empty = true;
                $emptyReply = 'Photo upload failed.';
            }

            elseif ($_FILES['postPhoto']['size'] > 5 * 1024 * 1024) {
                $empty = true;
                $emptyReply = 'Photo must not exceed 5MB.';
            }

            else {

                // CHECK IMAGE TYPE
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($_FILES['postPhoto']['tmp_name']);

                $allowedTypes = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp'
                ];

                if (!isset($allowedTypes[$mime])) {
                    $empty = true;
                    $emptyReply = 'Only JPG, PNG, and WEBP images are allowed.';
                }

                else {

                    // GENERATE UNIQUE FILENAME
                    $photoName = bin2hex(random_bytes(16)) . '.' . $allowedTypes[$mime];

                    // DESTINATION FOLDER
                    $uploadPath = __DIR__ . '/../postPhotos/' . $photoName;

                    if (!move_uploaded_file(
                        $_FILES['postPhoto']['tmp_name'],
                        $uploadPath
                    )) {
                        $empty = true;
                        $emptyReply = 'Unable to save uploaded photo.';
                    }
                }
            }
        }

        // INSERT POST INTO DATABASE
        if (!$empty) {

            $postSql = "INSERT INTO posts
                        (postTitle, postBody, poster, postPhoto)
                        VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($cann, $postSql);

            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $postTitle,
                $postBody,
                $poster,
                $photoName
            );

            if (mysqli_stmt_execute($stmt)) {

                header("Location: home.php");
                exit();

            } else {

                // Remove uploaded image if database insertion fails
                if ($photoName !== null) {
                    unlink(__DIR__ . '/../postPhotos/' . $photoName);
                }

                $emptyReply = 'Failed to create post.';
            }
        }
    }
}

// RETRIEVE POSTS
$postSql = "SELECT * FROM posts ORDER BY postId DESC";
$postResult = mysqli_query($cann, $postSql);

    


    //I will now use while loops to get every row on each column in post table to be put inside our post holders 

   




    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../assets/profile.css">
    <link rel="stylesheet" href="../assets/home.css">
    <link rel="stylesheet" href="../assets/post.css?v=2">
</head>
<body>
    
    <header>
        <h1>Allan's Newsfeed</h1>
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



<?php 

//THIS IS FOR LIKE AND DISLIKE 

//if naay like inputted then get the post ID of that specific post and update the likes row + 1

if (isset($_POST['like'])) {

    $postId = (int) $_POST['postId'];

    $sql = "UPDATE posts SET likes = likes + 1 WHERE postId = ?";
    $stmt = mysqli_prepare($cann, $sql);

    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);

    header("Location: home.php");
    exit();
}

//same thing if nay inputted dislike get the post id in that post and update its dislike row by increment 1

if (isset($_POST['dislike'])) {

    $postId = (int) $_POST['postId'];

    $sql = "UPDATE posts SET dislikes = dislikes + 1 WHERE postId = ?";
    $stmt = mysqli_prepare($cann, $sql);

    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);

    header("Location: home.php");
    exit();
}

//for the like and dislike buttons lets just create two separate forms each has inputs of likes and dislikes and two individual submit buttons 
?>



<!-- This shall be the holder for all of the posts -->

<?php while($dataPost = mysqli_fetch_assoc($postResult)){ ?>
   
    <div class="postContainer">

    <h3 class="poster">
        <?= htmlspecialchars($dataPost['poster']) ?>
    </h3>

    <h1 class="postTitle">
        <?= htmlspecialchars($dataPost['postTitle']) ?>
    </h1>

    <?php if (!empty($dataPost['postPhoto'])) { ?>
        <img
            src="../postPhotos/<?= htmlspecialchars($dataPost['postPhoto']) ?>"
            alt="Post Photo"
            class="postPhoto"
        >
    <?php } ?>

    <p class="postBody">
        <?= htmlspecialchars($dataPost['postBody']) ?>
    </p>

    <?php ?>



<div class="likeAndDislike">

    <form method="post">
        <input type="hidden" 
               name="postId" 
               value="<?= $dataPost['postId'] ?>">

        <button type="submit" name="like">
            ♡ <?= $dataPost['likes'] ?>
        </button>
    </form>

    <form method="post">
        <input type="hidden" 
               name="postId" 
               value="<?= $dataPost['postId'] ?>">

        <button type="submit" name="dislike">
            ☹ <?= $dataPost['dislikes'] ?>
        </button>
    </form>

</div>

</div>




<?php }?>

</main>

<footer>
    <button id="postBtn">+</button>
</footer>


<!--POST SECTION HERE-->


<div class="postForm">
<header>
    <h1>POST SECTION</h1>
    <button id="postExitBtn">X</button>
</header>

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="postTitle" placeholder="Enter Title">
            <input type="text" name="postBody" placeholder="What's on your Mind? shesh">
            <input type="file" name="postPhoto">
            <input type="hidden" name="poster" value="<?= htmlspecialchars($userData['username'])??'' ?>" readonly> <!--TO KNOW WHO POSTS-->
            <p id="emptyReply"><?= $emptyReply; ?></p>
            <button type="submit" id="postBtn1">POST</button>
        </form>
    </div>



<script src="../src/profile.js"></script>
<script src="../src/post.js"></script>
</body>
</html>
