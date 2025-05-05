<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Dahmani2005##');
define('DB_NAME', 'dorm_system');

try {
    // Connect to MySQL without selecting a database
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "Database created successfully or already exists!<br>";
    echo "Now you can run create_tables.php to create the necessary tables.";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "Please make sure:<br>";
    echo "1. MySQL server is running<br>";
    echo "2. The username and password are correct<br>";
    echo "3. The user has privileges to create databases";
}
?> 