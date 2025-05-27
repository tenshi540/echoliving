// orderDetailsQuery.js
document.addEventListener('DOMContentLoaded', async () => {
  const container = document.getElementById('invoice-container');
  const params    = new URLSearchParams(window.location.search);
  const orderId   = params.get('orderId');

  if (!/^\d+$/.test(orderId)) {
    container.innerHTML = '<p>Invalid order ID.</p>';
    return;
  }

  try {
    // STRICT JSON: send POST with JSON body (no query param)
    const res = await fetch('/echoliving/backend/logic/fetchOrderDetails.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify({ orderId: orderId })
    });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const data = await res.json();
    if (data.error) throw new Error(data.error);

    const { order, user, items } = data;

    // Build HTML
    let html = `
      <h2>Invoice #${order.id}</h2>
      <p><strong>Date:</strong> ${order.date}</p>
      <p><strong>Bill To:</strong><br>
        ${user.salutation} ${user.first_name} ${user.last_name}<br>
        ${user.address}, ${user.postal_code} ${user.city}
      </p>
      <table>
        <thead>
          <tr>
            <th>Product</th><th>Qty</th><th>Unit Price (€)</th><th>Line Total (€)</th>
          </tr>
        </thead>
        <tbody>
    `;
    items.forEach(i => {
      html += `
        <tr>
          <td>${i.name}</td>
          <td>${i.quantity}</td>
          <td>${parseFloat(i.price_per_item).toFixed(2)}</td>
          <td>${(i.quantity * i.price_per_item).toFixed(2)}</td>
        </tr>
      `;
    });
    html += `
        <tr>
          <td colspan="3" style="text-align:right;font-weight:bold;">Total</td>
          <td>${parseFloat(order.total).toFixed(2)}</td>
        </tr>
        </tbody>
      </table>
      <button class="no-print" onclick="window.print()" style="margin-top:1rem;">
        Print Invoice
      </button>
    `;
    container.innerHTML = html;
  } catch (err) {
    console.error('Error loading invoice:', err);
    container.innerHTML = `<p style="color:red;">Error: ${err.message}</p>`;
  }
});
