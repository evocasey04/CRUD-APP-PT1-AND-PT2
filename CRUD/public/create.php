<?php
require "../common.php";
require_once "../src/DBconnect.php";

if (isset($_POST['submit'])) {
    try {
        // Sanitize and prepare user data
        $new_user = [
            "firstname" => escape($_POST['firstname']),
            "lastname" => escape($_POST['lastname']),
            "email" => escape($_POST['email']),
            "age" => escape($_POST['age']),
            "location" => escape($_POST['location'])
        ];

        // SQL query string
        $sql = sprintf(
            "INSERT INTO users (%s) VALUES (%s)",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        // Prepare and execute
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

        $success = true;
    } catch (PDOException $error) {
        echo "<p>Error: " . $error->getMessage() . "</p>";
    }
}
?>

<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && isset($success)) : ?>
    <p><?php echo escape($_POST['firstname']); ?> successfully added.</p>
<?php endif; ?>

<h2>Add a user</h2>

<form method="post">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname" required>

    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname" required>

    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" required>

    <label for="age">Age</label>
    <input type="text" name="age" id="age">

    <label for="location">Location</label>
    <input type="text" name="location" id="location">

    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>
