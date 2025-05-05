<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

// Check if user already has a room assignment
$stmt = $conn->prepare("SELECT * FROM room_assignments WHERE student_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$assignment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($assignment) {
    header("Location: ../sorry.html");
    exit();
}

// Get available rooms
$stmt = $conn->prepare("
    SELECT r.room_id, r.room_number, p.name AS pavilion_name, f.number AS floor_number, 
           COUNT(ra.assignment_id) AS current_occupants, r.max_capacity
    FROM rooms r
    JOIN floors f ON r.floor_id = f.floor_id
    JOIN pavilions p ON f.pavilion_id = p.pavilion_id
    LEFT JOIN room_assignments ra ON r.room_id = ra.room_id
    GROUP BY r.room_id
    HAVING current_occupants < r.max_capacity
");
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle room selection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['room_id'])) {
    $room_id = $_POST['room_id'];
    
    // Check if room is still available
    $stmt = $conn->prepare("
        SELECT r.room_id, COUNT(ra.assignment_id) AS current_occupants, r.max_capacity
        FROM rooms r
        LEFT JOIN room_assignments ra ON r.room_id = ra.room_id
        WHERE r.room_id = ?
        GROUP BY r.room_id
        HAVING current_occupants < r.max_capacity
    ");
    $stmt->execute([$room_id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($room) {
        // Assign room to student
        $assignment_id = time(); // Simple way to generate unique ID
        $stmt = $conn->prepare("
            INSERT INTO room_assignments (assignment_id, student_id, room_id, date_assigned)
            VALUES (?, ?, ?, CURDATE())
        ");
        $stmt->execute([$assignment_id, $_SESSION['user_id'], $room_id]);
        
        header("Location: ../view/view1.html");
        exit();
    } else {
        header("Location: ../sorry.html");
        exit();
    }
}
?>