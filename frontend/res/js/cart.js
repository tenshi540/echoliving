// read cart from localStorage
function getCart() {
  return JSON.parse(localStorage.getItem('cart')) || {};
}

// update the little badge in the nav
function updateCartCount() {
  const cart = getCart();
  const countEl = document.getElementById('cart-count');
  if (!countEl) return;
  const totalCount = Object.values(cart).reduce((sum, n) => sum + n, 0);
  countEl.textContent = totalCount;
  // bump animation if you want:
  countEl.classList.add('bump');
  setTimeout(() => countEl.classList.remove('bump'), 300);
}

// build the cart list & total
function loadCart() {
  const cart = getCart();
  const itemsContainer = document.getElementById('cart-items');
  let total = 0;

  if (!Object.keys(cart).length) {
    itemsContainer.innerHTML = "<p>Your cart is empty.</p>";
    document.getElementById('cart-total').textContent = "0.00";
    return;
  }

  itemsContainer.innerHTML = "";

  fetch("/echoliving/backend/logic/loadProducts.php")
    .then(r => r.json())
    .then(products => {
      Object.keys(cart).forEach(id => {
        const product = products.find(p => p.id == id);
        const qty = cart[id];
        const price = parseFloat(product.price);
        total += price * qty;

        const item = document.createElement("div");
        item.className = "cart-item";
        item.innerHTML = `
          <div class="cart-item-info">
            <img src="/echoliving/backend/productpictures/${product.image_filename}" alt="${product.name}">
            <span class="cart-item-title">${product.name}</span>
          </div>
          <span class="cart-item-price">€${price.toFixed(2)}</span>
          <div class="cart-item-quantity">
            <button onclick="changeQuantity(${id}, -1)">-</button>
            <input type="text" value="${qty}" readonly>
            <button onclick="changeQuantity(${id}, 1)">+</button>
          </div>
          <button class="cart-item-remove" onclick="removeItem(${id})">🗑️</button>
        `;
        itemsContainer.appendChild(item);
      });

      document.getElementById('cart-total').textContent = total.toFixed(2);
    });
}

function changeQuantity(id, delta) {
  const cart = getCart();
  if (!cart[id]) return;
  cart[id] += delta;
  if (cart[id] < 1) delete cart[id];
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
  loadCart();
}

function removeItem(id) {
  const cart = getCart();
  cart[id] && delete cart[id];
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
  loadCart();
}

document.addEventListener("DOMContentLoaded", () => {
  updateCartCount();  // this line fixes the missing badge on cart.php
  loadCart();
});
