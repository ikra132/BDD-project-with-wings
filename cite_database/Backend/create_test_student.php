<?php
require_once 'db_connect.php';

try {
    // Test student data
    $student_id = '1234567890';
    $full_name = 'Test Student';
    $password = password_hash('test123', PASSWORD_DEFAULT);

    // Check if student already exists
    $stmt = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    
    if ($stmt->fetch()) {
        echo "Test student already exists!<br>";
        echo "Student ID: " . $student_id . "<br>";
        echo "Password: test123<br>";
    } else {
        // Insert new test student
        $stmt = $conn->prepare("INSERT INTO students (student_id, full_name, password) VALUES (?, ?, ?)");
        $stmt->execute([$student_id, $full_name, $password]);
        
        echo "Test student created successfully!<br>";
        echo "Student ID: " . $student_id . "<br>";
        echo "Password: test123<br>";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 