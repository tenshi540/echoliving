<?php
session_start();
if (empty($_SESSION['user_id']) || !isset($_GET['orderId'])) {
    header("Location:/echoliving/frontend/res/pages/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice #<?= htmlspecialchars($_GET['orderId']) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/prisma.css">
  <style>
    @media print { .no-print{display:none;} }
    .invoice { max-width:800px; margin:50px auto; }
    .invoice h2 { text-align:center; }
    .invoice table { width:100%; border-collapse:collapse; margin-top:1rem; }
    .invoice th, .invoice td { border:1px solid #ddd; padding:8px; }
  </style>
</head>
<body>
  <?php include __DIR__ . '/../../compass.php'; ?>

  <div id="invoice-container" class="invoice">
    <!-- rendered by JS -->
  </div>

  <?php include __DIR__ . '/../../omega.php'; ?>
  <script src="../js/orderDetailsQuery.js" defer></script>
</body>
</html>
