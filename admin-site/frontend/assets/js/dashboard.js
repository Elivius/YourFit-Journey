document.addEventListener("DOMContentLoaded", () => {
  // Dashboard-specific initialization
  initializeDashboard()
  animateCounters()
  setupMenuFunctions();
  setupTopBarActionButtons();
  setupModalHandlers();
  initializeTooltips();
  setupGlobalEventListeners();
})

function initializeDashboard() {
  // Add loading states
  showLoadingStates()

  // Loading delay
  setTimeout(() => {
    hideLoadingStates()
    animateDashboardElements()
  }, 0)
}

function showLoadingStates() {
  document.querySelectorAll(".stat-card, .quick-action-card, .chart-container").forEach((el) => el.classList.add("loading"))
}

function hideLoadingStates() {
  document.querySelectorAll(".loading").forEach((el) => el.classList.remove("loading"))
}

function animateDashboardElements() {
  // Animate welcome section
  const welcomeSection = document.querySelector(".welcome-section")
  if (welcomeSection) {
    welcomeSection.style.opacity = "0"
    welcomeSection.style.transform = "translateY(30px)"

    setTimeout(() => {
      welcomeSection.style.transition = "all 0.8s ease-out"
      welcomeSection.style.opacity = "1"
      welcomeSection.style.transform = "translateY(0)"
    }, 200)
  }

  // Animate stat cards
  document.querySelectorAll(".stat-card").forEach((card, i) => {
    card.style.opacity = "0"
    card.style.transform = "translateY(20px)"

    setTimeout(() => {
      card.style.transition = "all 0.6s ease-out"
      card.style.opacity = "1"
      card.style.transform = "translateY(0)"
    }, 400 + i * 100)
  })

  // Animate quick actions
  document.querySelectorAll(".quick-action-card").forEach((card, i) => {
    card.style.opacity = "0"
    card.style.transform = "translateX(-20px)"

    setTimeout(() => {
      card.style.transition = "all 0.6s ease-out"
      card.style.opacity = "1"
      card.style.transform = "translateX(0)"
    }, 800 + i * 100)
  })

  // Animate charts
  document.querySelectorAll(".chart-container").forEach((container, i) => {
    container.style.opacity = "0"
    container.style.transform = "scale(0.95)"

    setTimeout(() => {
      container.style.transition = "all 0.6s ease-out"
      container.style.opacity = "1"
      container.style.transform = "scale(1)"
    }, 1200 + i * 150)
  })
}

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('show');
}

// Close sidebar when clicking outside on mobile/tablet
document.addEventListener('click', function (e) {
  const sidebar = document.getElementById('sidebar');
  const menuBtn = document.querySelector('.mobile-menu-btn');
  if (
    sidebar.classList.contains('show') &&
    !sidebar.contains(e.target) &&
    !menuBtn.contains(e.target)
  ) {
    sidebar.classList.remove('show');
  }
});

// Animation for mobile performance
function animateCounters() {
  const counters = document.querySelectorAll(".stat-number")

  // Reduce animation complexity on mobile
  const isMobile = window.innerWidth <= 768
  const duration = isMobile ? 1000 : 2000

  counters.forEach((counter) => {
    const target = Number.parseFloat(counter.getAttribute("data-target"))
    const increment = target / (duration / 16)
    let current = 0

    const updateCounter = () => {
      if (current < target) {
        current += increment
        if (current > target) current = target

        counter.textContent = target % 1 !== 0 ? current.toFixed(1) : Math.floor(current).toLocaleString()

        requestAnimationFrame(updateCounter)
      } else {
        counter.textContent = target % 1 !== 0 ? target.toFixed(1) : target.toLocaleString()
      }
    }

    // Start animation after a delay
    setTimeout(updateCounter, isMobile ? 500 : 1000)
  })
}

function updateNavigationBadges() {
  const usersBadge = document.querySelector('a[href="management/user.html"] .nav-badge')
  const workoutsBadge = document.querySelector('a[href="management/workout.html"] .nav-badge')
  const dietBadge = document.querySelector('a[href="management/diet.html"] .nav-badge')
  const feedbackBadge = document.querySelector('a[href="management/feedback.html"] .nav-badge')
  if (usersBadge) usersBadge.textContent = dashboardData.users.length
  if (workoutsBadge) workoutsBadge.textContent = dashboardData.workouts.length
  if (dietBadge) dietBadge.textContent = dashboardData.dietPlans.length
  if (feedbackBadge) feedbackBadge.textContent = "12" // Mock unread feedback count
}

