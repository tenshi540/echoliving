document.addEventListener("DOMContentLoaded", () => {
    const productList = document.getElementById("product-list");

    let cart = JSON.parse(localStorage.getItem('cart')) || {};
updateCartCount();

function updateCartCount() {
    const cartCount = Object.values(cart).reduce((a, b) => a + b, 0);
    const cartIcon = document.getElementById("cart-count");
    if (cartIcon) {
        cartIcon.textContent = cartCount;
        cartIcon.classList.add("bump");
        setTimeout(() => cartIcon.classList.remove("bump"), 300);
    }
}


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
                    <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>

                `;

                productList.appendChild(productCard);
                productCard.querySelector(".add-to-cart").addEventListener("click", (e) => {
                    const id = e.target.getAttribute("data-id");
                
                    cart[id] = (cart[id] || 0) + 1;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                });
                
            });
        })
        .catch(error => {
            console.error('Error loading products:', error);
            productList.innerHTML = "<p>Failed to load products. Please try again later.</p>";
        });
});
