<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_GET['orderId'])) {
  header("Location:/echoliving/frontend/res/pages/login.php");
  exit;
}
$orderId = (int)$_GET['orderId'];
$uid = $_SESSION['user_id'];

$mysqli = new mysqli("localhost","root","","echo");
// verify ownership + get order
$stmt = $mysqli->prepare(
  "SELECT total_price, created_at FROM orders
   WHERE id=? AND user_id=?"
);
$stmt->bind_param("ii",$orderId,$uid);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows===0) {
  die("Order not found");
}
$stmt->bind_result($total,$date);
$stmt->fetch();
$stmt->close();

// get items + user data
$stmt = $mysqli->prepare(
  "SELECT p.name, oi.quantity, oi.price_per_item
   FROM order_items oi
   JOIN products p ON p.id=oi.product_id
   WHERE oi.order_id=?"
);
$stmt->bind_param("i",$orderId);
$stmt->execute();
$res = $stmt->get_result();

// fetch user for address
$stmt = $mysqli->prepare(
  "SELECT salutation,first_name,last_name,address,postal_code,city
   FROM users WHERE id=?"
);
$stmt->bind_param("i",$uid);
$stmt->execute();
$stmt->bind_result($sal,$fn,$ln,$addr,$pc,$city);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html><html><head>
  <meta charset="utf-8"><title>Invoice #<?= $orderId ?></title>
  <link rel="stylesheet" href="../css/prisma.css">
  <style>
    @media print { .no-print{display:none;} }
    .invoice {max-width:800px;margin:50px auto;}
    .invoice h2{text-align:center;}
    .invoice table{width:100%;border-collapse:collapse;margin-top:1rem;}
    .invoice th, .invoice td{border:1px solid #ddd;padding:8px;}
  </style>
</head><body>
<?php include("../../compass.php"); ?>

<div class="invoice">
  <h2>Invoice #<?= $orderId ?></h2>
  <p><strong>Date:</strong> <?= $date ?></p>
  <p><strong>Bill To:</strong><br>
     <?= "$sal $fn $ln" ?><br>
     <?= "$addr, $pc $city" ?></p>

  <table>
    <thead>
      <tr><th>Product</th><th>Qty</th><th>Unit Price (€)</th><th>Line Total (€)</th></tr>
    </thead>
    <tbody>
    <?php foreach ($res as $row): ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= number_format($row['price_per_item'],2) ?></td>
        <td><?= number_format($row['quantity']*$row['price_per_item'],2) ?></td>
      </tr>
    <?php endforeach; ?>
      <tr>
        <td colspan="3" style="text-align:right;font-weight:bold;">Total</td>
        <td><?= number_format($total,2) ?></td>
      </tr>
    </tbody>
  </table>

  <button class="no-print" onclick="window.print()" style="margin-top:1rem;">
    Print Invoice
  </button>
</div>

<?php include("../../omega.php"); ?>
</body></html>
