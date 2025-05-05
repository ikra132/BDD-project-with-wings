<?php
require_once 'db_connect.php';

try {
    // Create students table
    $conn->exec("CREATE TABLE IF NOT EXISTS students (
        student_id VARCHAR(10) PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Create room_assignments table
    $conn->exec("CREATE TABLE IF NOT EXISTS room_assignments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(10),
        room_id VARCHAR(10),
        assigned_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (student_id) REFERENCES students(student_id)
    )");

    echo "Database tables created successfully!";
} catch(PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}
?> 