<?php
// admin_products.php
session_start();
// simple session-only init
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header("Location:/echoliving/frontend/res/pages/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin – Products</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include __DIR__ . '/../../compass.php'; ?>

  <main style="max-width:1000px; margin:100px auto; padding:1rem;">
    <h1>Manage Products</h1>

    <!-- Products List -->
    <section>
      <h2>Existing Products</h2>
      <div id="products-container">
        <!-- Filled in by JS -->
      </div>
    </section>

    <!-- New Product Form -->
    <section style="margin-top:2rem;">
      <h2>Add New Product</h2>
      <div id="create-container">
        <!-- Filled in by JS -->
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/../../omega.php'; ?>

  <script src="../js/adminProductsQuery.js" defer></script>
</body>
</html>
