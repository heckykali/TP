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

// Get logged in user id
$username = $_SESSION['username'];
$user_query = mysqli_query($conn, "SELECT user_id FROM user WHERE email='$username'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['user_id'];

/* Update Quantity */
if (isset($_GET['action']) && isset($_GET['cart_id'])) {
    $cart_id = intval($_GET['cart_id']);
    $action = $_GET['action'];

    // Get current quantity
    $res = mysqli_query($conn, "SELECT quantity FROM cart WHERE cart_id=$cart_id AND user_id=$user_id");
    $data = mysqli_fetch_assoc($res);

    if ($data) {
        $qty = $data['quantity'];

        if ($action == "increase") {
            $qty++;
        } elseif ($action == "decrease" && $qty > 1) {
            $qty--;
        }

        mysqli_query($conn, "UPDATE cart SET quantity='$qty', total_amount=price * '$qty' WHERE cart_id=$cart_id AND user_id=$user_id");
    }

    header("Location: cart.php");
    exit();
}

// Remove Item
if (isset($_GET['remove'])) {
    $cart_id = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM cart WHERE cart_id=$cart_id AND user_id=$user_id");
    header("Location: cart.php");
}

// Fetch Cart Items
$query = "SELECT cart.*, products.product_name, products.image 
          FROM cart 
          JOIN products ON cart.product_id = products.product_id
          WHERE cart.user_id = $user_id";

$result = mysqli_query($conn, $query);

$grand_total = 0;
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Cart | GlowNest</title>

    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f4f4f4;
        }

        header {
            display: flex;
            justify-content: space-between;
            padding: 20px 60px;
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
        }

        .container {
            padding: 40px 10%;
            min-height: 70vh;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #000;
            color: #fff;
        }

        img {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }

        .remove {
            color: red;
            text-decoration: none;
        }

        .total-box {
            margin-top: 20px;
            text-align: right;
            font-size: 20px;
        }

        .btn {
            padding: 10px 20px;
            background: black;
            color: white;
            text-decoration: none;
        }

        #ff a {
            margin: 0 15px;
            text-decoration: none;
            color: #000;
            font-weight: 500;
        }

        footer {
            background: black;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }

        .qty-box {
            display: inline-flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
        }

        .qty-btn {
            padding: 6px 12px;
            background: #fff;
            color: #000;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        .qty-btn:hover {
            background: #9dedfc;
        }

        .qty {
            padding: 6px 12px;
            background: #f9f9f9;
            min-width: 30px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">GlowNest</div>
        <div id="ff">
            <a href="home.php">Home</a>
            <a href="shoppage.php">Shop</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="container">

        <h2>My Shopping Cart</h2>
        <br>

        <table>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $total = $row['price'] * $row['quantity'];
                    $grand_total += $total;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><img src="images/<?php echo $row['image']; ?>"></td>
                        <td>₹<?php echo $row['price']; ?></td>
                        <td>
                            <a href="cart.php?action=decrease&cart_id=<?php echo $row['cart_id']; ?>" class="qty-btn">−</a>
                            <?php echo $row['quantity']; ?>
                            <a href="cart.php?action=increase&cart_id=<?php echo $row['cart_id']; ?>" class="qty-btn">+</a>
                        </td>
                        <td>₹<?php echo $total; ?></td>
                        <td>
                            <a class="remove" href="cart.php?remove=<?php echo $row['cart_id']; ?>">Remove</a>
                        </td>
                    </tr>

                    <?php
                }
            } else {
                echo "<tr><td colspan='6'>Your cart is empty</td></tr>";
            }
            ?>
        </table>

        <div class="total-box">
            <strong>Grand Total: ₹<?php echo $grand_total; ?></strong>
            <br><br>
            <?php if ($grand_total > 0) { ?>
                <a href="checkout.php" class="btn">Proceed to Checkout</a>
            <?php } ?>
        </div>

    </div>

    <footer>
        <p>© 2026 GlowNest | Online Cosmetic Shop</p>
    </footer>

</body>

</html>