<?php
?>            


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Echo Living - Startseite</title>
    <link rel="stylesheet" href="res/css/prisma.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
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

    <!-- Info Button oben rechts -->
    <a href="bewerbungsmatrix.php" class="info-button" title="Zur Bewerbungsmatrix">i</a>

    <div class="container text-center">
        <section class="hero">
            <img src="res/img/MainPage EchoLiving.avif" alt="Echo Living Hauptbild" class="img-fluid">
            <h2>Willkommen bei Echo Living</h2>
            <p>Gestalte deinen Raum nachhaltig. Entdecke modernes, umweltbewusstes Design.</p>
        </section>
    </div>

   
    <?php include('footer.php'); ?>
</body>
</html>

<?php
?>