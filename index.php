<?php
$host="localhost";
$user="root";
$password="";
$db="user";
$data=mysqli_connect($host,$user,$password,$db);
if($data==false){
    die("Connection error");
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST["username"];
    $password=$_POST["password"];

    $sql="select * from user where username='".$username."'  AND password='".$password."'";
    $result=mysqli_query($data,$sql);

    $row=mysqli_fetch_array($result);

    if($row["usertype"]=="user"){
       header("location:userhome.php");
    }

    elseif($row["usertype"]=="admin"){
        header("location:adminhome.php");
    }
    else{
        echo "Invalid data";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <center>
        <h1>Login form</h1>
        <div style="background-color: grey; width: 500px ; padding: 10px;" >
            <form action="#" method="post">
            <div style="height: 70px;">
                <label for="username" >username</label>
                <input type="text" name="username" required>
            </div>
            <div style="height: 70px;">
                <label for="password">password</label>
                <input type="password" name="password" required>
            </div>

            <div>
                <input type="submit" value="Login">
            </div>
            </form>
        </div>
    </center>
</head>
<body>
    
</body>
</html>