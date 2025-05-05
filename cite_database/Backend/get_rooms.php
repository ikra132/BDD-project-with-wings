<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

// Get pavilion and floor from request
$pavilion_id = $_GET['pavilion_id'] ?? null;
$floor_number = $_GET['floor_number'] ?? null;

// Build query based on filters
$query = "
    SELECT r.room_id, r.room_number, p.name AS pavilion_name, f.number AS floor_number,
           COUNT(ra.assignment_id) AS current_occupants, r.max_capacity,
           r.room_type, r.description
    FROM rooms r
    JOIN floors f ON r.floor_id = f.floor_id
    JOIN pavilions p ON f.pavilion_id = p.pavilion_id
    LEFT JOIN room_assignments ra ON r.room_id = ra.room_id
    WHERE 1=1
";

$params = [];

if ($pavilion_id) {
    $query .= " AND p.pavilion_id = ?";
    $params[] = $pavilion_id;
}

if ($floor_number) {
    $query .= " AND f.number = ?";
    $params[] = $floor_number;
}

$query .= " GROUP BY r.room_id HAVING current_occupants < r.max_capacity";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return rooms as JSON
header('Content-Type: application/json');
echo json_encode(['rooms' => $rooms]);
?>