<?php
// —————— session + DB lookup ——————
session_start();

// Default to “Account” if not logged in
$accountText = "Account";

// If user is logged in, fetch their username
if (!empty($_SESSION['user_id'])) {
    $mysqli = new mysqli("localhost", "root", "", "echo");
    if (!$mysqli->connect_error) {
        $stmt = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $stmt->bind_result($fetchedUsername);
        if ($stmt->fetch()) {
            // Show “Hello, username” or just username
            $accountText = htmlspecialchars($fetchedUsername, ENT_QUOTES, 'UTF-8');
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>

<header>
  <div class="logo">
    <img src="/echoliving/frontend/res/img/logo.png" alt="EchoLiving" style="height:40px">
  </div>
  <nav>
    <div class="nav-left">
      <a href="/echoliving/frontend/index.php">Home</a>
      <a href="/echoliving/frontend/res/pages/products.php">Products</a>
    </div>
    <div class="nav-right">
  <?php if (!empty($_SESSION['user_id'])): ?>
    <!-- Cart icon + count -->
    <a href="/echoliving/frontend/res/pages/cart.php" class="cart-icon">
    🛒 <span id="cart-count">0</span>
  </a>
    <!-- Username + Logout -->
    <span class="nav-username"><?= htmlspecialchars($accountText, ENT_QUOTES) ?></span>
    <a href="/echoliving/frontend/res/pages/logout.php" class="logout-link">Logout</a>
  <?php else: ?>
    <!-- Cart (guests can still see it) -->
    <a href="/echoliving/frontend/res/pages/cart.php" class="cart-icon">
      <img src="/echoliving/frontend/res/img/cart.png" alt="Cart" style="height:20px;">
      <span id="cart-count">0</span>
    </a>
    <!-- Account link -->
    <a href="/echoliving/frontend/res/pages/login.php" class="nav-link">Account</a>
  <?php endif; ?>
</div>

  </nav>
</header>
