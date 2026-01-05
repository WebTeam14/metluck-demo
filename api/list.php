<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "config.php";

$result = $conn->query("
    SELECT id, name, email, phone, subject, message, created_at
    FROM contact_submissions
    ORDER BY created_at DESC
");

$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
