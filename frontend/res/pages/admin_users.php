<?php
// admin_users.php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header("Location:/echoliving/frontend/res/pages/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin – Manage Users</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include __DIR__ . '/../../compass.php'; ?>

  <main style="max-width:1000px; margin:100px auto; padding:1rem;">
    <h1>Manage Users</h1>
    <div id="users-container">
      <!-- Users table will be injected here -->
    </div>
  </main>

  <?php include __DIR__ . '/../../omega.php'; ?>

  <script src="../js/adminUsersQuery.js" defer></script>
</body>
</html>
