<?php
session_start();
//var_dump($_GET);
//die();
if(isset($_SESSION['username']) && $_SESSION['username'] === "admin") {
    $con = mysqli_connect("localhost", "root");
    if(!$con){
        die("DB connection failed.");
    }
    else{
        mysqli_select_db($con, "myblog");
        $query = "DELETE FROM comments WHERE comment_id='$_GET[commentId]'";
        //var_dump($query);
        $result = mysqli_query($con, $query);
        if($result){
            echo 'true';
            //echo "Post deleted succesfully !";
            //echo "<br>";
            //echo "<a href='index.php'>Return to start page.</a>";
        }
        else{
            echo 'false';
            //echo "Post delete failed !";
        }
    }
}
else{
    echo "Access forbidden !";
}
?>