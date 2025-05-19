<?php
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/';

// Remove query string and trailing slash
$request_uri = strtok($request_uri, '?');
$request_uri = rtrim($request_uri, '/');

// If accessing root, redirect to login
if ($request_uri === $base_path) {
    header("Location: login.html");
    exit();
}

// Get the file path
$file_path = __DIR__ . $request_uri;

// If file exists, serve it
if (file_exists($file_path)) {
    $extension = pathinfo($file_path, PATHINFO_EXTENSION);
    
    // Set appropriate content type
    switch ($extension) {
        case 'css':
            header('Content-Type: text/css');
            break;
        case 'js':
            header('Content-Type: application/javascript');
            break;
        case 'html':
            header('Content-Type: text/html');
            break;
    }
    
    readfile($file_path);
    exit();
}

// If file doesn't exist, show 404
header("HTTP/1.0 404 Not Found");
echo "404 Not Found";
?> 