<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

$pavilion_id = $_GET['pavilion_id'] ?? 1;

// Get available rooms for the selected pavilion
$stmt = $conn->prepare("
    SELECT r.room_id, r.room_number, f.number AS floor_number, 
           COUNT(ra.assignment_id) AS current_occupants, r.max_capacity
    FROM rooms r
    JOIN floors f ON r.floor_id = f.floor_id
    LEFT JOIN room_assignments ra ON r.room_id = ra.room_id
    WHERE f.pavilion_id = ?
    GROUP BY r.room_id
    HAVING current_occupants < r.max_capacity
    ORDER BY f.number, r.room_number
");
$stmt->execute([$pavilion_id]);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($rooms);
?>