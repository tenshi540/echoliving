<?php
session_start();
require_once __DIR__ . '/../../../backend/config/Database.php';
use Config\Database;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db   = Database::getConnection();
    $user = trim($_POST['user']);
    $pass = $_POST['password'];

    // fetch by username or email
    $stmt = $db->prepare("
      SELECT id, password_hash, active, is_admin
        FROM users
       WHERE username = ? OR email = ?
      LIMIT 1
    ");
    $stmt->bind_param("ss", $user, $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash, $active, $is_admin);
        $stmt->fetch();

        if (!$active) {
            $error = 'Your account is deactivated.';
        } elseif (password_verify($pass, $hash)) {
            // success → set session and redirect
            $_SESSION['user_id']   = $id;
            $_SESSION['is_admin']  = $is_admin;
            $stmt->close();
            $db->close();
            header('Location: /echoliving/frontend/index.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Invalid username or password.';
    }
    $stmt->close();
    $db->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login | EchoLiving</title>
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include('../../compass.php'); ?>

  <div class="auth-container">
    <div class="auth-card">
      <h2 class="auth-title">Login to Your Account</h2>

      <?php if ($error): ?>
        <script>alert("<?= addslashes($error) ?>");</script>
      <?php endif; ?>

      <form id="login-form" method="post">
        <input type="text" name="user" placeholder="Username or Email" class="auth-input" required>
        <input type="password" name="password" placeholder="Password" class="auth-input" required>
        <button type="submit" class="auth-button">Login</button>
      </form>

      <div class="auth-footer">
        Don’t have an account?
        <a href="/echoliving/frontend/res/pages/register.php">Register</a>
      </div>
    </div>
  </div>

  <?php include('../../omega.php'); ?>
</body>
</html>
