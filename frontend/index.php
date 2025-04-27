<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EchoLiving Webshop</title>
    <link rel="stylesheet" href="res/css/prisma.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include('compass.php'); ?>

    <main>
        <section class="hero">
            <h2>Welcome to EchoLiving</h2>
            <p>Discover beautiful products that make life better.</p>
        </section>
        <section class="product-list">
            <div class="product-card">
                <h3>Product Name</h3>
                <img src="res/img/product1.jpg" alt="Product Image">
                <p>€19.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product-card">
                <h3>Product Name</h3>
                <img src="res/img/product2.jpg" alt="Product Image">
                <p>€24.99</p>
                <button>Add to Cart</button>
            </div>
        </section>
    </main>

    <?php include('omega.php'); ?>
    <script src="res/js/tenz.js"></script>
</body>
</html>
