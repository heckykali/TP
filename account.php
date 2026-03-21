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

$username = $_SESSION['username'];

/* Get user details */
$user_query = mysqli_query($conn, "SELECT * FROM user WHERE email  = '$username'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['user_id'];

/* Get order history */
$order_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY order_date DESC");

/* Get cart items */
$cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
$prod = mysqli_query($conn, "SELECT * FROM products WHERE product_id IN (SELECT product_id FROM cart WHERE user_id='$user_id')");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>My Profile | GlowNest</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f8f8f8;
}

header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 60px;
    border-bottom:1px solid #ddd;
    background:#fff;
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

.container{
    width:90%;
    max-width:1100px;
    margin:40px auto;
}

.section{
    background:#fff;
    padding:25px;
    margin-bottom:30px;
    border-radius:8px;
    box-shadow:0 0 10px rgba(0,0,0,0.05);
}

.section h2{
    margin-bottom:20px;
    border-bottom:1px solid #ddd;
    padding-bottom:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th, table td{
    padding:12px;
    border-bottom:1px solid #eee;
    text-align:left;
}

table th{
    background:#f3a683;
    color:#fff;
}

.logout-btn{
    padding:10px 20px;
    background:#000;
    color:#fff;
    border:none;
    cursor:pointer;
}

.logout-btn:hover{
    background:#333;
}

.footer{
    background:#333;
    color:white;
    text-align:center;
    padding:12px;
}
</style>
</head>

<body>

<header>
    <div class="logo">GlowNest</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="shoppage.php">Shop</a>
        <a href="profile.php">👤 Profile</a>
    </nav>
</header>

<div class="container">

    <!-- User Details -->
    <div class="section">
        <h2>User Information</h2>
        <p><strong>Username:</strong> <?php echo $user_data['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $user_data['email']; ?></p>

        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Order History -->
    <div class="section">
        <h2>Order History</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Date</th>
            </tr>

            <?php
            if(mysqli_num_rows($order_query) > 0)
            {
                while($order = mysqli_fetch_assoc($order_query))
                {
                    echo "<tr>
                            <td>".$order['order_id']."</td>
                            <td>₹".$order['total_amount']."</td>
                            <td>".$order['order_date']."</td>
                          </tr>";
                }
            }
            else
            {
                echo "<tr><td colspan='4'>No Orders Found</td></tr>";
            }
            ?>
        </table>
    </div>

    <!-- Cart Items -->
    <div class="section">
        <h2>Cart Items</h2>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>

            <?php
            if(mysqli_num_rows($cart_query) > 0)
            {
                while($cart = mysqli_fetch_assoc($cart_query))
                {
                    $pr = mysqli_fetch_assoc($prod);
                    echo "<tr>
                            <td>".$cart['product_id']."</td>
                            <td>".$pr['product_name']."</td>
                            <td>₹".$cart['price']."</td>
                            <td>".$cart['quantity']."</td>
                          </tr>";
                }
            }
            else
            {
                echo "<tr><td colspan='3'>Cart is Empty</td></tr>";
            }
            ?>
        </table>
    </div>

</div>

<div class="footer">
    &copy; 2026 GlowNest | All Rights Reserved
</div>

</body>
</html>