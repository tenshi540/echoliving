<?php
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bewerbungsmatrix</title>
    <link rel="stylesheet" href="res/css/prisma.css">
</head>
<body>
    <header>
        <h1>Bewerbungskriterien</h1>
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
        <table>
            <tr><th>Kriterium</th><th>Erfüllt</th></tr>
            <tr><td>Responsive Design</td><td><input type="checkbox" checked></td></tr>
            <tr><td>Farbschema angepasst</td><td><input type="checkbox" checked></td></tr>
            <tr><td>Mind. 3 HTML Seiten</td><td><input type="checkbox" checked></td></tr>
            <tr><td>CSS Separiert</td><td><input type="checkbox" checked></td></tr>
            <tr><td>Formulare</td><td><input type="checkbox" checked></td></tr>
            <tr><td>AJAX genutzt</td><td><input type="checkbox"></td></tr>
            <tr><td>PHP integriert</td><td><input type="checkbox" checked></td></tr>
        </table>

        <button class="save-btn">Speichern</button>
    </div>

    

<script>
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    // Load saved state
    checkboxes.forEach((checkbox, index) => {
        const saved = localStorage.getItem('bewerbung_check_' + index);
        checkbox.checked = saved === 'true';
    });

    // Save state on click
    document.querySelector('.save-btn').addEventListener('click', () => {
        checkboxes.forEach((checkbox, index) => {
            localStorage.setItem('bewerbung_check_' + index, checkbox.checked);
        });
        alert('Status gespeichert.');
    });
</script>
<?php include('footer.php'); ?>
</body>
</html>
<?php
?>