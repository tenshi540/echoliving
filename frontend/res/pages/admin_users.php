<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../../backend/config/Database.php';
use Config\Database;

$db     = Database::getConnection();
$result = $db->query("SELECT id, username, email, active FROM users ORDER BY id");
// Note: Do not close the DB here so compass.php can open its own connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin – Users | EchoLiving</title>
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include('../../compass.php'); ?>

  <main class="admin-container">
    <h1>User Management</h1>
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($u = $result->fetch_assoc()): ?>
          <?php $userId = (int)$u['id']; ?>
          <?php $action = $u['active'] ? 'deactivate' : 'activate'; ?>
        <tr>
          <td><?= htmlspecialchars($u['id'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($u['username'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= $u['active'] ? 'Yes' : 'No' ?></td>
          <td>
            <a
              href="/echoliving/backend/logic/toggleUser.php?id=<?= $userId ?>&action=<?= $action ?>"
              onclick="return confirm('Are you sure you want to <?= $action ?> this user?');"
              class="btn btn-secondary"
            >
              <?= $u['active'] ? 'Deactivate' : 'Activate' ?>
            </a>
            <a
              href="/echoliving/frontend/res/pages/admin_user_orders.php?user_id=<?= $userId ?>"
              class="btn btn-info"
            >
              View Orders
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>

  <?php include('../../omega.php'); ?>
</body>
</html>