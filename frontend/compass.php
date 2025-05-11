<?php

require_once __DIR__ . "/../backend/config/Database.php";
use config\Database;
$db = Database::getConnection();

// Default link text
$accountText = "Account";

// If logged in, fetch the username
if (!empty($_SESSION['user_id'])) {
    

    if (!$db->connect_error) {
        $stmt = $db->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $stmt->bind_result($fetchedUsername);
        if ($stmt->fetch()) {
            $accountText = htmlspecialchars($fetchedUsername, ENT_QUOTES, 'UTF-8');
        }
        $stmt->close();
    }
    $db->close();
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
      <!-- cart is always visible -->
      <a href="/echoliving/frontend/res/pages/cart.php" class="cart-icon">
        🛒 <span id="cart-count">0</span>
      </a>

      <?php if (!empty($_SESSION['user_id'])): ?>
        <!-- Logged-in: username links to account.php -->
        <a href="/echoliving/frontend/res/pages/account.php" class="nav-username">
          Hej, <?= $accountText ?>
        </a>
        <a href="/echoliving/frontend/res/pages/logout.php" class="logout-link">Logout</a>
      <?php else: ?>
        <!-- Guest: link to login/register -->
        <a href="/echoliving/frontend/res/pages/login.php" class="nav-link">Account</a>
      <?php endif; ?>
    </div>
  </nav>
</header>
