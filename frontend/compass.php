<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . "/../backend/config/Database.php";
use config\Database;

// <— brand-new link every time, so closes elsewhere don’t affect us
$db = Database::getConnection();

$accountText = "Account";
if (!empty($_SESSION['user_id']) && !$db->connect_error) {
    $stmt = $db->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($fetchedUsername);
    if ($stmt->fetch()) {
        $accountText = htmlspecialchars($fetchedUsername, ENT_QUOTES, 'UTF-8');
    }
    $stmt->close();
    $db->close();
}
?>

<header>
  <div class="logo">
    <img src="/echoliving/frontend/res/img/logo.png"
         alt="EchoLiving"
         style="height:40px">
  </div>
  <nav>
    <div class="nav-left">
      <a href="/echoliving/frontend/index.php">Home</a>
      <a href="/echoliving/frontend/res/pages/products.php">Products</a>
    </div>
    <div class="nav-right">
      <!-- cart always visible -->
      <a href="/echoliving/frontend/res/pages/cart.php" class="cart-icon">
        🛒 <span id="cart-count">0</span>
      </a>

      <?php if (!empty($_SESSION['user_id'])): ?>
        <!-- Logged-in user -->
        <a href="/echoliving/frontend/res/pages/account.php"
           class="nav-username">
          Hej, <?= $accountText ?>
        </a>

        <!-- only show this if the user is an admin -->
        <?php if (!empty($_SESSION['is_admin'])): ?>
          <a href="/echoliving/frontend/res/pages/admin.php"
             class="nav-link">
            Admin
          </a>
        <?php endif; ?>

        <a href="/echoliving/frontend/res/pages/logout.php"
           class="logout-link">
          Logout
        </a>
      <?php else: ?>
        <!-- Guest -->
        <a href="/echoliving/frontend/res/pages/login.php"
           class="nav-link">
          Account
        </a>
      <?php endif; ?>
    </div>
  </nav>
</header>
