<?php
// ADD BRAND
if (isset($_POST['add_brand'])) {
    $name = $_POST['brand_name'];
    $desc = $_POST['description'];

    mysqli_query($conn, "INSERT INTO brand(brand_name, description) 
        VALUES('$name','$desc')");

    echo "<script>alert('Brand Added'); window.location='admin_dashboard.php?page=brands';</script>";
}

// UPDATE BRAND
if (isset($_POST['update_brand'])) {
    $id = $_POST['brand_id'];
    $name = $_POST['brand_name'];
    $desc = $_POST['description'];

    mysqli_query($conn, "UPDATE brand SET 
        brand_name='$name',
        description='$desc'
        WHERE brand_id='$id'
    ");

    echo "<script>alert('Brand Updated'); window.location='admin_dashboard.php?page=brands';</script>";
}

// DELETE BRAND
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM brand WHERE brand_id='$id'");
    echo "<script>alert('Brand Deleted'); window.location='admin_dashboard.php?page=brands';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands Table</title>
    <link rel="stylesheet" href="css/bra.css">
</head>

<body>

    <h2>Brands</h2>

    <!-- ADD BUTTON -->
    <button onclick="document.getElementById('addBrandModal').style.display='block'">Add Brand</button>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['brand_id']; ?></td>
                <td><?php echo $row['brand_name']; ?></td>
                <td><?php echo $row['description']; ?></td>

                <td>
                    <button onclick="openEditModal(
                    <?php echo $row['brand_id']; ?>,
                    '<?php echo $row['brand_name']; ?>',
                    '<?php echo $row['description']; ?>'
                )">Update</button>

                    <button onclick="deleteBrand(<?php echo $row['brand_id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- ADD MODAL -->
    <div id="addBrandModal" class="modal">
        <div class="DAB">
            <span onclick="closeAdd()">&times;</span>
            <h3>Add Brand</h3>

            <form method="post">
                <label>Name:</label>
                <input type="text" name="brand_name" required>

                <label>Description:</label>
                <input type="text" name="description">

                <input type="submit" name="add_brand" value="Add Brand">
            </form>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editBrandModal" class="modal">
        <div class="DAB">
            <span onclick="closeEdit()">&times;</span>
            <h3>Update Brand</h3>

            <form method="post">
                <input type="hidden" name="brand_id" id="edit_id">

                <label>Name:</label>
                <input type="text" name="brand_name" id="edit_name" required>

                <label>Description:</label>
                <input type="text" name="description" id="edit_desc">

                <input type="submit" name="update_brand" value="Update Brand">
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, desc) {
            document.getElementById('editBrandModal').style.display = 'block';

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_desc').value = desc;
        }

        function closeEdit() {
            document.getElementById('editBrandModal').style.display = 'none';
        }

        function closeAdd() {
            document.getElementById('addBrandModal').style.display = 'none';
        }

        function deleteBrand(id) {
            if (confirm("Delete this brand?")) {
                window.location = "admin_dashboard.php?page=brands&delete_id=" + id;
            }
        }
    </script>
</body>

</html>