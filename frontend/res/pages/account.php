<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location:/echoliving/frontend/res/pages/login.php");
    exit;
}
$uid = $_SESSION['user_id'];
$mysqli = new mysqli("localhost", "root", "", "echo");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Account – EchoLiving</title>
  <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>
<?php include("../../compass.php"); ?>

<main style="max-width:800px;margin:100px auto;padding:1rem;">
  <h2>My Orders</h2>
  <?php
    // Fetch all orders for this user
    $stmt = $mysqli->prepare("
      SELECT id, total_price, created_at
      FROM orders
      WHERE user_id = ?
      ORDER BY created_at DESC
    ");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $orders = $stmt->get_result();
  ?>
  <?php if ($orders->num_rows === 0): ?>
    <p>You haven’t placed any orders yet.</p>
  <?php else: ?>
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr>
          <th>Order #</th>
          <th>Date</th>
          <th>Total (€)</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($o = $orders->fetch_assoc()): ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= $o['created_at'] ?></td>
          <td><?= number_format($o['total_price'],2) ?></td>
          <td>
            <a href="/echoliving/frontend/res/pages/orderDetails.php?orderId=<?= $o['id'] ?>">
              View
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>

<?php include("../../omega.php"); ?>
</body>
</html>
