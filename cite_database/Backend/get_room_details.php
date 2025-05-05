<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Check if room_id is provided
if (!isset($_GET['room_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Room ID is required']);
    exit();
}

$room_id = $_GET['room_id'];

try {
    // Get room details
    $stmt = $pdo->prepare("
        SELECT r.*, p.name as pavilion_name
        FROM rooms r
        JOIN pavilions p ON r.pavilion_id = p.id
        WHERE r.id = ?
    ");
    $stmt->execute([$room_id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        http_response_code(404);
        echo json_encode(['error' => 'Room not found']);
        exit();
    }

    // Get current roommates
    $stmt = $pdo->prepare("
        SELECT u.name, u.major
        FROM users u
        JOIN room_assignments ra ON u.id = ra.user_id
        WHERE ra.room_id = ?
    ");
    $stmt->execute([$room_id]);
    $roommates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Add roommates to room data
    $room['roommates'] = $roommates;

    // Return room data
    echo json_encode($room);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
    exit();
}
?>