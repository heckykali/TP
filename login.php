<?php
$conn = new mysqli("localhost", "root", "", "cosmatic_shop");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $name = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user WHERE email = '$name' AND password = '$password' ";
        if ($conn->query($sql) && $conn->affected_rows > 0) {
            echo "<script>alert('LOGIN SUCCESSFULLY...!!!');</script>";
            session_start();
            $_SESSION['username'] = $name;
            header("Location: home.php");
        } else {
            echo "<script>alert('LOGIN FAILED...!!!');</script>";
            // echo "Error: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    <style>
        /* Page Background */

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #fff, #2193b0);
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Login Box */

        .box {
            background: #fff;
            padding: 35px;
            width: 320px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Title */

        .box h2 {
            margin-bottom: 25px;
            color: #333;
        }

        /* Input Fields */

        .input-field {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        /* Button */

        .btn {
            width: 95%;
            padding: 12px;
            margin-top: 15px;
            background: #2193b0;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #176c85;
        }

        /* Link */

        .link {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #2193b0;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="box">

        <h2>User Login</h2>

        <form method="POST">

            <input type="text" name="username" class="input-field" placeholder="Enter Email" required>

            <input type="password" name="password" class="input-field" placeholder="Enter Password" required>

            <button type="submit" class="btn">Login</button>

        </form>

        <a href="registration.php" class="link">Don't have an account? Create one</a>

    </div>

</body>

</html>