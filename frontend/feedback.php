<?php
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <link rel="stylesheet" href="res/css/prisma.css">
</head>
<body>
    <header>
        <h1>Feedback zu Echo Living</h1>
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
            <p><strong>Echo Living</strong> </p>
            <p>Wir freuen uns über Feedback – sei es zu Layout, Funktionalität oder Benutzerfreundlichkeit. Vielen Dank für Ihre Unterstützung!</p>
            <form style="max-width: 400px; margin: auto; display: flex; flex-direction: column; gap: 10px;">
                <label for="feedback">Ihr Feedback:</label>
                <textarea id="feedback" name="feedback" rows="4"></textarea>
                <button type="submit" class="btn-checkin" style="background-color:#f7931e;">Absenden</button>
            </form>
        </section>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
<?php
?>