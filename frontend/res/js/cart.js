function loadCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || {};
    const itemsContainer = document.getElementById('cart-items');
    let total = 0;

    if (Object.keys(cart).length === 0) {
        itemsContainer.innerHTML = "<p>Your cart is empty.</p>";
        document.getElementById('cart-total').textContent = "0.00";
        return;
    }

    itemsContainer.innerHTML = "";

    fetch("/echoliving/backend/logic/loadProducts.php")
        .then(response => response.json())
        .then(products => {
            Object.keys(cart).forEach(id => {
                const product = products.find(p => p.id == id);
                const quantity = cart[id];
                const price = parseFloat(product.price);
                total += price * quantity;

                const item = document.createElement("div");
                item.className = "cart-item";

                item.innerHTML = `
                    <div class="cart-item-info">
                        <img src="/backend/productpictures/${product.image_filename}" alt="${product.name}">
                        <span class="cart-item-title">${product.name}</span>
                    </div>
                    <span class="cart-item-price">€${price.toFixed(2)}</span>
                    <div class="cart-item-quantity">
                        <button onclick="changeQuantity(${id}, -1)">-</button>
                        <input type="text" value="${quantity}" readonly>
                        <button onclick="changeQuantity(${id}, 1)">+</button>
                    </div>
                    <button class="cart-item-remove" onclick="removeItem(${id})">🗑️</button>
                `;

                itemsContainer.appendChild(item);
            });

            document.getElementById('cart-total').textContent = total.toFixed(2);
        });
}

function changeQuantity(id, change) {
    const cart = JSON.parse(localStorage.getItem('cart')) || {};
    if (!cart[id]) return;

    cart[id] += change;
    if (cart[id] <= 0) {
        delete cart[id];
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart();
}

function removeItem(id) {
    const cart = JSON.parse(localStorage.getItem('cart')) || {};
    const itemElement = document.querySelector(`.cart-item button[onclick="removeItem(${id})"]`).parentElement;

    // Add animation class
    itemElement.classList.add("removing");

    // Wait for animation, then remove from cart and reload
    setTimeout(() => {
        delete cart[id];
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
    }, 300); // matches CSS transition time
}


document.addEventListener("DOMContentLoaded", loadCart);
