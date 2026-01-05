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
  <link rel="stylesheet" href="css/admin.css">

  <title>Admin Login</title>
</head>
<body>

<div class="admin-container">

<div class="login-wrapper">

  <div class="login-title">Admin Login</div>
  <div class="login-subtext">Secure access panel</div>

  <?php if (!empty($error)) { ?>
    <div class="login-error"><?=$error?></div>
  <?php } ?>

  <form method="POST">

    <div class="login-field">
      <label class="login-label">Username</label>
      <input
        class="login-input"
        name="username"
        required
      >
    </div>

    <div class="login-field">
      <label class="login-label">Password</label>
      <input
        class="login-input"
        type="password"
        name="password"
        required
      >
    </div>

    <button class="btn-login" type="submit">
      Login
    </button>

  </form>

</div>

</div>

</body>

</html>
