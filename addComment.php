<?php
session_start();
//var_dump($_POST);
//die();
$con = mysqli_connect("localhost", "root", "", "");
if($con){
    mysqli_select_db($con, "myblog");

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }
    else{
        $username = "Anonymous";
    }

    $commentPostid = $_POST['postId'];
    $commentContent = $_POST['userComment'];
    $commentDateAndTime = date('Y-m-d H:i:s');
    //echo $commentDateAndTime;
    $query = "INSERT INTO comments (post_id, user, comment_content, dateandtime) VALUES ('$commentPostid', '$username', '$commentContent', '$commentDateAndTime')";
    $result = mysqli_query($con, $query);

    if($result){
        echo json_encode(
            array(
                "userComment" => $commentContent,
                "postId" => $commentPostid,
                "date" => $commentDateAndTime,
                "user" => $username,
                "lastInsertedCommentId" =>  mysqli_insert_id($con)
         ));
        //echo "<br>";
        //echo "<a href='index.php' >Return to start page.</a>";
    }
    else{
        echo "false";
    }
}
else{
    die("DB connection failed !");
}
?>