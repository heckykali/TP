<?php
session_start();

/* Database Connection */
$conn = mysqli_connect("localhost","root","","cosmatic_shop");

if(!$conn){
    die("Database Connection Failed");
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    $query = "SELECT * FROM admin WHERE email='$username' AND password='$password'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) == 1)
    {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    }
    else
    {
        echo "<script>alert('Invalid Username or Password'); window.location='index.php';</script>";
    }
}
?>