// --- Modal, Tooltip, and Utility Functions ---
function setupModalHandlers() {
  window.onclick = (event) => {
    if (event.target.classList.contains("modal")) {
      closeModal(event.target.id)
    }
  }
}

function initializeTooltips() {
  const tooltipElements = document.querySelectorAll("[data-tooltip]")
  tooltipElements.forEach((element) => {
    element.addEventListener("mouseenter", showTooltip)
    element.addEventListener("mouseleave", hideTooltip)
  })
}

function showTooltip(e) {
  const text = e.target.getAttribute("data-tooltip")
  const tooltip = document.createElement("div")
  tooltip.className = "tooltip"
  tooltip.textContent = text
  tooltip.style.cssText = `
        position: absolute;
        background: var(--gray-800);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: var(--radius-md);
        font-size: var(--font-size-sm);
        z-index: 9999;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
        white-space: nowrap;
    `
  document.body.appendChild(tooltip)
  const rect = e.target.getBoundingClientRect()
  tooltip.style.left = rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + "px"
  tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + "px"
  setTimeout(() => { tooltip.style.opacity = "1" }, 10)
  e.target._tooltip = tooltip
}

function hideTooltip(e) {
  if (e.target._tooltip) {
    e.target._tooltip.remove()
    delete e.target._tooltip
  }
}

function openModal(modalId) {
  const modal = document.getElementById(modalId)
  if (!modal) return
  modal.style.display = "flex"
  document.body.style.overflow = "hidden"
  const modalContent = modal.querySelector(".modal-content")
  if (modalContent) {
    modalContent.style.transform = "scale(0.9)"
    modalContent.style.opacity = "0"
    if (window.innerWidth <= 768) {
      modalContent.style.margin = "var(--spacing-sm)"
      modalContent.style.width = "calc(100% - 2rem)"
      modalContent.style.maxWidth = "none"
      modalContent.style.maxHeight = "calc(100vh - 2rem)"
    }
    setTimeout(() => {
      modalContent.style.transition = "all 0.3s ease-out"
      modalContent.style.transform = "scale(1)"
      modalContent.style.opacity = "1"
    }, 10)
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId)
  if (modal) {
    const modalContent = modal.querySelector(".modal-content")
    if (modalContent) {
      modalContent.style.transform = "scale(0.9)"
      modalContent.style.opacity = "0"
      setTimeout(() => {
        modal.style.display = "none"
        document.body.style.overflow = "auto"
        modal.removeAttribute("data-edit-id")
        const form = modal.querySelector("form")
        if (form) form.reset()
      }, 300)
    } else {
      modal.style.display = "none"
      document.body.style.overflow = "auto"
    }
  }
}

function closeAllModals() {
  const modals = document.querySelectorAll(".modal")
  modals.forEach((modal) => {
    if (modal.style.display === "block") {
      closeModal(modal.id)
    }
  })
}

function closeAllPanels() {
  const panels = document.querySelectorAll(".notifications-panel, .quick-actions-panel")
  panels.forEach((panel) => {
    panel.classList.remove("show")
  })
}

