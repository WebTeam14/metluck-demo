<?php
// CORS + JSON response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include "config.php";

// Read raw JSON body
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// Fallback to POST form data (optional)
if (!$data || !is_array($data)) {
    $data = $_POST;
}

// Extract fields
$name    = trim($data["name"] ?? "");
$email   = trim($data["email"] ?? "");
$phone   = trim($data["phone"] ?? "");
$subject = trim($data["subject"] ?? "");
$message = trim($data["message"] ?? "");

// Validate required fields
if ($name === "" || $email === "" || $subject === "" || $message === "") {
    echo json_encode([
        "success" => false,
        "error" => "Missing required fields",
        "received" => $data
    ]);
    exit;
}

// Insert into DB
$stmt = $conn->prepare("
    INSERT INTO contact_submissions (name,email,phone,subject,message)
    VALUES (?,?,?,?,?)
");
$stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
$stmt->execute();

echo json_encode([
    "success" => true,
    "message" => "Form submitted successfully",
    "id" => $stmt->insert_id
]);
