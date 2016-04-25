<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "");
if(!$con){
    die("Connection failed: " . mysqli_connect_error());
}
else{
    mysqli_select_db($con, "myblog");
}
if(isset($_SESSION['username']) && $_SESSION['username'] === "admin") {
?>
    <h2>Add Post</h2>
    <form method="post" action="">
        <input type="text" name="post-title" placeholder="Post Title" required style="display: block" />
        <textarea name="post-content" cols="50" rows="20" style="display: block; margin-top: 5px">
            Enter Post content here.
        </textarea>
        <input type="text" name="post-tags" placeholder="Post Tags" style="display: block; margin-top: 5px" />
        <input type="submit" name="add-post-submit" value="Add post" style="display: block; margin-top: 5px" />
    </form>
    <a href='index.php' >Return to start page.</a>
<?php
    if(isset($_POST['add-post-submit'])){
        $postTitle = $_POST['post-title'];
        $postContent = $_POST['post-content'];
        $postTags = $_POST['post-tags'];

        $query = "INSERT INTO posts (title, content, tags) VALUES ('$postTitle', '$postContent', '$postTags')";
        $result = mysqli_query($con, $query);

        if($result){
            echo "Post added succesfuly !";
        }
        else{
            echo "Post not added !";
        }
    }
}
else{
    echo "Access forbidden !";
}
?>