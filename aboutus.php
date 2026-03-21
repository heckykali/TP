<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>About Us | Online Cosmetic Shop</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8f8f8;
        }

        /* Header */
        .header {
            background-color: #f3a683;
            padding: 15px;
            text-align: center;
            color: white;
        }

        /* About Section */
        .about-section {
            padding: 60px 10%;
            background-color: white;
        }

        .about-section h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .about-section p {
            color: #555;
            line-height: 1.8;
            font-size: 16px;
            text-align: justify;
        }

        /* Mission & Vision */
        .mv-section {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }

        .box {
            flex: 1;
            background-color: #fbe9e7;
            padding: 25px;
            border-radius: 8px;
        }

        .box h3 {
            color: #c0392b;
            margin-bottom: 10px;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 12px;
            margin-top: 40px;
        }

        body{
            margin:0;
            font-family:Arial, sans-serif;
        }

        /* HEADER */
        header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 60px;
            border-bottom:1px solid #ddd;
        }

        .logo{
            font-size:26px;
            font-weight:bold;
        }

        nav a{
            margin:0 15px;
            text-decoration:none;
            color:#000;
            font-weight:500;
        }

        /* SHOP TITLE */
        .shop-title{
            text-align:center;
            margin:40px 0 10px;
            font-size:36px;
        }

        .shop-sub{
            text-align:center;
            color:#555;
            margin-bottom:40px;
        }

        /* PRODUCTS */
        .products{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
            gap:25px;
            padding:0 60px 60px;
        }

        .card{
            border:1px solid #ddd;
            padding:20px;
            text-align:center;
        }

        .category{
            font-size:14px;
            color:#888;
            margin-bottom:8px;
        }

        .price{
            font-weight:bold;
            margin:10px 0;
        }

        button{
            background:#000;
            color:#fff;
            border:none;
            padding:10px 20px;
            cursor:pointer;
        }

        button:hover{
            background:#333;
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
    </nav>
</header>

<!-- Header -->
<div class="header">
    <h1>About Us</h1>
    <p>Online Cosmetic Shop</p>
</div>

<!-- About Content -->
<div class="about-section">
    <h2>Who We Are</h2>
    <p>
        Our Online Cosmetic Shop is a web-based e-commerce platform designed to provide
        a wide range of cosmetic products including skincare, haircare, and makeup.
        The platform offers products from Ayurvedic, Allopathic, and Homeopathic categories,
        allowing users to choose products based on their preferences and needs.
    </p>

    <!-- Mission & Vision -->
    <div class="mv-section">
        <div class="box">
            <h3>Our Mission</h3>
            <p>
                To provide quality cosmetic products through a reliable and easy-to-use
                online platform while ensuring customer satisfaction and accessibility.
            </p>
        </div>

        <div class="box">
            <h3>Our Vision</h3>
            <p>
                To become a trusted online destination for cosmetic shopping by offering
                diverse product categories and a smooth digital shopping experience.
            </p>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>&copy; 2026 Online Cosmetic Shop | All Rights Reserved</p>
</div>

</body>
</html>
