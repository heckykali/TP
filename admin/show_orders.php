<?php
if (isset($_POST['add_order'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    // Get product price
    $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM products WHERE product_id='$product_id'"));
    $price = $product['price'];

    // Calculate total amount
    $total = $price * $quantity;

    // Insert into orders
    mysqli_query($conn, "INSERT INTO orders(user_id, product_id, quantity, price, total_amount, status) 
                        VALUES('$user_id','$product_id','$quantity','$price','$total','$status')");

    echo "<script>alert('Order Added Successfully'); window.location='admin_dashboard.php?page=orders';</script>";
}

if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    // Get price
    $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM products WHERE product_id='$product_id'"));
    $price = $product['price'];

    $total = $price * $quantity;

    mysqli_query($conn, "UPDATE orders SET 
        user_id='$user_id',
        product_id='$product_id',
        quantity='$quantity',
        price='$price',
        total_amount='$total',
        status='$status'
        WHERE order_id='$order_id'
    ");

    echo "<script>alert('Order Updated Successfully'); window.location='admin_dashboard.php?page=orders';</script>";
}
if (isset($_GET["order_id"])) {
    $order_id = $_GET["order_id"];
    mysqli_query($conn, "DELETE FROM orders WHERE order_id='$order_id'");
    echo "<script>alert('Order Deleted Successfully'); window.location='admin_dashboard.php?page=orders';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Table</title>
    <link rel="stylesheet" href="css/ord.css">
</head>

<body>

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
            <th>Update</th>
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
                <td>
                    <button onclick="openEditModal(
                        <?php echo $row['order_id']; ?>,
                        <?php echo $row['user_id']; ?>,
                        <?php echo $row['product_id']; ?>,
                        <?php echo $row['quantity']; ?>,
                        '<?php echo $row['status']; ?>'
                    )">Update</button>
                    <button onclick="deleteOrder(<?php echo $row['order_id']; ?>)">Delete</button>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <!-- Add Order Modal -->
    <div id="addOrderModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); padding-top:100px;">
        <div class="DAB"
            style="background:white; margin:auto; padding:20px; width:400px; border-radius:5px; position:relative;">
            <span onclick="document.getElementById('addOrderModal').style.display='none'"
                style="position:absolute; top:10px; right:20px; cursor:pointer;">&times;</span>
            <h3>Add New Order</h3>
            <form method="post">
                <label>User:</label><br>
                <select name="user_id" required>
                    <option value="">Select User</option>
                    <?php
                    $users = mysqli_query($conn, "SELECT * FROM user");
                    while ($u = mysqli_fetch_assoc($users)) {
                        echo "<option value='{$u['user_id']}'>{$u['name']}</option>";
                    }
                    ?>
                </select><br><br>

                <label>Product:</label><br>
                <select name="product_id" required>
                    <option value="">Select Product</option>
                    <?php
                    $products = mysqli_query($conn, "SELECT * FROM products");
                    while ($p = mysqli_fetch_assoc($products)) {
                        echo "<option value='{$p['product_id']}'>{$p['product_name']}</option>";
                    }
                    ?>
                </select><br><br>

                <label>Quantity:</label><br>
                <input style="" type="number" name="quantity" min="1" value="1" required><br><br>

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
    <div id="editOrderModal" class="modal">
        <div class="DAB">
            <span onclick="closeEditModal()">&times;</span>
            <h3>Update Order</h3>

            <form method="post">
                <input type="hidden" name="order_id" id="edit_order_id">

                <label>User:</label><br>
                <select name="user_id" id="edit_user_id" required>
                    <?php
                    $users = mysqli_query($conn, "SELECT * FROM user");
                    while ($u = mysqli_fetch_assoc($users)) {
                        echo "<option value='{$u['user_id']}'>{$u['name']}</option>";
                    }
                    ?>
                </select><br><br>

                <label>Product:</label><br>
                <select name="product_id" id="edit_product_id" required>
                    <?php
                    $products = mysqli_query($conn, "SELECT * FROM products");
                    while ($p = mysqli_fetch_assoc($products)) {
                        echo "<option value='{$p['product_id']}'>{$p['product_name']}</option>";
                    }
                    ?>
                </select><br><br>

                <label>Quantity:</label><br>
                <input type="number" name="quantity" id="edit_quantity" min="1" required><br><br>

                <label>Status:</label><br>
                <select name="status" id="edit_status" required>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select><br><br>

                <input type="submit" name="update_order" value="Update Order">
            </form>
        </div>
    </div>
    <script>
        function openEditModal(order_id, user_id, product_id, quantity, status) {
            document.getElementById('editOrderModal').style.display = 'block';

            document.getElementById('edit_order_id').value = order_id;
            document.getElementById('edit_user_id').value = user_id;
            document.getElementById('edit_product_id').value = product_id;
            document.getElementById('edit_quantity').value = quantity;
            document.getElementById('edit_status').value = status;
        }

        function closeEditModal() {
            document.getElementById('editOrderModal').style.display = 'none';
        }
        function deleteOrder(order_id) {
            if (confirm("Are you sure you want to delete this order?")) {
                window.location = "admin_dashboard.php?page=orders&order_id=" + order_id;
            }
        }

    </script>
</body>

</html>