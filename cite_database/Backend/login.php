<?php
session_start();

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to handle errors
function handle_error($error_code) {
    if (!headers_sent()) {
        header("Location: ../login.html?error=" . $error_code);
        exit();
    } else {
        echo "<script>window.location.href='../login.html?error=" . $error_code . "';</script>";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $student_id = sanitize_input($_POST['student_id'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Input validation
    if (empty($student_id) || empty($password)) {
        handle_error(2);
    }
    
    if (!preg_match('/^\d{10}$/', $student_id)) {
        handle_error(5);
    }
    
    try {
        require_once 'db_connect.php';
        
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->execute([$student_id]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['student_id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['loggedIn'] = true;
            $_SESSION['last_activity'] = time();
            
            // Check if user has room assignment
            $stmt = $conn->prepare("SELECT * FROM room_assignments WHERE student_id = ?");
            $stmt->execute([$user['student_id']]);
            $assignment = $stmt->fetch();
            
            if ($assignment) {
                // User has room, redirect to view page
                if (!headers_sent()) {
                    header("Location: ../view/view1.html");
                } else {
                    echo "<script>window.location.href='../view/view1.html';</script>";
                }
            } else {
                // User needs to select room
                if (!headers_sent()) {
                    header("Location: ../room.html");
                } else {
                    echo "<script>window.location.href='../room.html';</script>";
                }
            }
            exit();
        } else {
            // Login failed
            handle_error(1);
        }
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        handle_error(4);
    }
} else {
    // If not POST request, redirect to login page
    if (!headers_sent()) {
        header("Location: ../login.html");
    } else {
        echo "<script>window.location.href='../login.html';</script>";
    }
    exit();
}
?>