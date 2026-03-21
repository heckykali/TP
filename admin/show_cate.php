<?php
// ADD CATEGORY
if (isset($_POST['add_category'])) {
    $name = $_POST['category_name'];
    $desc = $_POST['description'];

    mysqli_query($conn, "INSERT INTO category(category_name, description) 
        VALUES('$name','$desc')");

    echo "<script>alert('Category Added'); window.location='admin_dashboard.php?page=categories';</script>";
}

// UPDATE CATEGORY
if (isset($_POST['update_category'])) {
    $id = $_POST['category_id'];
    $name = $_POST['category_name'];
    $desc = $_POST['description'];

    mysqli_query($conn, "UPDATE category SET 
        category_name='$name',
        description='$desc'
        WHERE category_id='$id'
    ");

    echo "<script>alert('Category Updated'); window.location='admin_dashboard.php?page=categories';</script>";
}

// DELETE CATEGORY
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM category WHERE category_id='$id'");
    echo "<script>alert('Category Deleted'); window.location='admin_dashboard.php?page=categories';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categary Table</title>
    <link rel="stylesheet" href="css/cat.css">
</head>

<body>

    <h2>Categories</h2>

    <!-- ADD BUTTON -->
    <button onclick="document.getElementById('addCategoryModal').style.display='block'">Add Category</button>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['category_id']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['description']; ?></td>

                <td>
                    <button onclick="openEditModal(
                    <?php echo $row['category_id']; ?>,
                    '<?php echo $row['category_name']; ?>',
                    '<?php echo $row['description']; ?>'
                )">Update</button>

                    <button onclick="deleteCategory(<?php echo $row['category_id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- ADD MODAL -->
    <div id="addCategoryModal" class="modal">
        <div class="DAB">
            <span onclick="closeAdd()">&times;</span>
            <h3>Add Category</h3>

            <form method="post">
                <label>Name:</label>
                <input type="text" name="category_name" required>

                <label>Description:</label>
                <input type="text" name="description">

                <input type="submit" name="add_category" value="Add Category">
            </form>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editCategoryModal" class="modal">
        <div class="DAB">
            <span onclick="closeEdit()">&times;</span>
            <h3>Update Category</h3>

            <form method="post">
                <input type="hidden" name="category_id" id="edit_id">

                <label>Name:</label>
                <input type="text" name="category_name" id="edit_name" required>

                <label>Description:</label>
                <input type="text" name="description" id="edit_desc">

                <input type="submit" name="update_category" value="Update Category">
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, desc) {
            document.getElementById('editCategoryModal').style.display = 'block';

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_desc').value = desc;
        }

        function closeEdit() {
            document.getElementById('editCategoryModal').style.display = 'none';
        }

        function closeAdd() {
            document.getElementById('addCategoryModal').style.display = 'none';
        }

        function deleteCategory(id) {
            if (confirm("Delete this category?")) {
                window.location = "admin_dashboard.php?page=categories&delete_id=" + id;
            }
        }
    </script>
</body>

</html>