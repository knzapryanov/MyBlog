<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "");
if(!$con){
    die("Connection failed: " . mysqli_connect_error());
}
else{
    mysqli_select_db($con, "myblog");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Start Page
        </title>
        <link rel="stylesheet" type="text/css" href="indexPageStyles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="myScripts.js"></script>
    </head>
    <body>
        <?php if(!isset($_SESSION['user_id'])): ?>
        <div id="registration-login-div">
            <div id="login-div">
                <form method="post" action="">
                    <input type="text" name="user-name" placeholder="Username" />
                    <input type="text" name="password" placeholder="Password" />
                    <input type="submit" value="Login" name="login-submit" />
                </form>
            </div>
            <div id="registration-div">
                <a href="register.php" >Register</a>
            </div>
        </div>
        <?php endif; ?>
        <h2>View all posts</h2>
        <?php

        if(isset($_POST['login-submit'])){
            $userName = $_POST['user-name'];
            $password = $_POST['password'];

            $query = "SELECT user_id, username FROM users WHERE username = '$userName' AND password = '$password'";
            $result = mysqli_query($con, $query);
            $user = mysqli_fetch_assoc($result);

            if(empty($user)){
                echo "Invalid details";
            }
            else{
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
            }
        }

        if(isset($_SESSION['user_id'])){
            $userId = $_SESSION['user_id'];
            $query = "SELECT user_id, username FROM users WHERE user_id = '$userId'";
            $result = mysqli_query($con, $query);
            $user = mysqli_fetch_assoc($result);

            echo "Welcome {$user['username']} !";
            echo "<br><a href='?logout=true'>Logout</a>";
        }

        if(isset($_GET['logout']) && $_GET['logout']) {
                session_destroy();
                header('Location: /MyBlog/');
        }

        if(isset($_SESSION['username']) && $_SESSION['username'] === "admin"){
            ?>
            <div class="admin-options">
                <a href="addPost.php">Add Post</a>
            </div>
            <?php
        }

        $query = "SELECT id, title, content, tags FROM posts";
        $result = mysqli_query($con, $query);
        while($post = mysqli_fetch_assoc($result)){
            echo "<div class='post-div' id='$post[title]'>";
            echo "<span class='description'>Post title:</span>";
            echo $post['title'];
            echo "<br>";
            echo "<span class='description'>Content:</span>";
            echo $post['content'];
            echo "<br>";
            echo "<span class='description'>Tags:</span>";
            echo $post['tags'];

            echo "<div class='comments-div'>";
            echo "<span class='description'>Comments:</span>";

            $postId = $post['id'];
            $query = "SELECT comment_id, user, comment_content, dateandtime FROM comments WHERE post_id=$postId";
            $commentResultQuery = mysqli_query($con, $query);
            while($currentComment = mysqli_fetch_assoc($commentResultQuery)){
                echo "<div class='current-comment-div' id='commentIdNum$currentComment[comment_id]'>";
                echo "From: $currentComment[user]";
                echo "<br>";
                echo "Comment: $currentComment[comment_content]";
                echo "<br>";
                echo "Date: $currentComment[dateandtime]";
                if(isset($_SESSION['username']) && $_SESSION['username'] === "admin"){
                    ?>
                    <input type="button" class="deleteCommentBUtton" value="Delete comment" onclick="deleteCommentAJAX(<?php echo $currentComment['comment_id']; ?>)"></input>
                    <?php
                }
                echo "</div>";
            }

            ?>
            <form method="post" class="comment-form" action="javascript:void(0)" id="newCommentForm<?php echo $postId ?>" >
                <textarea name="user-comment" rows="3" cols="80" id="userCommentPostNum<?php echo $postId ?>">
                </textarea>
                <input type="hidden" id="postId" name="comment-postid" value="<?php echo $postId ?>" />
                <input type="button" value="Add comment" onclick="insertCommentAJAX(document.getElementById('userCommentPostNum<?php echo $postId ?>').value, <?php echo $postId ?>)" />
            </form>
            <?php
            echo "</div>";

            if(isset($_SESSION['username']) && $_SESSION['username'] === "admin"){
                echo "<br>";
                echo "<br>";
                echo "<span class='description'>Admin options:</span>";
                //echo "<a href='deletePost.php?title=$post[title]'>Delete Post</a>";
                ?>
                <input type="button" onclick="deletePostAJAX('<?php echo $post['title']; ?>')" value="Delete Post">
                <?php
                echo "<a href='editPost.php?title=$post[title]&content=$post[content]&tags=$post[tags]&isPostEdited=false' style='margin-left: 10px;'>Edit Post</a>";
            }
            echo "</div>";
        }
        ?>
    </body>
</html>