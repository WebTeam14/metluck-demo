<?php
session_start();
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $user = $stmt->get_result()->fetch_assoc();

  if ($user && hash('sha256', $password) === $user["password"]) {
      $_SESSION["admin"] = $user["username"];
      header("Location: index.php");
      exit;
  }

  $error = "Invalid username or password";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
</head>
<body>

<h2>Admin Login</h2>

<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
  <label>Username</label><br>
  <input name="username" required><br><br>

  <label>Password</label><br>
  <input type="password" name="password" required><br><br>

  <button type="submit">Login</button>
</form>

</body>
</html>
