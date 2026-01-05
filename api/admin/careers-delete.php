<?php
include "auth.php";
include "../config.php";

$id = intval($_GET["id"]);

$stmt = $conn->prepare("DELETE FROM career_applications WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: careers.php");
exit;
