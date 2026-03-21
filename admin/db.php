<?php
$conn = mysqli_connect("localhost","root","","cosmatic_shop");

if(!$conn){
    echo "<script>alert('Connection Failed!..');</script>";
    // die("Connection Failed : ".mysqli_connect_error());
}
?>