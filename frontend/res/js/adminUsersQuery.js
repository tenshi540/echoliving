// /echoliving/frontend/res/js/adminUsersQuery.js
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('users-container');
  const ENDPOINT = '/echoliving/backend/logic/fetchAdminUsersData.php';
  const TOGGLE   = '/echoliving/backend/logic/toggleUser.php';

  async function loadUsers() {
    try {
      const res  = await fetch(ENDPOINT, { credentials: 'include' });
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      if (data.error) throw new Error(data.error);

      const users = data.users || [];
      if (!users.length) {
        container.innerHTML = '<p>No users found.</p>';
        return;
      }

      // build table rows, correctly interpreting is_active
      const rows = users.map(u => {
        const active = Number(u.active) === 1;
        return `
          <tr data-id="${u.id}">
            <td>${u.id}</td>
            <td>${u.salutation} ${u.first_name} ${u.last_name}</td>
            <td>${u.email}</td>
            <td>${u.username}</td>
            <td>${active ? 'Active' : 'Inactive'}</td>
            <td>
              <button class="toggle-btn">
                ${active ? 'Deactivate' : 'Activate'}
              </button>
            </td>
          </tr>
        `;
      }).join('');

      container.innerHTML = `
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th>ID</th><th>Name</th><th>Email</th>
              <th>Username</th><th>Status</th><th>Action</th>
            </tr>
          </thead>
          <tbody>${rows}</tbody>
        </table>
      `;
    } catch (err) {
      console.error('loadUsers error:', err);
      container.innerHTML = `<p style="color:red;">Error: ${err.message}</p>`;
    }
  }

  container.addEventListener('click', async e => {
    if (!e.target.matches('.toggle-btn')) return;
    const row    = e.target.closest('tr');
    const id     = row.dataset.id;
    const text   = e.target.textContent.toLowerCase();
    if (!confirm(`${text} user #${id}?`)) return;

    try {
      const fd  = new FormData();
      fd.append('id', id);
      const res = await fetch(TOGGLE, {
        method: 'POST',
        credentials: 'include',
        body: fd
      });
      const json = await res.json();
      if (!json.success) throw new Error(json.message || 'Unknown error');
      await loadUsers();
    } catch (err) {
      alert('Error toggling user: ' + err.message);
    }
  });

  loadUsers();
});
