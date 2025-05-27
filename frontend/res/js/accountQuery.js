// accountQuery.js
document.addEventListener('DOMContentLoaded', async () => {
  const outOrders = document.getElementById('orders-container');
  const outEdit   = document.getElementById('edit-container');

  // 1) Fetch profile + orders
  const res = await fetch('/echoliving/backend/logic/fetchAccountData.php');
  if (res.status === 401) {
    outOrders.textContent = 'Not authenticated';
    return;
  }
  const { user, orders } = await res.json();

  // 2) Render orders
  if (orders.length === 0) {
    outOrders.innerHTML = '<p>You haven’t placed any orders yet.</p>';
  } else {
    const rows = orders.map(o => `
      <tr>
        <td>${o.id}</td>
        <td>${o.created_at}</td>
        <td>€${parseFloat(o.total_price).toFixed(2)}</td>
        <td>
          <a href="/echoliving/frontend/res/pages/orderDetails.php?orderId=${encodeURIComponent(o.id)}">
            View Order
          </a>
        </td>
      </tr>
    `).join('');
    outOrders.innerHTML = `
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Date</th>
            <th>Total (€)</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>
    `;
  }

  // 3) Render edit form
  outEdit.innerHTML = `
    <div class="login-box">
      <h2 class="login-title">Edit Your Data</h2>
      <form id="edit-form" class="login-form">
        ${['salutation','first_name','last_name','address','postal_code','city','email','username']
          .map(field => {
            let label = field.replace('_',' ').replace(/\b\w/g, c=>c.toUpperCase());
            let val   = user[field] || '';
            if (field === 'salutation') {
              return `
                <div class="form-group">
                  <label>${label}</label>
                  <select name="${field}" required>
                    ${['Mr.','Ms.','Mx.'].map(opt => `
                      <option value="${opt}" ${val===opt?'selected':''}>${opt}</option>
                    `).join('')}
                  </select>
                </div>`;
            }
            let type = field==='email' ? 'email' : 'text';
            return `
              <div class="form-group">
                <label>${label}</label>
                <input type="${type}" name="${field}" value="${val}" required>
              </div>`;
          }).join('')}
        <div class="form-group">
          <label>Confirm with Password</label>
          <input type="password" name="confirm_password" placeholder="Your current password" required>
        </div>
        <button type="submit" class="btn-primary">Save Changes</button>
        <p id="edit-feedback" class="login-footer" style="margin-top:1rem;"></p>
      </form>
    </div>
  `;

  // 4) Hook form submission
  document.getElementById('edit-form').addEventListener('submit', async e => {
    e.preventDefault();
    const feedback = document.getElementById('edit-feedback');
    const data = Object.fromEntries(new FormData(e.target).entries());
    try {
      const upd = await fetch('/echoliving/backend/logic/updateUser.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify(data)
      });
      const r = await upd.json();
      if (r.success) {
        feedback.style.color = 'green';
        feedback.textContent = 'Your data has been updated.';
      } else {
        feedback.style.color = 'red';
        feedback.textContent = r.message || 'Update failed.';
      }
    } catch (err) {
      feedback.style.color = 'red';
      feedback.textContent = 'Error: ' + err.message;
    }
  });
});
