<html>
<head>
    <title> REGISTRATION </title>
    <style>
        body 
        {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;   /* Vertical Center */
            justify-content: center; /* Horizontal Center */
            /* Gradient Background */
            background:url("images/login_bg.jpg") no-repeat center center/cover;
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
        }

        form 
        {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 320px;
        }

        input, textarea 
        {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button, input[type="submit"] 
        {
            width: 100%;
            padding: 10px;
            background: #4ba3c7;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        button:hover, input[type="submit"]:hover
        {
            background: #0080ff;
        }
    </style>
</head>
<body>
    <form action="" method="POST">
        <h2 style="text-align:center; margin-bottom:20px;">Create an Account</h2>
        
        <input type="text" name="name" placeholder="Enter Name" required>

        <input type="email" name="email" placeholder="Enter Email" required>

        <input type="password" name="password" placeholder="Enter Password" required>

        <input type="text" name="phone" placeholder="Enter Phone Number" required>

        <textarea name="address" placeholder="Enter Address" required></textarea>

        <input type="submit" name="submit" value="Create">
        <center><p><a href="login.php">I have an account..! Login</a></p></center>
    </form>
</body>
</html>

<?php
    $conn = new mysqli("localhost", "root", "", "cosmatic_shop");

    if ($conn->connect_error) 
    {
        die("Connection Failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") 
    {
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $password = $_POST['password']; // password saved directly
        $phone    = $_POST['phone'];
        $address  = $_POST['address'];

        $sql = "INSERT INTO user (name, email, password, phone, address) 
                VALUES ('$name', '$email', '$password', '$phone', '$address')";

        if ($conn->query($sql) === TRUE)
        {
            echo "<script>alert('YOUR REGISTRATION IS COMPLETED SUCCESSFULLY...!!!');</script>";
            header("Location: login.php");
        }
        else 
        {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
?>

