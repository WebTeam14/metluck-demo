<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Accept");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$company_name     = trim($data["companyName"] ?? "");
$contact_person   = trim($data["contactPerson"] ?? "");
$email            = trim($data["email"] ?? "");
$phone            = trim($data["phone"] ?? "");
$company_type     = trim($data["companyType"] ?? "");
$services_offered = trim($data["servicesOffered"] ?? "");
$message          = trim($data["message"] ?? "");

// Required fields
if ($company_name === "" || $contact_person === "" || $email === "" || $phone === "") {
    echo json_encode([
        "success" => false,
        "error" => "Missing required fields"
    ]);
    exit;
}

$stmt = $conn->prepare("
  INSERT INTO partner_registrations
  (company_name, contact_person, email, phone, company_type, services_offered, message)
  VALUES (?,?,?,?,?,?,?)
");

$stmt->bind_param(
  "sssssss",
  $company_name,
  $contact_person,
  $email,
  $phone,
  $company_type,
  $services_offered,
  $message
);

$stmt->execute();

echo json_encode([
    "success" => true,
    "id" => $stmt->insert_id
]);
