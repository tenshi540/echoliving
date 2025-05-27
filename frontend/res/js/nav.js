// nav.js
document.addEventListener('DOMContentLoaded', async () => {
  const container = document.getElementById('nav-right');
  const ENDPOINT  = '/echoliving/backend/logic/fetchNavData.php';

  // 1) Always show cart
  let html = `
    <a href="/echoliving/frontend/res/pages/cart.php" class="cart-icon">
      🛒 <span id="cart-count">0</span>
    </a>
  `;

  try {
    const res = await fetch(ENDPOINT, { credentials: 'include' });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const data = await res.json();

    if (data.logged_in) {
      // 2a) Logged-in
      html += `
        <a href="/echoliving/frontend/res/pages/account.php" class="nav-username">
          Hej, ${data.username}
        </a>
      `;
      if (data.is_admin) {
        html += `
          <a href="/echoliving/frontend/res/pages/admin.php" class="nav-link">
            Admin
          </a>
        `;
      }
      html += `
        <a href="/echoliving/frontend/res/pages/logout.php" class="logout-link">
          Logout
        </a>
      `;
    } else {
      // 2b) Guest
      html += `
        <a href="/echoliving/frontend/res/pages/login.php" class="nav-link">
          Account
        </a>
      `;
    }
  } catch (err) {
    console.error('nav.js error:', err);
    // fallback to guest view
    html += `
      <a href="/echoliving/frontend/res/pages/login.php" class="nav-link">
        Account
      </a>
    `;
  }

  container.innerHTML = html;

  // 3) Kick off cart count update if you have that function
  if (typeof updateCartCount === 'function') {
    updateCartCount();
  }
});