// --- Global Event Listeners ---
function setupGlobalEventListeners() {
  document.addEventListener("click", (e) => {
    // Close user menu
    const userMenu = document.getElementById("userMenu")
    const userProfile = document.querySelector(".user-profile")
    if (userMenu && !userProfile?.contains(e.target)) {
      userMenu.classList.remove("show")
      const arrow = document.querySelector(".user-menu-btn i")
      if (arrow) arrow.style.transform = "rotate(0deg)"
    }
    // Close stat menus
    const statMenus = document.querySelectorAll(".stat-menu-dropdown")
    statMenus.forEach((menu) => {
      const dd = menu
      const dropdown = button?.nextElementSibling
      if (dd !== dropdown) {
        dd.classList.remove("show")
      }
    })
    const quickActionsPanel = document.getElementById("quickActionsPanel")
    const quickActionsBtn = document.querySelector('[onclick="toggleQuickActions()"]')
    if (quickActionsPanel && !quickActionsPanel.contains(e.target) && !quickActionsBtn?.contains(e.target)) {
      quickActionsPanel.classList.remove("show")
    }
    // Close search results
    const searchResults = document.getElementById("searchResults")
    const searchContainer = document.querySelector(".search-container")
    if (searchResults && !searchContainer?.contains(e.target)) {
      searchResults.remove()
    }
  })
  document.addEventListener("keydown", (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === "k") {
      e.preventDefault()
      const searchInput = document.querySelector(".global-search")
      if (searchInput && window.innerWidth > 768) {
        searchInput.focus()
      }
    }
    if (e.key === "Escape") {
      closeAllModals()
      closeAllPanels()
      hideSearchResults()
    }
  })
  let resizeTimeout
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout)
    resizeTimeout = setTimeout(handleResize, 250)
  })
  window.addEventListener("orientationchange", () => {
    setTimeout(handleResize, 500)
  })
  setupTouchEvents()
  let lastTouchEnd = 0
  document.addEventListener(
    "touchend",
    (event) => {
      const now = new Date().getTime()
      if (now - lastTouchEnd <= 300) {
        event.preventDefault()
      }
      lastTouchEnd = now
    },
    false,
  )
}

// --- Enhanced CSS for new components (from common.js) ---
const enhancedStyles = document.createElement("style")
enhancedStyles.textContent = `
    .confirm-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }
    .confirm-content {
        background: white;
        border-radius: var(--radius-xl);
        padding: var(--spacing-xl);
        max-width: 400px;
        width: 90%;
        box-shadow: var(--shadow-xl);
        position: relative;
        z-index: 1;
        animation: scaleIn 0.3s ease-out;
    }
    .confirm-header h3 {
        font-size: var(--font-size-xl);
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: var(--spacing-lg);
    }
    .confirm-body p {
        color: var(--gray-600);
        margin-bottom: var(--spacing-xl);
        line-height: 1.6;
    }
    .confirm-actions {
        display: flex;
        gap: var(--spacing-md);
        justify-content: flex-end;
    }
    .toast-notification {
        border: 1px solid var(--gray-200);
    }
    .toast-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .toast-notification.success .toast-icon {
        background: rgba(16, 185, 129, 0.1);
        color: var(--secondary-color);
    }
    .toast-notification.error .toast-icon {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }
    .toast-notification.warning .toast-icon {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }
    .toast-notification.info .toast-icon {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info-color);
    }
    .toast-content {
        flex: 1;
    }
    .toast-message {
        color: var(--gray-700);
        font-weight: 500;
    }
    .toast-close {
        background: none;
        border: none;
        color: var(--gray-400);
        cursor: pointer;
        padding: var(--spacing-xs);
        border-radius: var(--radius-sm);
        transition: all var(--transition-fast);
        flex-shrink: 0;
    }
    .toast-close:hover {
        background: var(--gray-100);
        color: var(--gray-600);
    }
    .animate-in {
        animation: slideUp 0.6s ease-out;
    }
    @keyframes slideInRight {
        from { 
            transform: translateX(100%); 
            opacity: 0; 
        }
        to { 
            transform: translateX(0); 
            opacity: 1; 
        }
    }
    @keyframes slideOutRight {
        from { 
            transform: translateX(0); 
            opacity: 1; 
        }
        to { 
            transform: translateX(100%); 
            opacity: 0; 
        }
    }
`
document.head.appendChild(enhancedStyles)

// Cleanup on page unload
window.addEventListener("beforeunload", () => {
  if (updateInterval) clearInterval(updateInterval)
})

// --- Stat menu (three-dot) functions (keep all) ---
function toggleStatMenu(button) {
  const dropdown = button.nextElementSibling
  const allDropdowns = document.querySelectorAll(".stat-menu-dropdown")
  allDropdowns.forEach((dd) => {
    if (dd !== dropdown) dd.classList.remove("show")
  })
  dropdown.classList.toggle("show")
}
