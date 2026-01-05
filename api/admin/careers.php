<?php
include "auth.php";
include "../config.php";

$search = $_GET["q"] ?? "";

/* ===== Stats ===== */

$total = $conn->query("
  SELECT COUNT(*) t FROM career_applications
")->fetch_assoc()["t"];

$today = $conn->query("
  SELECT COUNT(*) t FROM career_applications
  WHERE DATE(created_at) = CURDATE()
")->fetch_assoc()["t"];

$week = $conn->query("
  SELECT COUNT(*) t FROM career_applications
  WHERE YEARWEEK(created_at) = YEARWEEK(NOW())
")->fetch_assoc()["t"];

/* ===== Records Query ===== */

$sql = "
 SELECT id, full_name, email, phone, position, message, created_at
 FROM career_applications
 WHERE full_name LIKE ?
    OR email LIKE ?
    OR position LIKE ?
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
<title>Career Applications</title>
<link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-container">

<div class="topbar">
  <h2>Career Applications</h2>

  <div class="user-info">
    Logged in as <b><?=$_SESSION["admin"]?></b>
    <a class="btn-logout" href="logout.php">Logout</a>
  </div>
</div>

<div class="stats-grid">

  <div class="stat-card">
    <div class="stat-title">Total Applications</div>
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
    name="q"
    class="search-input"
    placeholder="Search name / email / position"
    value="<?=$search?>"
  >
  <button class="btn-search">Search</button>
</form>


<div class="table-wrapper">

<table>
<tr>
 <th>ID</th>
 <th>Full Name</th>
 <th>Email</th>
 <th>Phone</th>
 <th>Position</th>
 <th>Message</th>
 <th>Date</th>
 <th>Action</th>
</tr>

<?php if ($result->num_rows === 0) { ?>
<tr>
 <td colspan="8" class="empty-state">No records found</td>
</tr>
<?php } ?>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
 <td><?=$row["id"]?></td>
 <td><?=$row["full_name"]?></td>
 <td><?=$row["email"]?></td>
 <td><?=$row["phone"]?></td>
 <td><?=$row["position"]?></td>
 <td><?=$row["message"]?></td>
 <td><?=$row["created_at"]?></td>

 <td>
   <a
     class="btn-delete"
     href="careers-delete.php?id=<?=$row['id']?>"
     onclick="return confirm('Delete this record?')"
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
