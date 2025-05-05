<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['student_id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['loggedIn'] = true;
        
        // Check if user has room assignment
        $stmt = $conn->prepare("SELECT * FROM room_assignments WHERE student_id = ?");
        $stmt->execute([$user['student_id']]);
        $assignment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($assignment) {
            // User has room, redirect to view page
            header("Location: ../view/view1.html");
        } else {
            // User needs to select room
            header("Location: ../room.html");
        }
        exit();
    } else {
        // Login failed
        header("Location: ../login.html?error=1");
        exit();
    }
}
?>