<?php
if(isset($_POST['add_order'])){
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    // Get product price
    $product = mysqli_fetch_assoc(mysqli_query($conn,"SELECT price FROM products WHERE product_id='$product_id'"));
    $price = $product['price'];

    // Calculate total amount
    $total = $price * $quantity;

    // Insert into orders
    mysqli_query($conn,"INSERT INTO orders(user_id, product_id, quantity, price, total_amount, status) 
                        VALUES('$user_id','$product_id','$quantity','$price','$total','$status')");

    echo "<script>alert('Order Added Successfully'); window.location='admin_dashboard.php?page=orders';</script>";
}
?>

<h2>Orders</h2>
<!-- Add Order Button -->
<button onclick="document.getElementById('addOrderModal').style.display='block'">Add Order</button>
<table>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Status</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['order_id']; ?>
            </td>
            <td>
                <?php echo $row['user_name']; ?>
            </td>
            <td>
                <?php echo $row['product_name']; ?>
            </td>
            <td>
                <?php echo $row['quantity']; ?>
            </td>
            <td>
                <?php echo $row['total_amount']; ?>
            </td>
            <td>
                <?php echo $row['status']; ?>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<!-- Add Order Modal -->
<div id="addOrderModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
background: rgba(0,0,0,0.5); padding-top:100px;">
    <div style="background:white; margin:auto; padding:20px; width:400px; border-radius:5px; position:relative;">
        <span onclick="document.getElementById('addOrderModal').style.display='none'" 
              style="position:absolute; top:10px; right:20px; cursor:pointer;">&times;</span>
        <h3>Add New Order</h3>
        <form method="post">
            <label>User:</label><br>
            <select name="user_id" required>
                <option value="">Select User</option>
                <?php
                $users = mysqli_query($conn,"SELECT * FROM user");
                while($u = mysqli_fetch_assoc($users)){
                    echo "<option value='{$u['user_id']}'>{$u['name']}</option>";
                }
                ?>
            </select><br><br>

            <label>Product:</label><br>
            <select name="product_id" required>
                <option value="">Select Product</option>
                <?php
                $products = mysqli_query($conn,"SELECT * FROM products");
                while($p = mysqli_fetch_assoc($products)){
                    echo "<option value='{$p['product_id']}'>{$p['product_name']}</option>";
                }
                ?>
            </select><br><br>

            <label>Quantity:</label><br>
            <input type="number" name="quantity" min="1" value="1" required><br><br>

            <label>Status:</label><br>
            <select name="status" required>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select><br><br>

            <input type="submit" name="add_order" value="Add Order">
        </form>
    </div>
</div>