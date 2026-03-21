<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("Location: login.php");
        exit();
    }
    if(isset($_GET['category']))
    {
        $category = $_GET['category'];
        
    }
?>

<?php
// Database Connection
$conn = mysqli_connect("localhost", "root", "", "cosmatic_shop");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Category Filter (Optional)
$where = "";
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $where = "WHERE products.category_id = '$category'";
}

if (isset($_GET['Search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "WHERE products.product_name LIKE '%$search%'";
}

// Fetch Products with Category Name
$query = "SELECT products.*, category.category_name 
          FROM products 
          JOIN category ON products.category_id = category.category_id
          $where";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Shop | GlowNest</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
}

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
input[type="number"]{
    width:70px;
    padding:8px;
    text-align:center;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:14px;
    outline:none;
    transition:0.3s;
}

input[type="number"]:focus{
    border-color:#000;
    box-shadow:0 0 5px rgba(0,0,0,0.2);
}

/* Remove arrows in Chrome */
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.price{
    font-weight:bold;
    margin:10px 0;
}

input[type="submit"]{
    background:#000;
    color:#fff;
    border:none;
    padding:10px 20px;
    cursor:pointer;
}

input[type="submit"]:hover{
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
        <a href="cart.php">🛒</a>
        <a href="account.php">👤</a>
    </nav>
</header>

<h1 class="shop-title">Shop Products</h1>
<p class="shop-sub">Premium Cosmetic Collection</p>

<div class="products">

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>

    <div class="card">
        <form action="add_card.php" method="post">
            <div class="category"><?php echo htmlspecialchars($row['category_name']); ?></div>

            <?php if($row['image']) { ?>
                <img src="images/<?php echo $row['image']; ?>" width="150" height="150"><br><br>
            <?php } ?>

            <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>

            <div class="price">₹ <?php echo $row['price']; ?></div>

            <input type="number" value="1" name="quantity" min="1" max="<?php echo $row['stock']; ?>" style="width:60px;"><br><br>

            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="submit" value="Add to Cart" name="add_to_cart">
        </form>
    </div>

<?php
    }
} else {
    echo "<h3 style='text-align:center;'>No Products Found</h3>";
}
?>
</div>
</body>
</html>
