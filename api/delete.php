<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include "config.php";

$id = intval($_POST["id"] ?? 0);

if ($id === 0) {
    echo json_encode(["success" => false, "error" => "Invalid ID"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM contact_submissions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(["success" => true]);
