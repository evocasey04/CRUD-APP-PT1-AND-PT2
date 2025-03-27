<?php
require "../common.php";

if (isset($_POST['submit'])) {
    try {
        require_once "../src/DBconnect.php";

        $user = [
            "id"        => escape($_POST['id']),
            "firstname" => escape($_POST['firstname']),
            "lastname"  => escape($_POST['lastname']),
            "email"     => escape($_POST['email']),
            "age"       => escape($_POST['age']),
            "location"  => escape($_POST['location']),
            
        ];

        $sql = "UPDATE users 
                SET firstname = :firstname, 
                    lastname = :lastname, 
                    email = :email, 
                    age = :age, 
                    location = :location 
                WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->execute($user);

        $success = true;
    } catch (PDOException $error) {
        echo "<p>Error: " . $error->getMessage() . "</p>";
    }
}

if (isset($_GET['id'])) {
    try {
        require_once "../src/DBconnect.php";

        $id = escape($_GET['id']);
        $sql = "SELECT * FROM users WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo "<p>Error: " . $error->getMessage() . "</p>";
    }
} else {
    echo "<p>No user ID found in URL.</p>";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($success)) : ?>
    <p><strong><?php echo escape($_POST['firstname']); ?> updated successfully!</strong></p>
<?php endif; ?>

<h2>Edit User</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
        <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
        <input 
            type="text" 
            name="<?php echo $key; ?>" 
            id="<?php echo $key; ?>" 
            value="<?php echo escape($value); ?>" 
            <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="update.php">Back to user list</a>

<?php require "templates/footer.php"; ?>
