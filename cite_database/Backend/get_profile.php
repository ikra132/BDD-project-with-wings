<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

// Get user profile data
$stmt = $conn->prepare("
    SELECT student_id, full_name, email, field_of_study
    FROM students
    WHERE student_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($profile);
?>