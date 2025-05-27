<?php
// login.php
session_start();
if (!empty($_SESSION['user_id'])) {
    header("Location:/echoliving/frontend/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login – EchoLiving</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include __DIR__ . '/../../compass.php'; ?>

  <main class="login-box">
    <h2 class="login-title">Login to Your Account</h2>
    <form id="login-form" class="login-form">
      <div class="form-group">
        <label>Username or Email</label>
        <input type="text" name="username" required placeholder="Username or Email">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required placeholder="Password">
      </div>
      <button type="submit" class="btn-primary">Login</button>
    </form>
    <p class="login-footer">
      Don’t have an account? <a href="register.php">Register</a>
    </p>
  </main>

  <?php include __DIR__ . '/../../omega.php'; ?>
  <script src="../js/users.js" defer></script>
</body>
</html>
