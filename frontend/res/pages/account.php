<?php
// account.php
session_start();
// Only session-start; backend logic lives in fetchAccountData.php
if (empty($_SESSION['user_id'])) {
    header("Location:/echoliving/frontend/res/pages/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>My Account – EchoLiving</title>
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include __DIR__ . '/../../compass.php'; ?>

  <main style="max-width:800px; margin:100px auto; padding:1rem;">
    <h2>My Orders</h2>
    <div id="orders-container">
      <!-- Orders table will be injected here -->
    </div>

    <h2 style="margin-top:2rem;">Edit Your Data</h2>
    <div id="edit-container">
      <!-- Edit form will be injected here -->
    </div>
  </main>

  <?php include __DIR__ . '/../../omega.php'; ?>

  <!-- Load account data & render everything via JS -->
  <script src="/echoliving/frontend/res/js/accountQuery.js" defer></script>
</body>
</html>
