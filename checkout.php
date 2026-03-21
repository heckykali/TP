<?php
session_start();

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

/* Database Connection */
$conn = mysqli_connect("localhost", "root", "", "cosmatic_shop");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$username = $_SESSION['username'];

/* Get User */
$user_query = mysqli_query($conn, "SELECT * FROM user WHERE email='$username'");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['user_id'];

/* Fetch Cart Items with Product Name */
$cart_query = mysqli_query($conn, "
    SELECT cart.*, products.product_name 
    FROM cart 
    JOIN products ON cart.product_id = products.product_id
    WHERE cart.user_id='$user_id'
");

$grand_total = 0;

/* Place Order */
if(isset($_POST['place_order']))
{
    $status = "Pending";
    $date = date("Y-m-d H:i:s");

    $cart_items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");

    while($item = mysqli_fetch_assoc($cart_items))
    {
        $product_id = $item['product_id'];
        $price = $item['price'];
        $quantity = $item['quantity'];
        $total_amount = $price * $quantity;

        mysqli_query($conn, "INSERT INTO orders 
            (user_id, product_id, price, quantity, total_amount, status, order_date)
            VALUES
            ('$user_id', '$product_id', '$price', '$quantity', '$total_amount', '$status', '$date')");
    }

    /* Clear Cart */
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

    echo "<script>alert('Order Placed Successfully!'); window.location='account.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Checkout | GlowNest</title>
<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    background:#f7f7f7;
    margin:0;
    padding:0;
}

.ffty{
    width:40%;
    margin:auto;
    background:white;
    padding:30px;
    margin-top:40px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

/* Container */
.container{
    width:70%;
    margin:auto;
    background:white;
    padding:30px;
    margin-top:40px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

/* Heading */
h2{
    color:#333;
    margin-bottom:15px;
}

/* Table */
table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

table th{
    background:#ff4d6d;
    color:white;
}

table th, table td{
    padding:12px;
    border:1px solid #ddd;
    text-align:center;
}

/* Total */
.total{
    text-align:right;
    font-size:20px;
    font-weight:bold;
    color:#333;
}

/* Form */
form input, form select{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

/* Button */
button{
    background:#ff4d6d;
    color:white;
    border:none;
    padding:12px 25px;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#e63c5a;
}

</style>

</head>

<body>

<h2>Order Summary</h2>

<table border="1" width="100%" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Subtotal</th>
</tr>

<?php
while($item = mysqli_fetch_assoc($cart_query))
{
    $subtotal = $item['price'] * $item['quantity'];
    $grand_total += $subtotal;

    echo "<tr align='center'>
            <td>".$item['product_name']."</td>
            <td>₹".$item['price']."</td>
            <td>".$item['quantity']."</td>
            <td>₹".$subtotal."</td>
          </tr>";
}
?>

</table>

<h3>Total: ₹<?php echo $grand_total; ?></h3>

<hr>
<div class="ffty">
    <h2 ">Shipping Details</h2>

    <form method="POST" >
        <input type="text" name="fullname" placeholder="Full Name" required><br><br>
        <input type="text" name="address" placeholder="Address" required><br><br>
        <input type="text" name="city" placeholder="City" required><br><br>
        <input type="text" name="phone" placeholder="Phone Number" required><br><br>

        <select name="payment_method" required>
            <option value="Online">Online Payment</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
        </select><br><br>
        
        <button type="submit" name="place_order">Place Order</button>
    </form>
</div>

</body>
</html>