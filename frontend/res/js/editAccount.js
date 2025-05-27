// frontend/js/editAccount.js
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('toggle-edit');
  const form   = document.getElementById('edit-form');
  const feedback = document.getElementById('edit-feedback');

  toggle.addEventListener('click', () => {
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
  });

  form.addEventListener('submit', async e => {
    e.preventDefault();
    feedback.textContent = '';

    const data = Object.fromEntries(new FormData(form).entries());

    try {
      const resp = await fetch('/echoliving/backend/logic/updateUser.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify(data)
      });
      const result = await resp.json();

      if (result.success) {
        feedback.style.color = 'green';
        feedback.textContent = 'Your data has been updated.';
      } else {
        feedback.style.color = 'red';
        feedback.textContent = result.message || 'Update failed.';
      }
    } catch (err) {
      feedback.style.color = 'red';
      feedback.textContent = 'Error: ' + err.message;
    }
  });
});
