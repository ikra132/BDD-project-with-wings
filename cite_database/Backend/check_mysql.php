<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Dahmani2005##');

try {
    // Try to connect to MySQL
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "MySQL connection successful!<br>";
    
    // Check if MySQL service is running
    $result = $pdo->query("SELECT VERSION()")->fetch();
    echo "MySQL version: " . $result[0] . "<br>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "Please make sure MySQL is installed and running.<br>";
    echo "You can start MySQL by:<br>";
    echo "1. Opening Command Prompt as Administrator<br>";
    echo "2. Running: net start MySQL80 (or your MySQL service name)<br>";
}
?> 