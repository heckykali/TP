<?php
// ADD USER
if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    mysqli_query($conn, "INSERT INTO user(name,email,password,phone,address) 
        VALUES('$name','$email','$password','$phone','$address')");

    echo "<script>alert('User Added'); window.location='admin_dashboard.php?page=users';</script>";
}

// UPDATE USER
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    mysqli_query($conn, "UPDATE user SET 
        name='$name',
        email='$email',
        password='$password',
        phone='$phone',
        address='$address'
        WHERE user_id='$user_id'
    ");

    echo "<script>alert('User Updated'); window.location='admin_dashboard.php?page=users';</script>";
}

// DELETE USER
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM user WHERE user_id='$id'");
    echo "<script>alert('User Deleted'); window.location='admin_dashboard.php?page=users';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
    <link rel="stylesheet" href="css/usr.css">
</head>

<body>


    <h2>Users</h2>

    <!-- ADD BUTTON -->
    <button onclick="document.getElementById('addUserModal').style.display='block'">Add User</button>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td>
                    <button onclick="openEditModal(
                    <?php echo $row['user_id']; ?>,
                    '<?php echo $row['name']; ?>',
                    '<?php echo $row['email']; ?>',
                    '<?php echo $row['password']; ?>',
                    '<?php echo $row['phone']; ?>',
                    '<?php echo $row['address']; ?>'
                )">Update</button>

                    <button onclick="deleteUser(<?php echo $row['user_id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- ADD USER MODAL -->
    <div id="addUserModal" class="modal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); padding-top:100px;">

        <div class="DAB"
            style="background:white; margin:auto; padding:20px; width:400px; border-radius:5px; position:relative;">

            <span onclick="document.getElementById('addUserModal').style.display='none'"
                style="position:absolute; top:10px; right:20px; cursor:pointer;">&times;</span>

            <h3>Add New User</h3>

            <form method="post">

                <label>Name:</label><br>
                <input type="text" name="name" required><br><br>

                <label>Email:</label><br>
                <input type="email" name="email" required><br><br>

                <label>Password:</label><br>
                <input type="text" name="password" required><br><br>

                <label>Phone:</label><br>
                <input type="text" name="phone" required><br><br>

                <label>Address:</label><br>
                <input type="text" name="address" required><br><br>

                <input type="submit" name="add_user" value="Add User">

            </form>
        </div>
    </div>

    <!-- EDIT USER MODAL -->
    <div id="editUserModal" class="modal">
        <div class="DAB">
            <span onclick="closeEdit()">&times;</span>
            <h3>Update User</h3>

            <form method="post">
                <input type="hidden" name="user_id" id="edit_id">

                <input type="text" name="name" id="edit_name" required><br><br>
                <input type="email" name="email" id="edit_email" required><br><br>
                <input type="text" name="password" id="edit_password" required><br><br>
                <input type="text" name="phone" id="edit_phone" required><br><br>
                <input type="text" name="address" id="edit_address" required><br><br>

                <input type="submit" name="update_user" value="Update User">
            </form>
        </div>
    </div>
    <script>
        function openEditModal(id, name, email, password, phone, address) {
            document.getElementById('editUserModal').style.display = 'block';

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_password').value = password;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_address').value = address;
        }

        function closeEdit() {
            document.getElementById('editUserModal').style.display = 'none';
        }

        function closeAdd() {
            document.getElementById('addUserModal').style.display = 'none';
        }

        function deleteUser(id) {
            if (confirm("Delete this user?")) {
                window.location = "admin_dashboard.php?page=users&delete_id=" + id;
            }
        }
    </script>
</body>

</html>