<?php
require "../common.php";

if (isset($_GET['id'])) {
    try {
        require_once "../src/DBconnect.php";

        $id = escape($_GET['id']);

        $sql = "DELETE FROM users WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $success = "User ID $id deleted successfully.";
    } catch (PDOException $error) {
        echo "<p>Error: " . $error->getMessage() . "</p>";
    }
}

try {
    require_once "../src/DBconnect.php";

    $sql = "SELECT * FROM users";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch (PDOException $error) {
    echo "<p>Error: " . $error->getMessage() . "</p>";
}
?>

<?php require "templates/header.php"; ?>

<h2>Delete Users</h2>

<?php if (isset($success)) : ?>
    <p><strong><?php echo $success; ?></strong></p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Location</th>
            <th>Date</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["firstname"]); ?></td>
            <td><?php echo escape($row["lastname"]); ?></td>
            <td><?php echo escape($row["email"]); ?></td>
            <td><?php echo escape($row["age"]); ?></td>
            <td><?php echo escape($row["location"]); ?></td>
            <td><?php echo escape($row["date"]); ?></td>
            <td><a href="delete.php?id=<?php echo escape($row["id"]); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
