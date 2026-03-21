<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | GlowNest</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <form method="POST" action="admin_login.php">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>