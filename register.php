<h2>Register</h2>
<form method="post" action="">
<input type="text" name="user-name" />
<input type="text" name="password" />
<input type="submit" name="register-submit" value="Register" />
</form>
<?php
$con = mysqli_connect("localhost", "root", "", "");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    //echo "Connection OK !";
    mysqli_select_db($con, "myblog");
}
if(isset($_POST['register-submit'])){
    $userName = $_POST['user-name'];
    $password = $_POST['password'];

    $query = "INSERT INTO users (username, password) VALUES ('$userName', '$password')";
    $result = mysqli_query($con, $query);
    //printf("error: %s\n", mysqli_error($con));
    if($result){
        echo "Successfully registered !";
        echo "<a href='index.php' >Return to start page.</a>";
    }
    else{
        echo "Not registered ! Such username exist.";
    }
}
?>
