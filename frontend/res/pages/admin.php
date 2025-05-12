<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: /echoliving/frontend/res/pages/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard – EchoLiving</title>
    <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
<?php include('../../compass.php'); ?>

  <main class="admin-page" style="max-width:900px; margin:2rem auto; padding:1rem;">
    <h1>Admin Dashboard</h1>
    <div class="admin-links" style="display:flex; gap:1rem; margin-top:1rem;">
      <a href="/echoliving/frontend/res/pages/admin_products.php" class="button">Manage Products</a>
      <a href="/echoliving/frontend/res/pages/admin_users.php"    class="button">Manage Users</a>
    </div>
  </main>

<?php include('../../omega.php'); ?>
</body>
</html>
