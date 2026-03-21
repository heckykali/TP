<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit();
    }
?>



<?php
// Database Connection
$conn = mysqli_connect("localhost", "root", "", "cosmatic_shop");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Fetch Categories
$query = "SELECT * FROM category";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GlowNest | Online Cosmetic Shop</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            background: #ffffff;
            border-bottom: 1px solid #eee;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        nav a {
            text-decoration: none;
            color: #000;
            font-weight: 500;
        }

        .search-box input {
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
        }

        .icons a {
            margin-left: 15px;
            text-decoration: none;
            color: #000;
            font-weight: 500;
        }

        .hero {
            height: 80vh;
            background: url("images/hpage_bg.jpg") no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-content {
            background: rgba(255,255,255,0.85);
            padding: 40px;
            border-radius: 10px;
        }

        .hero-content h1 {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .btn {
            padding: 12px 25px;
            background: black;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .categories {
            padding: 50px;
            text-align: center;
        }

        .category-box {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .card {
            width: 200px;
            height: 120px;
            background: #f9e1da;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border-radius: 8px;
        }

        footer {
            background: black;
            color: white;
            text-align: center;
            padding: 15px;
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

        <form action="shoppage.php" method="GET">
            <div class="search-box">
                <input type="text" name="search" placeholder="Search products...">
                <input type="submit" name="Search" value="Search">
            </div>
        </form>
    </nav>

    <div class="icons">
        <?php
        if (isset($_SESSION['username'])) {
            echo '<a href="logout.php">Logout</a>';
        } else {
            echo '<a href="account.html">Login</a>';
        }
        ?>
        <a href="cart.php">🛒</a>
        <a href="account.php">👤</a>
    </div>
</header>

<section class="hero">
    <div class="hero-content">
        <h4>Discover Your New Addiction</h4><br>
        <h1>Premium Cosmetic & Beauty Products</h1><br>
        <p>Ayurvedic • Allopathic • Homeopathic</p><br><br>
        <a href="shoppage.php" class="btn">Shop Now</a>
    </div>
</section>

<section class="categories">
    <h2>Our Categories</h2>

    <div class="category-box" >

        <?php
        $Str = "";
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card" onclick="window.location.href=\'shoppage.php?category=' . urlencode($row['category_id']) . '\'">';
                $Str = htmlspecialchars($row['category_name']);
                echo $Str;
                echo '</div>';
            }
        } else {
            echo "<p>No Categories Found</p>";
        }
        ?>

    </div>
</section>

<footer>
    <p>© 2026 GlowNest | Online Cosmetic Shop</p>
</footer>

</body>
</html>
