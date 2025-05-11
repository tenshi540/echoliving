document.addEventListener("DOMContentLoaded", function() {
  const btn = document.getElementById('checkout-btn');
  if (!btn) return;

  btn.addEventListener('click', async function() {
    // read cart straight from localStorage
    const cart = JSON.parse(localStorage.getItem('cart')) || {};
    if (Object.keys(cart).length === 0) {
      alert('Your cart is empty.');
      return;
    }

    // disable and show feedback
    btn.disabled = true;
    btn.textContent = 'Placing order…';

    try {
      const response = await fetch('/echoliving/backend/logic/placeOrder.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ cart })
      });
      const result = await response.json();

      if (result.success) {
        // clear & update
        localStorage.removeItem('cart');
        if (typeof updateCartCount === 'function') updateCartCount();
        if (typeof loadCart === 'function') loadCart();

        alert(`Thank you! Your order #${result.orderId} has been placed.`);
        // go to order history
        window.location.href = '/echoliving/frontend/res/pages/account.php';
      } else {
        throw new Error(result.message);
      }
    } catch (err) {
      console.error('Checkout error:', err);
      alert('Checkout failed: ' + err.message);
      btn.disabled = false;
      btn.textContent = 'Checkout';
    }
  });
});
