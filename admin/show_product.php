<?php
// ADD PRODUCT
if (isset($_POST['add_product'])) {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];
    $category = $_POST['category_id'];
    $brand = $_POST['brand_id'];

    // image upload
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "images/" . $image);

    mysqli_query($conn, "INSERT INTO products(product_name, price, stock, description, image, category_id, brand_id) 
        VALUES('$name','$price','$stock','$desc','$image','$category','$brand')");

    echo "<script>alert('Product Added'); window.location='admin_dashboard.php?page=products';</script>";
}

// UPDATE PRODUCT
if (isset($_POST['update_product'])) {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];
    $category = $_POST['category_id'];
    $brand = $_POST['brand_id'];

    $image = $_FILES['image']['name'];

    if ($image != "") {
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "images/" . $image);

        mysqli_query($conn, "UPDATE products SET 
            product_name='$name',
            price='$price',
            stock='$stock',
            description='$desc',
            image='$image',
            category_id='$category',
            brand_id='$brand'
            WHERE product_id='$id'");
    } else {
        mysqli_query($conn, "UPDATE products SET 
            product_name='$name',
            price='$price',
            stock='$stock',
            description='$desc',
            category_id='$category',
            brand_id='$brand'
            WHERE product_id='$id'");
    }

    echo "<script>alert('Product Updated'); window.location='admin_dashboard.php?page=products';</script>";
}

// DELETE PRODUCT
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM products WHERE product_id='$id'");
    echo "<script>alert('Product Deleted'); window.location='admin_dashboard.php?page=products';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Table</title>
    <link rel="stylesheet" href="css/prod.css">
</head>

<body>


    <h2>Products</h2>

    <!-- ADD BUTTON -->
    <button onclick="document.getElementById('addProductModal').style.display='block'">Add Product</button>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Description</th>
            <th>Image</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['stock']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <img src="../images/<?php echo $row['image']; ?>" width="50">
                </td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['brand_name']; ?></td>
                <td>
                    <button onclick="openEditModal(
                    <?php echo $row['product_id']; ?>,
                    '<?php echo $row['product_name']; ?>',
                    <?php echo $row['price']; ?>,
                    <?php echo $row['stock']; ?>
                    )">Update</button>
                    <button onclick="deleteProduct(<?php echo $row['product_id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- ADD MODAL -->
    <div id="addProductModal" class="modal">
        <div class="DAB">
            <span onclick="closeAdd()">&times;</span>
            <h3>Add Product</h3>

            <form method="post">
                <label>Name:</label>
                <input type="text" name="product_name" required>

                <label>Price:</label>
                <input type="number" name="price" required>

                <label>Stock:</label>
                <input type="number" name="stock" required>

                <input type="submit" name="add_product" value="Add Product">
            </form>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editProductModal" class="modal">
        <div class="DAB">
            <span onclick="closeEdit()">&times;</span>
            <h3>Update Product</h3>

            <form method="post">
                <input type="hidden" name="product_id" id="edit_id">

                <label>Name:</label>
                <input type="text" name="product_name" id="edit_name" required>

                <label>Price:</label>
                <input type="number" name="price" id="edit_price" required>

                <label>Stock:</label>
                <input type="number" name="stock" id="edit_stock" required>

                <input type="submit" name="update_product" value="Update Product">
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, price, stock) {
            document.getElementById('editProductModal').style.display = 'block';

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_stock').value = stock;
        }

        function closeEdit() {
            document.getElementById('editProductModal').style.display = 'none';
        }

        function closeAdd() {
            document.getElementById('addProductModal').style.display = 'none';
        }

        function deleteProduct(id) {
            if (confirm("Delete this product?")) {
                window.location = "admin_dashboard.php?page=products&delete_id=" + id;
            }
        }
    </script>
</body>

</html>