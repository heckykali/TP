<h2>Categories</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['category_id']; ?></td>
            <td><?php echo $row['category_name']; ?></td>
            <td><?php echo $row['description']; ?></td>
        </tr>
        <?php
    }
    ?>
</table>