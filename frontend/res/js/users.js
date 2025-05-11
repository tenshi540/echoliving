document.addEventListener("DOMContentLoaded", () => {
  // ——————————————
  // Registration
  // ——————————————
  const regForm = document.getElementById("register-form");
  if (regForm) {
    regForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const formData = new FormData(regForm);
      const pw = formData.get("password");
      const pw2 = formData.get("password_repeat");
      if (pw !== pw2) {
        alert("Passwords do not match!");
        return;
      }

      const res = await fetch("/echoliving/backend/logic/registerUser.php", {
        method: "POST",
        body: formData
      });
      const j = await res.json();

      if (j.success) {
        alert("Registration successful! You can now log in.");
        window.location.href = "/echoliving/frontend/res/pages/login.php";
      } else {
        alert("Registration failed: " + j.message);
      }
    });
  }

  // ——————————————
  // Login
  // ——————————————
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const formData = new FormData(loginForm);
      const res = await fetch("/echoliving/backend/logic/loginUser.php", {
        method: "POST",
        body: formData
      });
      const j = await res.json();

      if (j.success) {
        // redirect to home or products page
        window.location.href = "/echoliving/frontend/index.php";
      } else {
        alert(j.message);
      }
    });
  }
});
