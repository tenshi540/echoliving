<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Echo Living - About Us</title>
    <link rel="stylesheet" href="res/css/prisma.css">
</head>
<body>
    <header>
        <h1>Echo Living</h1>
        <nav>
            <ul>
                <li><a href="index.php">Startseite</a></li>
                <li><a href="product.php">Produkte</a></li>
                <li><a href="cart.php">Warenkorb</a></li>
                <li><a href="Account.php">Konto</a></li>
                <li><a href="about.php">Über uns</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <section class="hero">
            <img src="res/img/AboutUS.jpg" alt="Living Hall" width="100%" >
            <h2>About Echo Living</h2>
            <p>Echo Living is a modern webshop focused on sustainability and design. We offer eco-conscious furniture for stylish, green living.</p>
        </section>
    
<div style="text-align:center; margin: 40px 0;">
    <button onclick="window.location.href='feedback.php'" style="background-color:#f7931e; color:white; padding:10px 20px; border:none; border-radius:5px;">Feedback Geben</button>
</div>


<?php include('footer.php'); ?>
</body>
</html>
<?php
?>