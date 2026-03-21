<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: account.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "cosmatic_shop");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$success = "";

if(isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO contact (name,email,message) 
              VALUES ('$name','$email','$message')";

    if(mysqli_query($conn,$query)){
        $success = "Thank you! Your message has been sent successfully.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us | GlowNest</title>
    <style>
        body{
            margin:0;
            font-family:Arial, sans-serif;
            background:#f9f9f9;
        }

        header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 60px;
            background:#fff;
            border-bottom:1px solid #eee;
        }

        .logo{
            font-size:28px;
            font-weight:bold;
        }

        nav a{
            margin:0 15px;
            text-decoration:none;
            color:#000;
            font-weight:500;
        }

        .hero{
            background:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),
            url("images/contact_bg.jpg") center/cover;
            color:#fff;
            text-align:center;
            padding:80px 20px;
        }

        .hero h1{
            font-size:42px;
            margin-bottom:10px;
        }

        .container{
            padding:60px 10%;
            display:flex;
            flex-wrap:wrap;
            gap:40px;
        }

        .contact-info{
            flex:1;
            min-width:280px;
        }

        .contact-info h3{
            margin-bottom:20px;
        }

        .contact-info p{
            margin-bottom:15px;
            color:#555;
        }

        .contact-form{
            flex:1;
            min-width:280px;
            background:#fff;
            padding:30px;
            border-radius:8px;
            box-shadow:0 0 10px #ddd;
        }

        .contact-form input,
        .contact-form textarea{
            width:100%;
            padding:10px;
            margin:10px 0;
            border:1px solid #ccc;
            border-radius:5px;
        }

        .contact-form textarea{
            height:120px;
            resize:none;
        }

        .contact-form button{
            width:100%;
            padding:12px;
            background:#000;
            color:#fff;
            border:none;
            cursor:pointer;
        }

        .contact-form button:hover{
            background:#333;
        }

        .success{
            color:green;
            text-align:center;
            margin-bottom:10px;
        }

        iframe{
            width:100%;
            height:300px;
            border:0;
            margin-top:40px;
        }

        footer{
            background:#000;
            color:#fff;
            text-align:center;
            padding:15px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">GlowNest</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="shoppage.php">Shop</a>
        <a href="aboutus.php">About</a>
        <a href="contactus.php">Contact</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="hero">
    <h1>Contact GlowNest</h1>
    <p>We’re here to help & answer any questions</p>
</div>

<div class="container">

    <div class="contact-info">
        <h3>Our Information</h3>
        <p><strong>Address:</strong> Ahmedabad, Gujarat, India</p>
        <p><strong>Email:</strong> support@glownest.com</p>
        <p><strong>Phone:</strong> +91 98765 43210</p>
        <p>Feel free to reach out to us anytime. Our team is always ready to assist you with product inquiries or support.</p>
    </div>

    <div class="contact-form">
        <?php if($success!=""){ ?>
            <p class="success"><?php echo $success; ?></p>
        <?php } ?>

        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Write your message..." required></textarea>
            <button type="submit" name="send">Send Message</button>
        </form>
    </div>

</div>

<!-- Google Map -->
<div style="padding:0 10%;">
<iframe src="https://maps.google.com/maps?q=Ahmedabad&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
</div>

<footer>
    <p>© 2026 GlowNest | Online Cosmetic Shop</p>
</footer>

</body>
</html>