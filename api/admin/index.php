<?php
include "auth.php";
include "../config.php";

/* Get module counts */

$contacts = $conn->query("SELECT COUNT(*) t FROM contact_submissions")
  ->fetch_assoc()["t"];

$partners = $conn->query("SELECT COUNT(*) t FROM partner_registrations")
  ->fetch_assoc()["t"];

$careers = $conn->query("SELECT COUNT(*) t FROM career_applications")
  ->fetch_assoc()["t"];
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-container">

<div class="topbar">
  <h2>Admin Dashboard</h2>

  <div class="user-info">
    Logged in as <b><?=$_SESSION["admin"]?></b>
    <a class="btn-logout" href="logout.php">Logout</a>
  </div>
</div>

<div class="stats-grid">

  <a href="contacts.php" class="stat-card" style="text-decoration:none;">
  <div class="stat-title">Contact Messages</div>
  <div class="stat-value"><?=$contacts?></div>
  <div class="card-hint">Click to open</div>
</a>


  <a href="partners.php" class="stat-card" style="text-decoration:none;">
    <div class="stat-title">Partner Registrations</div>
    <div class="stat-value"><?=$partners?></div>
    <div class="card-hint">Click to open</div>
  </a>

  <a href="careers.php" class="stat-card" style="text-decoration:none;">
    <div class="stat-title">Career Applications</div>
    <div class="stat-value"><?=$careers?></div>
    <div class="card-hint">Click to open</div>
  </a>
</div>
</div>
</body>
</html>
