<?php
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
    <link rel="stylesheet" href="res/css/prisma.css">
</head>
<body>
    <header>
        <h1>Registrieren</h1>
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
        <form style="max-width: 400px; margin: auto; display: flex; flex-direction: column; gap: 10px;">
            <label for="newuser">Benutzername:</label>
            <input type="text" id="newuser" name="newuser" required>
            <label for="newpass">Passwort:</label>
            <input type="password" id="newpass" name="newpass" required>
            <button type="submit" class="btn-checkin" style="background-color:#f7931e;">Registrieren</button>
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
<?php
?>