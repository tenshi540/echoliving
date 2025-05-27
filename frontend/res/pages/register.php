<?php
// register.php
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
  <title>Create Account – EchoLiving</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include __DIR__ . '/../../compass.php'; ?>

  <main class="login-box">
    <h2 class="login-title">Create Your Account</h2>
    <form id="register-form" class="login-form" enctype="multipart/form-data">
      <div class="form-group">
        <label>Salutation</label>
        <select name="salutation" required>
          <option value="">— Salutation —</option>
          <option>Mr.</option>
          <option>Ms.</option>
          <option>Mx.</option>
        </select>
      </div>
      <div class="form-group">
        <label>First Name</label>
        <input type="text" name="first_name" required>
      </div>
      <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name" required>
      </div>
      <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" required>
      </div>
      <div class="form-group">
        <label>Postal Code</label>
        <input type="text" name="postal_code" required>
      </div>
      <div class="form-group">
        <label>City</label>
        <input type="text" name="city" required>
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" required>
      </div>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="password_repeat" required>
      </div>
      <div class="form-group">
        <label>Payment Info</label>
        <input type="text" name="payment_info" required placeholder="e.g. Visa ****1234">
      </div>

      <button type="submit" class="btn-primary">Register</button>
    </form>
    <p class="login-footer">
      Already have an account? <a href="login.php">Login</a>
    </p>
  </main>

  <?php include __DIR__ . '/../../omega.php'; ?>
  <script src="../js/users.js" defer></script>
</body>
</html>
