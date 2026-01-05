<?php
include "config.php";

$name = "Test User";
$email = "test@mail.com";
$phone = "123456";
$subject = "Test Submit";
$message = "This is a test";

$stmt = $conn->prepare("
  INSERT INTO contact_submissions (name,email,phone,subject,message)
  VALUES (?,?,?,?,?)
");

$stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
$stmt->execute();

echo "Inserted test row";
?>
