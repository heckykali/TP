<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "cosmatic_shop");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['add_to_cart'])) {

    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity <= 0) {
        $quantity = 1;
    }

    // Get user id
    $username = $_SESSION['username'];
    $user_query = mysqli_query($conn, "SELECT user_id FROM user WHERE email='$username'");
    $user_data = mysqli_fetch_assoc($user_query);
    $user_id = $user_data['user_id'];

    // Get product price
    $product_query = mysqli_query($conn, "SELECT price FROM products WHERE product_id=$product_id");
    $product_data = mysqli_fetch_assoc($product_query);
    $price = $product_data['price'];

    $total_amount = $price * $quantity;

    // Check if product already in cart
    $check_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id");

    if (mysqli_num_rows($check_query) > 0) {

        // Update quantity
        $row = mysqli_fetch_assoc($check_query);
        $new_quantity = $row['quantity'] + $quantity;
        $new_total = $new_quantity * $price;

        mysqli_query(
            $conn,
            "UPDATE cart 
            SET quantity=$new_quantity, total_amount=$new_total 
            WHERE cart_id=" . $row['cart_id']
        );
        ?>
        <script>alert('Item added to cart successfully!');</script>";
        <?php
    } else {

        // Insert new item
        mysqli_query(
            $conn,
            "INSERT INTO cart (user_id, product_id, quantity, price, total_amount)
            VALUES ($user_id, $product_id, $quantity, $price, $total_amount)"
        );
        ?>
        <script>alert('Item added to cart successfully!');</script>";
        <?php
    }



    header("Location: shoppage.php");
    exit();
}
?>