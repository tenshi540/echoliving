<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Echo Living - Products</title>
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
            <h2>Our Products</h2>
            <div class="product-row">
                <div class="product-card">
                    <img src="res/img/Couch.jpeg" alt="Couch">
                    <p>Eco Couch</p>
                </div>
                <div class="product-card">
                    <img src="res/img/Sofa.jpeg" alt="Sofa">
                    <p>Modern Sofa</p>
                </div>
                <div class="product-card">
                    <img src="res/img/Springbed.jpeg" alt="Springbed">
                    <p>Spring Bed</p>
                </div>
            </div>
        </section>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
<?php
?>