<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../../backend/config/Database.php';
use Config\Database;

$db = Database::getConnection();

// 1) Validate + fetch the target user
$userId = isset($_GET['user_id']) && ctype_digit($_GET['user_id'])
        ? (int)$_GET['user_id']
        : null;
if (!$userId) {
    header('Location: admin_users.php');
    exit;
}

$stmt = $db->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($firstName, $lastName);
if (!$stmt->fetch()) {
    // no such user
    $stmt->close();
    $db->close();
    header('Location: admin_users.php');
    exit;
}
$stmt->close();

// 2) Load all orders for that user
$stmt = $db->prepare("
    SELECT id, created_at
      FROM orders
     WHERE user_id = ?
  ORDER BY created_at DESC
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$ordersRes = $stmt->get_result();
$stmt->close();

// 3) For each order, fetch items and compute a fresh total
$allOrders = [];
while ($order = $ordersRes->fetch_assoc()) {
    $oid = (int)$order['id'];

    // fetch items
    $itemStmt = $db->prepare("
      SELECT oi.id,
             p.name        AS product_name,
             oi.quantity,
             oi.price_per_item
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
       WHERE oi.order_id = ?
    ");
    $itemStmt->bind_param("i", $oid);
    $itemStmt->execute();
    $itemsRes = $itemStmt->get_result();
    $itemStmt->close();

    $items     = [];
    $orderTotal = 0.0;
    while ($it = $itemsRes->fetch_assoc()) {
        $items[] = $it;
        $orderTotal += $it['quantity'] * $it['price_per_item'];
    }

    $allOrders[] = [
        'id'         => $oid,
        'created_at' => $order['created_at'],
        'total'      => $orderTotal,
        'items'      => $items,
    ];
}

// 4) We’re done with DB: close it

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Orders for <?= htmlspecialchars("$firstName $lastName", ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
  <?php include('../../compass.php'); ?>

  <main class="admin-container">
    <h1>Orders for <?= htmlspecialchars("$firstName $lastName", ENT_QUOTES, 'UTF-8') ?></h1>

    <?php if (empty($allOrders)): ?>
      <p>No orders found for this user.</p>
    <?php else: ?>
      <?php foreach ($allOrders as $order): ?>
        <section class="order-block">
          <h2>
            Order #<?= $order['id'] ?>
            &mdash; <?= htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8') ?>
          </h2>
          <p><strong>Total:</strong> €<?= number_format($order['total'], 2) ?></p>

          <?php if (empty($order['items'])): ?>
            <p><em>No items in this order.</em></p>
          <?php else: ?>
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Item ID</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Price Each</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($order['items'] as $it): ?>
                  <tr>
                    <td><?= (int)$it['id'] ?></td>
                    <td><?= htmlspecialchars($it['product_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= (int)$it['quantity'] ?></td>
                    <td>€<?= number_format($it['price_per_item'], 2) ?></td>
                    <td>
                      <a
                        href="/echoliving/backend/logic/deleteOrderItem.php?item_id=<?= (int)$it['id'] ?>&user_id=<?= $userId ?>"
                        onclick="return confirm('Remove this item?');"
                        class="btn btn-danger"
                      >
                        Delete Item
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>
  </main>

  <?php include('../../omega.php'); ?>
</body>
</html>
