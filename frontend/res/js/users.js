document.addEventListener("DOMContentLoaded", () => {
  // Registration
  const regForm = document.getElementById("register-form");
  if (regForm) {
    regForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      // Convert form to plain JS object
      const formData = new FormData(regForm);
      if (formData.get("password") !== formData.get("password_repeat")) {
        alert("Passwords do not match!");
        return;
      }
      const data = {};
      formData.forEach((value, key) => { data[key] = value; });
      const res = await fetch("/echoliving/backend/logic/registerUser.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });
      const json = await res.json();
      if (json.success) {
        alert("Registration successful! You can now log in.");
        window.location.href = "/echoliving/frontend/res/pages/login.php";
      } else {
        alert("Registration failed: " + json.message);
      }
    });
  }

  // Login
  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(loginForm);
      const data = {};
      formData.forEach((value, key) => { data[key] = value; });
      const res = await fetch("/echoliving/backend/logic/loginUser.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });
      const json = await res.json();
      if (json.success) {
        window.location.href = "/echoliving/frontend/index.php";
      } else {
        alert(json.message);
      }
    });
  }
});
