<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" type="text/css" href="/echoliving/frontend/res/css/prisma.css">
    <script src="/echoliving/frontend/res/js/cart.js" defer></script>
</head>
<body>

<?php include('../../compass.php'); ?>

<div class="cart-container">
    <h2>Your Cart</h2>
    <div id="cart-items"></div>
    <div class="cart-total">
        Total: €<span id="cart-total">0.00</span>
        <br>
        <a href="#" class="cart-checkout">Checkout</a>
    </div>
</div>
<?php include('../../omega.php'); ?>
</body>
</html>
