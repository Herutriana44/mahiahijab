<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized"
    ]);
    exit;
}

// Kalau sudah login, kirim info user
echo json_encode([
    "status" => "success",
    "message" => "User is logged in",
    "user" => [
        "admin" => $_SESSION['admin'],
        "email" => $_SESSION['email']
    ]
]);
