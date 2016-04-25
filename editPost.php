<?php
session_start();
if(isset($_SESSION['username']) && $_SESSION['username'] === "admin"){
    $con = mysqli_connect("localhost", "root", "", "");
    if(!$con){
        die("DB connection failed");
    }
    else{
        mysqli_select_db($con, "myblog");

        //echo (bool)$_GET['isPostEdited'];
        if($_GET['isPostEdited'] == 'false') {
            ?>
            <h2>Edit Post</h2>
            <form method="post" action="">
                <input type="text" name="edit-title" placeholder="Post Title" style="display: block" value="<?php echo $_GET['title'] ?>"/>
                <textarea name="edit-content" cols="50" rows="20" style="display: block; margin-top: 5px">
                    <?php echo $_GET['content'] ?>
                </textarea>
                <input type="text" name="edit-tags" placeholder="Post Tags" style="display: block; margin-top: 5px" value="<?php echo $_GET['tags'] ?>"/>
                <input type="submit" name="edit-post-submit" value="Edit post" style="display: block; margin-top: 5px"/>
            </form>
            <?php
        }
        else{
            echo "Post edit OK !";
        }
        if(isset($_POST['edit-post-submit'])){
            $editedTitle = $_POST['edit-title'];
            $editedContent = $_POST['edit-content'];
            $editedTags = $_POST['edit-tags'];
            $oldTitle = $_GET['title'];
            $query = "UPDATE posts SET title='$editedTitle', content='$editedContent', tags='$editedTags' WHERE title='$oldTitle'";
            //echo $query;
            $result = mysqli_query($con, $query);
            if($result){
                header('Location: /MyBlog/editPost.php?isPostEdited=true/');
            }
            else{
                echo "Post edit NOT OK !";
            }
        }
        echo "<br>";
        echo "<a href='index.php'>Return to start page.</a>";
    }
}
else{
    echo "Access forbidden !";
}
?>