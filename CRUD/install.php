<?php
/**
 * install.php
 * Script to set up the database and users table
 */

require "config.php";

try {
    // Connect to MySQL without specifying a DB name (to create it)
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    
    // Read SQL schema from file
    $sql = file_get_contents("data/init.sql");
    
    // Execute SQL (create DB + table)
    $connection->exec($sql);

    echo "<p>✅ Database and 'users' table created successfully.</p>";
} catch (PDOException $error) {
    echo "<p>❌ Error setting up the database:</p>";
    echo "<pre>" . $sql . "<br>" . $error->getMessage() . "</pre>";
}
?>
