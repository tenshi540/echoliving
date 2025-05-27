// /echoliving/frontend/res/js/adminProductsQuery.js
document.addEventListener('DOMContentLoaded', () => {
  const prodEl   = document.getElementById('products-container');
  const createEl = document.getElementById('create-container');

  // 1) Load & render products
  async function loadProducts() {
    try {
      const res = await fetch('/echoliving/backend/logic/fetchAdminProductsData.php');
      if (!res.ok) throw new Error(res.statusText);
      const { products } = await res.json();

      if (!products.length) {
        prodEl.innerHTML = '<p>No products found.</p>';
        return;
      }

      const rows = products.map(p => `
        <tr data-id="${p.id}">
          <td>${p.id}</td>
          <td>${p.name}</td>
          <td>${p.description}</td>
          <td>${p.rating}</td>
          <td>€${parseFloat(p.price).toFixed(2)}</td>
          <td>${p.image_filename ? `<img src="/echoliving/frontend/res/img/${p.image_filename}" alt="${p.name}" style="max-width:50px;"/>` : ''}</td>
          <td>${p.category}</td>
          <td>${p.created_at}</td>
          <td>
            <button class="delete-btn" style="background:#e74c3c;color:#fff;border:none;padding:0.3rem 0.6rem;border-radius:4px;cursor:pointer;">
              Delete
            </button>
          </td>
        </tr>
      `).join('');

      prodEl.innerHTML = `
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th>ID</th><th>Name</th><th>Description</th>
              <th>Rating</th><th>Price</th><th>Image</th>
              <th>Category</th><th>Created At</th><th>Action</th>
            </tr>
          </thead>
          <tbody>${rows}</tbody>
        </table>
      `;
    } catch (err) {
      prodEl.innerHTML = `<p style="color:red;">Error loading products: ${err.message}</p>`;
    }
  }

  // 2) Hook up delete using JSON
  prodEl.addEventListener('click', async e => {
    if (!e.target.matches('.delete-btn')) return;
    const row = e.target.closest('tr');
    const id  = row.dataset.id;
    if (!confirm(`Are you sure you want to delete product #${id}?`)) return;

    try {
      const res = await fetch('/echoliving/backend/logic/deleteProduct.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      });
      const json = await res.json();

      if (json.success) {
        await loadProducts();
      } else {
        alert('Delete failed: ' + (json.message || 'Unknown error'));
      }
    } catch (err) {
      alert('Error: ' + err.message);
    }
  });

  // 3) Render the existing create-product form (no image upload)
  function renderCreateForm() {
    createEl.innerHTML = `
      <form id="create-form" style="display:grid; gap:1rem; max-width:500px;">
        <input type="text" name="name" placeholder="Name" required style="padding:0.5rem;">
        <textarea name="description" placeholder="Description" rows="3" required style="padding:0.5rem;"></textarea>
        <div style="display:flex; gap:1rem;">
          <input type="number" step="0.01" name="price" placeholder="Price (€)" required style="flex:1; padding:0.5rem;">
          <input type="number" step="0.1" min="0" max="5" name="rating" placeholder="Rating" required style="flex:1; padding:0.5rem;">
        </div>
        <input type="text" name="category" placeholder="Category" required style="padding:0.5rem;">
        <button type="submit" class="btn-primary">Create Product</button>
        <p id="create-feedback" style="margin-top:0.5rem;"></p>
      </form>
    `;

    document.getElementById('create-form').addEventListener('submit', async e => {
      e.preventDefault();
      const feedback = document.getElementById('create-feedback');
      const formData = new FormData(e.target);

      // Convert form data to plain JS object
      const data = {};
      for (const [key, value] of formData.entries()) {
        data[key] = value;
      }

      try {
        const res = await fetch('/echoliving/backend/logic/createProduct.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data)
        });
        if (!res.ok) throw new Error(res.statusText);

        const result = await res.json();
        if (result.success) {
          feedback.style.color = 'green';
          feedback.textContent = 'Product created.';
          e.target.reset();
          await loadProducts();
        } else {
          feedback.style.color = 'red';
          feedback.textContent = 'Error: ' + (result.message || 'Unknown error');
        }
      } catch (err) {
        feedback.style.color = 'red';
        feedback.textContent = `Error: ${err.message}`;
      }
    });
  }

  // 4) Kick things off
  loadProducts();
  renderCreateForm();
});
