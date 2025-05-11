<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login | EchoLiving</title>
  <link rel="stylesheet" href="../css/prisma.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;600&display=swap" rel="stylesheet">
  <script src="/echoliving/frontend/res/js/users.js" defer></script>
</head>
<body>

  <?php include('../../compass.php'); ?>

<div class="auth-container">
  <div class="auth-card">
    <h2 class="auth-title">Login to Your Account</h2>

    <form id="login-form" method="post">
      <input 
        type="text" 
        name="user" 
        placeholder="Username or Email" 
        class="auth-input" 
        required
      >

      <input 
        type="password" 
        name="password" 
        placeholder="Password" 
        class="auth-input" 
        required
      >


      <button type="submit" class="auth-button">Login</button>

      <div class="auth-footer">
        Don’t have an account? 
        <a href="/echoliving/frontend/res/pages/register.php">Register</a>
      </div>
    </form>
  </div>
</div>

  <?php include('../../omega.php'); ?>

</body>
</html>
