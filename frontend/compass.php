<?php
// compass.php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<header>
  <div class="logo">
    <img
      src="/echoliving/frontend/res/img/logo.png"
      alt="EchoLiving"
      style="height:40px"
    >
  </div>
  <nav>
    <div class="nav-left">
      <a href="/echoliving/frontend/index.php">Home</a>
      <a href="/echoliving/frontend/res/pages/products.php">Products</a>
    </div>
    <div class="nav-right" id="nav-right">
      <!-- JS will inject: Cart, Hej/username, Admin (if), Logout or Account -->
    </div>
  </nav>

  <!-- absolute path so this loads on every page -->
  <script src="/echoliving/frontend/res/js/nav.js" defer></script>
</header>
