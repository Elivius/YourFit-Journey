// ===== LOGIN PAGE LOGIC =====
if (
  window.location.pathname.endsWith("login.html") ||
  window.location.pathname === "/" ||
  window.location.pathname.endsWith("index.html")
) {
  document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");

    animateLoginForm(); // Animates the login form UI

    if (loginForm) {
      loginForm.addEventListener("submit", handleLogin);
    }

    setupDemoCredentials(); // Fills in demo credentials when clicked
  });
}

function animateLoginForm() {
  const loginCard = document.querySelector(".login-card");
  const formGroups = document.querySelectorAll(".form-group");

  if (!loginCard) return;

  loginCard.style.opacity = "0";
  loginCard.style.transform = "translateY(30px)";

  setTimeout(() => {
    loginCard.style.transition = "all 0.6s ease-out";
    loginCard.style.opacity = "1";
    loginCard.style.transform = "translateY(0)";
  }, 100);

  formGroups.forEach((group, i) => {
    group.style.opacity = "0";
    group.style.transform = "translateX(-20px)";

    setTimeout(() => {
      group.style.transition = "all 0.4s ease-out";
      group.style.opacity = "1";
      group.style.transform = "translateX(0)";
    }, 300 + i * 100);
  });
}

function setupDemoCredentials() {
  const [usernameValue, passwordValue] = document.querySelectorAll(".credential-item .value");

  if (usernameValue) {
    usernameValue.addEventListener("click", () => {
      document.getElementById("username").value = "admin";
      showNotification("Username filled!", "success");
    });
  }

  if (passwordValue) {
    passwordValue.addEventListener("click", () => {
      document.getElementById("password").value = "admin123";
      showNotification("Password filled!", "success");
    });
  }
}

function handleLogin(e) {
  e.preventDefault();

  const username = document.getElementById("username")?.value;
  const password = document.getElementById("password")?.value;
  const rememberMe = document.getElementById("rememberMe")?.checked;
  const loginBtn = document.querySelector(".login-btn");

  if (!loginBtn) return;

  loginBtn.innerHTML = `<div class="loading-spinner"></div><span>Signing In...</span>`;
  loginBtn.disabled = true;

  setTimeout(() => {
    if (username === "admin" && password === "admin123") {
      localStorage.setItem("adminLoggedIn", "true");
      localStorage.setItem("adminLoginTime", new Date().toISOString());

      if (rememberMe) localStorage.setItem("rememberAdmin", "true");

      showNotification("Login successful! Redirecting...", "success");
      loginBtn.innerHTML = `<i class="fas fa-check"></i><span>Success!</span>`;
      loginBtn.style.background = "var(--gradient-success)";

      setTimeout(() => {
        window.location.href = "dashboard.html";
      }, 1500);
    } else {
      showNotification("Invalid credentials. Please use admin/admin123", "error");

      loginBtn.innerHTML = `<span class="btn-text">Sign In</span><i class="fas fa-arrow-right"></i>`;
      loginBtn.disabled = false;
      loginBtn.style.background = "var(--gradient-primary)";

      const loginCard = document.querySelector(".login-card");
      if (loginCard) {
        loginCard.style.animation = "shake 0.5s ease-in-out";
        setTimeout(() => loginCard.style.animation = "", 500);
      }

      document.getElementById("username").value = "";
      document.getElementById("password").value = "";
      document.getElementById("username").focus();
    }
  }, 1500);
}

function togglePassword() {
  const passwordInput = document.getElementById("password");
  const toggleIcon = document.querySelector(".toggle-password i");
  if (!passwordInput || !toggleIcon) return;

  const isPassword = passwordInput.type === "password";
  passwordInput.type = isPassword ? "text" : "password";
  toggleIcon.className = isPassword ? "fas fa-eye-slash" : "fas fa-eye";
}

function showNotification(message, type = "info") {
  document.querySelectorAll(".notification").forEach((n) => n.remove());

  const notification = document.createElement("div");
  notification.className = `notification ${type}`;
  notification.innerHTML = `
    <div class="notification-icon">
      <i class="fas fa-${type === "success" ? "check-circle" : type === "error" ? "exclamation-circle" : "info-circle"}"></i>
    </div>
    <span class="notification-message">${message}</span>
    <button class="notification-close" onclick="this.parentElement.remove()">
      <i class="fas fa-times"></i>
    </button>
  `;

  notification.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 1rem 1.5rem;
    background: ${type === "success" ? "var(--secondary-color)" : type === "error" ? "var(--danger-color)" : "var(--info-color)"};
    color: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    z-index: 3000;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    min-width: 300px;
    animation: slideInRight 0.4s ease-out;
    font-weight: 500;
  `;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.style.animation = "slideOutRight 0.4s ease-in";
    setTimeout(() => notification.remove(), 400);
  }, 4000);
}

// Append animation styles once
if (!document.getElementById("auth-animation-style")) {
  const style = document.createElement("style");
  style.id = "auth-animation-style";
  style.textContent = `
    @keyframes slideInRight {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
      from { transform: translateX(0); opacity: 1; }
      to { transform: translateX(100%); opacity: 0; }
    }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-10px); }
      75% { transform: translateX(10px); }
    }
    .loading-spinner {
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top: 2px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .notification-close {
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      padding: 0.25rem;
      border-radius: 50%;
      transition: background 0.2s ease;
      margin-left: auto;
    }
    .notification-close:hover {
      background: rgba(255, 255, 255, 0.2);
    }
  `;
  document.head.appendChild(style);
}
