document.addEventListener("DOMContentLoaded", () => {
    const productList = document.getElementById("product-list");

    fetch("/echoliving/backend/logic/loadProducts.php")
        .then(response => response.json())
        .then(products => {
            productList.innerHTML = ""; // Clear existing (if any)

            products.forEach(product => {
                const productCard = document.createElement("div");
                productCard.className = "product-card";

                productCard.innerHTML = `
                    <img src="/backend/productpictures/${product.image_filename}" alt="${product.name}" style="max-width:100%; height:auto; border-radius: 8px;">
                    <h3>${product.name}</h3>
                    <p>${product.description}</p>
                    <p>Rating: ${product.rating} ⭐</p>
                    <p><strong>€${parseFloat(product.price).toFixed(2)}</strong></p>
                    <button>Add to Cart</button>
                `;

                productList.appendChild(productCard);
            });
        })
        .catch(error => {
            console.error('Error loading products:', error);
            productList.innerHTML = "<p>Failed to load products. Please try again later.</p>";
        });
});
