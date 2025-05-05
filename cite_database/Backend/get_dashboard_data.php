<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

// Get user's room assignment details
$stmt = $conn->prepare("
    SELECT r.room_number, p.name AS pavilion_name, f.number AS floor_number, 
           r.max_capacity, ra.date_assigned
    FROM room_assignments ra
    JOIN rooms r ON ra.room_id = r.room_id
    JOIN floors f ON r.floor_id = f.floor_id
    JOIN pavilions p ON f.pavilion_id = p.pavilion_id
    WHERE ra.student_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);

// Get roommates if any
$roommates = [];
if ($assignment) {
    $stmt = $conn->prepare("
        SELECT s.full_name, s.field_of_study
        FROM room_assignments ra
        JOIN students s ON ra.student_id = s.student_id
        WHERE ra.room_id = (SELECT room_id FROM room_assignments WHERE student_id = ?)
        AND ra.student_id != ?
    ");
    $stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
    $roommates = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode([
    'assignment' => $assignment,
    'roommates' => $roommates,
    'user_name' => $_SESSION['user_name'] ?? 'Guest'
]);
?>