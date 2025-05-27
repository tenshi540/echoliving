<?php
// admin_user_orders.php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header("Location:/echoliving/frontend/res/pages/login.php");
    exit;
}

// 1) Read from $_GET['user_id'] instead of 'id'
$userId = $_GET['user_id'] ?? '';
if (!ctype_digit($userId)) {
    echo "Invalid user ID";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin: User Orders</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include __DIR__ . '/../../compass.php'; ?>

  <main style="max-width:800px; margin:100px auto; padding:1rem;">
    <h1>Orders for User #<?= htmlspecialchars($userId) ?></h1>
    <div id="items-container">
      <!-- JS will render the order items table -->
    </div>
  </main>

  <?php include __DIR__ . '/../../omega.php'; ?>

  <script src="../js/adminUserOrdersQuery.js" defer></script>
</body>
</html>
