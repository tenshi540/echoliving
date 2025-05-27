// adminUserOrdersQuery.js
document.addEventListener('DOMContentLoaded', async () => {
  const itemsEl = document.getElementById('items-container');
  const params  = new URLSearchParams(window.location.search);

  // 1) Read 'user_id' from the URL
  const userId = params.get('user_id');
  if (!/^\d+$/.test(userId)) {
    itemsEl.innerHTML = '<p>Invalid User ID.</p>';
    return;
  }

  // 2) Fetch items for this user
  let data;
  try {
    const res = await fetch(`/echoliving/backend/logic/fetchUserOrders.php?userId=${userId}`);
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    data = await res.json();
  } catch (err) {
    itemsEl.innerHTML = `<p style="color:red;">Error loading orders: ${err.message}</p>`;
    return;
  }

  const { items, error } = data;
  if (error) {
    itemsEl.innerHTML = `<p style="color:red;">${error}</p>`;
    return;
  }

  // 3) Render the table
  if (items.length === 0) {
    itemsEl.innerHTML = '<p>No order items found.</p>';
  } else {
    const rows = items.map(i => `
      <tr data-item-id="${i.item_id}">
        <td>${i.item_id}</td>
        <td>${i.order_id}</td>
        <td>${i.product_name}</td>
        <td>${i.quantity}</td>
        <td>€${parseFloat(i.total_price).toFixed(2)}</td>
        <td>${i.created_at}</td>
        <td>
          <button class="delete-item-btn"
            style="background:#e74c3c;color:#fff;border:none;padding:0.3rem 0.6rem;border-radius:4px;cursor:pointer;">
            Delete
          </button>
        </td>
      </tr>
    `).join('');

    itemsEl.innerHTML = `
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr>
            <th>ID</th><th>Order #</th><th>Product</th><th>Qty</th>
            <th>Total</th><th>Date</th><th>Action</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>
    `;
  }

  // 4) Hook delete buttons
  itemsEl.addEventListener('click', async e => {
    if (!e.target.matches('.delete-item-btn')) return;
    const row    = e.target.closest('tr');
    const itemId = row.dataset.itemId;
    if (!confirm(`Delete item #${itemId}?`)) return;

    try {
      const form = new FormData();
      form.append('item_id', itemId);
      const res  = await fetch('/echoliving/backend/logic/deleteOrderItem.php', {
        method: 'POST',
        body: form
      });
      const json = await res.json();
      if (json.success) {
        row.remove();
      } else {
        alert('Delete failed: ' + (json.message || 'Unknown error'));
      }
    } catch (err) {
      alert('Error: ' + err.message);
    }
  });
});
