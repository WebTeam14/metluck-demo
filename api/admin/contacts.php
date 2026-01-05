<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "auth.php";
include "../config.php";

$search = $_GET["q"] ?? "";

/* ===== Dashboard Stats ===== */

$total = $conn->query("
  SELECT COUNT(*) AS t FROM contact_submissions
")->fetch_assoc()["t"];

$today = $conn->query("
  SELECT COUNT(*) AS t FROM contact_submissions
  WHERE DATE(created_at) = CURDATE()
")->fetch_assoc()["t"];

$week = $conn->query("
  SELECT COUNT(*) AS t FROM contact_submissions
  WHERE YEARWEEK(created_at) = YEARWEEK(NOW())
")->fetch_assoc()["t"];

/* ===== Table Query ===== */

$sql = "
  SELECT id, name, email, phone, subject, message, created_at
  FROM contact_submissions
  WHERE name LIKE ? OR email LIKE ? OR subject LIKE ?
  ORDER BY created_at DESC
";

$like = "%$search%";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();

$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin – Messages</title>
  <link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-container">

<div class="topbar">
  <h2>Contact Form Messages</h2>

  <div class="user-info">
    Logged in as <b><?=$_SESSION["admin"]?></b>
    <a class="btn-logout" href="logout.php">Logout</a>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-title">Total Messages</div>
    <div class="stat-value"><?=$total?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">Today</div>
    <div class="stat-value"><?=$today?></div>
  </div>

  <div class="stat-card">
    <div class="stat-title">This Week</div>
    <div class="stat-value"><?=$week?></div>
  </div>
</div>

<form method="GET" class="search-box">
  <input
    type="text"
    name="q"
    class="search-input"
    placeholder="Search name / email / subject"
    value="<?=$search?>"
  />
  <button class="btn-search" type="submit">Search</button>
</form>

<div class="table-wrapper">

<table>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Email</th>
  <th>Phone</th>
  <th>Subject</th>
  <th>Message</th>
  <th>Date</th>
  <th>Action</th>
</tr>

<?php if ($result->num_rows === 0) { ?>
<tr>
  <td colspan="8" class="empty-state">No records found</td>
</tr>
<?php } ?>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?=$row["id"]?></td>
  <td><?=$row["name"]?></td>
  <td><?=$row["email"]?></td>
  <td><?=$row["phone"]?></td>
  <td><?=$row["subject"]?></td>
  <td><?=$row["message"]?></td>
  <td><?=$row["created_at"]?></td>

  <td>
    <a
      class="btn-delete"
      href="delete.php?id=<?=$row['id']?>"
      onclick="return confirm('Delete this entry?')"
    >
      Delete
    </a>
  </td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>
