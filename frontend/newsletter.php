<?php
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Newsletter</title>
    <link rel="stylesheet" href="res/css/prisma.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Newsletter abonnieren</h1>
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
            <form id="newsletterForm" style="max-width: 400px; margin: auto; display: flex; flex-direction: column; gap: 10px;">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">E-Mail:</label>
                <input type="email" id="email" name="email" required>

                <button type="submit" class="btn-checkin" style="background-color:#f7931e;">Abonnieren</button>
            </form>
            <div id="response" style="margin-top: 20px;"></div>
        </section>
    </div>

    <?php include('footer.php'); ?>

    <script>
        $('#newsletterForm').on('submit', function(e) {
            e.preventDefault();
            const name = $('#name').val();
            const email = $('#email').val();

            $.ajax({
                url: 'newsletter_response.php',
                type: 'POST',
                data: { name: name, email: email },
                success: function(data) {
                    $('#response').html('<p>' + data + '</p>');
                }
            });
        });
    </script>
</body>
</html>
<?php
?>