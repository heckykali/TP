<h2>Contact Messages</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['contact_id']; ?>
            </td>
            <td>
                <?php echo $row['name']; ?>
            </td>
            <td>
                <?php echo $row['email']; ?>
            </td>
            <td>
                <?php echo $row['message']; ?>
            </td>
        </tr>
        <?php
    }
    ?>
</table>