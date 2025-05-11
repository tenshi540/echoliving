<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="../css/prisma.css">
</head>
<body>

<?php include('../../compass.php'); ?>

<div class="cart-container">
    <h2>Your Cart</h2>
    <div id="cart-items"></div>
    <div class="cart-total">
        Total: €<span id="cart-total">0.00</span><br>
        <button id="checkout-btn" class="cart-checkout">Checkout</button>
    </div>
</div>

<?php include('../../omega.php'); ?>

<!-- make sure cart.js runs first -->
<script src="/echoliving/frontend/res/js/cart.js" defer></script>
<script src="/echoliving/frontend/res/js/checkout.js" defer></script>
</body>
</html>
