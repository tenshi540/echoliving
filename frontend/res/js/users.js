document.addEventListener("DOMContentLoaded", () => {
  // Registration
  const regForm = document.getElementById("register-form");
  if (regForm) {
    regForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(regForm);
      // client-side password match check
      if (formData.get("password") !== formData.get("password_repeat")) {
        alert("Passwords do not match!");
        return;
      }
      // send to backend
      const res = await fetch("/echoliving/backend/logic/registerUser.php", {
        method: "POST",
        body: formData
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
      const res = await fetch("/echoliving/backend/logic/loginUser.php", {
        method: "POST",
        body: formData
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
