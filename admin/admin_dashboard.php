<?php
include("db.php");

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// summary counts
$admin_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM admin"))['total'];
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM user"))['total'];
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/desh.css">
</head>

<body>
    <div class="sidebar">
        <h2 style="color:white;text-align:center;">Admin</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <!-- <a href="admin_dashboard.php?page=admins">Admins</a> -->
        <a href="admin_dashboard.php?page=users">Users</a>
        <a href="admin_dashboard.php?page=products">Products</a>
        <a href="admin_dashboard.php?page=categories">Categories</a>
        <a href="admin_dashboard.php?page=brands">Brands</a>
        <a href="admin_dashboard.php?page=orders">Orders</a>
        <a href="admin_dashboard.php?page=contact">Contact</a>
    </div>
    <div class="main">
        <?php
        if ($page == "dashboard") {
            ?>
            <h2>Dashboard Summary</h2>
            <div class="card">
                <h3><?php echo $admin_count; ?></h3>
                <p>Admins</p>
            </div>
            <div class="card">
                <h3><?php echo $user_count; ?></h3>
                <p>Users</p>
            </div>
            <div class="card">
                <h3><?php echo $product_count; ?></h3>
                <p>Products</p>
            </div>
            <div class="card">
                <h3><?php echo $order_count; ?></h3>
                <p>Orders</p>
            </div>
            <?php
        } elseif ($page == "admins") {
            $result = mysqli_query($conn, "SELECT * FROM admin");
            include("show_admin.php");
        } elseif ($page == "users") {
            $result = mysqli_query($conn, "SELECT * FROM user");
            include("show_user.php");
        } elseif ($page == "products") {
            $result = mysqli_query($conn, "SELECT * FROM products");
            include("show_product.php");
        } elseif ($page == "categories") {
            $result = mysqli_query($conn, "SELECT * FROM category");
            include("show_cate.php");
        } elseif ($page == "brands") {
            $result = mysqli_query($conn, "SELECT * FROM brand");
            include("show_brands.php");
        } elseif ($page == "orders") {
            // Join orders with user and products to get names
            $result = mysqli_query($conn, "
                SELECT o.order_id, u.name as user_name, p.product_name, o.quantity, o.total_amount, o.status
                FROM orders o
                JOIN user u ON o.user_id = u.user_id
                JOIN products p ON o.product_id = p.product_id
                ORDER BY o.order_id 
            ");
            include("show_orders.php");
        } elseif ($page == "contact") {
            $result = mysqli_query($conn, "SELECT * FROM contact");
            include("./show_contact.php");
        }
        ?>
    </div>
</body>

</html>