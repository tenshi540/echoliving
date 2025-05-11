<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Products | EchoLiving</title>
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>

<?php include('../../compass.php'); ?>

<main style="padding: 2rem; max-width: 1200px; margin: auto;">
  <h1 style="text-align:center; margin-bottom:1rem;">Our Products</h1>
  <input
  type="text"
  id="product-search"
  placeholder="Search products…"
  class="auth-input"
  style="max-width:400px; margin:1rem auto; display:block;"
>
<div id="product-list"></div>

  <div id="product-list"></div>
</main>

<?php include('../../omega.php'); ?>

<script src="/echoliving/frontend/res/js/cart.js" defer></script>
<script src="/echoliving/frontend/res/js/products.js" defer></script>
</body>
</html>
