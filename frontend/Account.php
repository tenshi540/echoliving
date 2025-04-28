<?php
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Konto</title>
    <link rel="stylesheet" href="res/css/prisma.css">
</head>
<body style="display:flex;flex-direction:column;height:100%">
    <header>

        <h1>Konto</h1>

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

    <div class="container" style="flex:1">
        <section class="hero">
            <h2 style="font-size: 2rem; margin-bottom: 10px;">Konto Login</h2>
            <form style="max-width: 400px; margin: auto; display: flex; flex-direction: column; gap: 10px;">
                <label for="username">Benutzername:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Passwort:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="btn" style="background-color: #80bfa3; color: white; padding: 10px; border: none; border-radius: 5px;">Anmelden</button>
            </form>
        </section>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
<?php
?>