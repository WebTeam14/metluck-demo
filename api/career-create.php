<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$full_name = trim($data["fullName"] ?? "");
$email     = trim($data["email"] ?? "");
$phone     = trim($data["phone"] ?? "");
$position  = trim($data["position"] ?? "");
$message   = trim($data["message"] ?? "");

// required fields
if ($full_name === "" || $email === "" || $phone === "" || $position === "") {
  echo json_encode(["success" => false, "error" => "Missing fields"]);
  exit;
}

$stmt = $conn->prepare("
  INSERT INTO career_applications (full_name,email,phone,position,message)
  VALUES (?,?,?,?,?)
");

$stmt->bind_param("sssss", $full_name, $email, $phone, $position, $message);
$stmt->execute();

echo json_encode([
  "success" => true,
  "id" => $stmt->insert_id
]);
