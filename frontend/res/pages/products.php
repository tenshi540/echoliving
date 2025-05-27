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

  <p id="no-results" style="display:none; text-align:center; margin-top:1rem;">
    womp womp
  </p>
</main>

<?php include('../../omega.php'); ?>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const productList = document.getElementById('product-list');
    const noResults = document.getElementById('no-results');

    // Observe changes in product list to toggle the no-results message
    const observer = new MutationObserver(() => {
      if (productList.children.length === 0) {
        noResults.style.display = 'block';
      } else {
        noResults.style.display = 'none';
      }
    });

    observer.observe(productList, { childList: true });
  });
</script>

<script src="/echoliving/frontend/res/js/cart.js" defer></script>
<script src="/echoliving/frontend/res/js/products.js" defer></script>
</body>
</html>
