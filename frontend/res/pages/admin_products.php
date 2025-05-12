<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../../backend/config/Database.php';
use Config\Database;

$db     = Database::getConnection();
$result = $db->query("
  SELECT id, name, description, price
    FROM products
   ORDER BY id
");
// ← note: no $db->close() here
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin – Products | EchoLiving</title>
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include('../../compass.php'); ?>

  <main class="admin-container">
    <h1>Product Management</h1>
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($p = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($p['id'],   ENT_QUOTES,'UTF-8') ?></td>
            <td><?= htmlspecialchars($p['name'], ENT_QUOTES,'UTF-8') ?></td>
            <td><?= htmlspecialchars($p['description'], ENT_QUOTES,'UTF-8') ?></td>
            <td><?= htmlspecialchars($p['price'], ENT_QUOTES,'UTF-8') ?> €</td>
            <td>
              <a
                href="/echoliving/backend/logic/deleteProduct.php?id=<?= htmlspecialchars($p['id'], ENT_QUOTES,'UTF-8') ?>"
                onclick="return confirm('Really delete this product?');"
                class="btn btn-danger"
              >
                Delete
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
