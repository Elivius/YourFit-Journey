// Enhanced Dashboard functionality with animations and interactivity
const dashboardData = {
  users: [],
  workouts: [],
  dietPlans: [],
  activities: [],
  stats: {},
}
const charts = {}
let updateInterval

document.addEventListener("DOMContentLoaded", () => {
  // Dashboard-specific initialization
  initializeDashboard()
  loadDashboardData()
  initializeCharts()
  setupEventListeners()
  startRealTimeUpdates()
  animateCounters()
  initializeChartResizeObserver()

  setActiveNavigation();
  setupMenuFunctions();
  setupTopBarActionButtons();
  setupModalHandlers();
  initializeTooltips();
  setupGlobalEventListeners();
})

function initializeDashboard() {
  // Add loading states
  showLoadingStates()

  // Simulate loading delay
  setTimeout(() => {
    hideLoadingStates()
    animateDashboardElements()
  }, 1500)
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

// Optional: Close sidebar when clicking outside on mobile/tablet
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

// Fix animation for mobile performance
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

function setupEventListeners() {
  // Time selector buttons
  document.querySelectorAll(".time-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      document.querySelectorAll(".time-btn").forEach((b) => b.classList.remove("active"))
      this.classList.add("active")
      updateChartsForPeriod(this.getAttribute("data-period"))
    })
  })

  // Activity filter buttons
  document.querySelectorAll(".filter-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      document.querySelectorAll(".filter-btn").forEach((b) => b.classList.remove("active"))
      this.classList.add("active")
      filterActivities(this.getAttribute("data-filter"))
    })
  })

  // Refresh buttons
  document.addEventListener("click", (e) => {
    const el = e.target.closest('[onclick*="refreshStat"]')
    if (el) {
      const statType = el.getAttribute("onclick").match(/refreshStat\('(.+?)'\)/)[1]
      refreshStatCard(statType)
    }
  })
}

function updateDashboardStats() {
  const stats = {
    totalUsers: dashboardData.users.length,
    totalWorkouts: dashboardData.workouts.reduce((sum, w) => sum + (w.participants || 0), 0),
    activeDietPlans: dashboardData.dietPlans.filter((d) => d.subscribers > 0).length,
    averageRating: calculateAverageRating(),
  }

  // Update stat numbers with animation
  updateStatNumber("totalUsers", stats.totalUsers)
  updateStatNumber("totalWorkouts", stats.totalWorkouts)
  updateStatNumber("activeDietPlans", stats.activeDietPlans)
  updateStatNumber("averageRating", stats.averageRating)

  // Update navigation badges
  updateNavigationBadges()
}

function updateStatNumber(elementId, newValue) {
  const element = document.querySelector(`[data-target="${newValue}"]`) || document.getElementById(elementId)
  if (element) {
    const currentValue = Number.parseFloat(element.textContent.replace(/,/g, "")) || 0
    animateNumberChange(element, currentValue, newValue)
  }
}

function animateNumberChange(element, from, to) {
  const duration = 1000
  const increment = (to - from) / (duration / 16)
  let current = from

  const updateNumber = () => {
    if (Math.abs(current - to) > Math.abs(increment)) {
      current += increment
      element.textContent = Math.floor(current).toLocaleString()
      requestAnimationFrame(updateNumber)
    } else {
      element.textContent = to.toLocaleString()
    }
  }

  updateNumber()
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

function calculateAverageRating() {
  const allRatings = [
    ...dashboardData.workouts.map((w) => w.rating || 0),
    ...dashboardData.dietPlans.map((d) => d.rating || 0),
  ].filter((r) => r > 0)

  if (!allRatings.length) return 0

  return Math.round((allRatings.reduce((sum, r) => sum + r, 0) / allRatings.length) * 10) / 10 // Round to 1 decimal place
}

function initializeCharts() {
  // Activity Chart
  const activityCanvas = document.getElementById("activityChart")
  if (activityCanvas) charts.activity = drawActivityChart(activityCanvas)

  // Category Chart
  const categoryCanvas = document.getElementById("categoryChart")
  if (categoryCanvas) charts.category = drawCategoryChart(categoryCanvas)

  // Mini charts in stat cards
  initializeMiniCharts()
}

function initializeMiniCharts() {
  [
    { id: "usersChart", color: "#6366f1" },
    { id: "workoutsChart", color: "#10b981" },
    { id: "dietsChart", color: "#f59e0b" },
    { id: "ratingChart", color: "#3b82f6" },
  ].forEach((chart) => {
    const canvas = document.getElementById(chart.id)
    if (canvas) drawMiniChart(canvas, generateMiniChartData(), chart.color)
  })
}

function generateMiniChartData() {
  return Array.from({ length: 7 }, () => Math.floor(Math.random() * 100) + 20)
}

// Fix mini chart drawing
function drawMiniChart(canvas, data, color) {
  const ctx = canvas.getContext("2d")

  // Get actual canvas size
  const rect = canvas.getBoundingClientRect()
  const dpr = window.devicePixelRatio || 1

  // Set canvas size for high DPI displays
  canvas.width = rect.width * dpr
  canvas.height = rect.height * dpr

  // Scale context for high DPI
  ctx.scale(dpr, dpr)

  const width = rect.width, height = rect.height

  ctx.clearRect(0, 0, width, height)
  if (!data.length) return
  const maxValue = Math.max(...data)
  const stepX = width / (data.length - 1)

  // Draw line
  ctx.beginPath()
  ctx.strokeStyle = color
  ctx.lineWidth = Math.max(1, width / 50)

  data.forEach((value, i) => {
    const x = i * stepX
    const y = height - (value / maxValue) * height

    i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y)
  })
  ctx.stroke()

  // Draw area under curve
  ctx.lineTo(width, height)
  ctx.lineTo(0, height)
  ctx.closePath()

  const gradient = ctx.createLinearGradient(0, 0, 0, height)
  gradient.addColorStop(0, color + "40")
  gradient.addColorStop(1, color + "10")

  ctx.fillStyle = gradient
  ctx.fill()
}

// Fix chart drawing for responsive design
function drawActivityChart(canvas) {
  const ctx = canvas.getContext("2d")

  // Get actual canvas size
  const rect = canvas.getBoundingClientRect()
  const dpr = window.devicePixelRatio || 1

  // Set canvas size for high DPI displays
  canvas.width = rect.width * dpr
  canvas.height = rect.height * dpr

  // Scale context for high DPI
  ctx.scale(dpr, dpr)

  const width = rect.width, height = rect.height

  ctx.clearRect(0, 0, width, height)

  // Sample data for user activity
  const data = [
    { day: "Mon", users: 850, sessions: 1200 },
    { day: "Tue", users: 920, sessions: 1350 },
    { day: "Wed", users: 780, sessions: 1100 },
    { day: "Thu", users: 1050, sessions: 1500 },
    { day: "Fri", users: 1200, sessions: 1700 },
    { day: "Sat", users: 950, sessions: 1300 },
    { day: "Sun", users: 800, sessions: 1000 },
  ]

  const maxValue = Math.max(...data.map((d) => Math.max(d.users, d.sessions)))
  const chartHeight = height - 80, chartWidth = width - 100, stepX = chartWidth / (data.length - 1)

  // Responsive font size
  const fontSize = Math.max(10, Math.min(14, width / 50))
  ctx.font = `${fontSize}px Inter`

  // Draw grid lines
  ctx.strokeStyle = "#f3f4f6"
  ctx.lineWidth = 1
  for (let i = 0; i <= 5; i++) {
    const y = 40 + (chartHeight / 5) * i
    ctx.beginPath()
    ctx.moveTo(50, y)
    ctx.lineTo(width - 50, y)
    ctx.stroke()
  }

  // Draw users line
  ctx.beginPath()
  ctx.strokeStyle = "#6366f1"
  ctx.lineWidth = Math.max(2, width / 400)
  data.forEach((point, i) => {
    const x = 50 + i * stepX
    const y = 40 + chartHeight - (point.users / maxValue) * chartHeight

    i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y)

    // Draw point
    ctx.fillStyle = "#6366f1"
    ctx.beginPath()
    ctx.arc(x, y, Math.max(3, width / 200), 0, 2 * Math.PI)
    ctx.fill()
  })
  ctx.stroke()

  // Draw sessions line
  ctx.beginPath()
  ctx.strokeStyle = "#f093fb"
  ctx.lineWidth = Math.max(2, width / 400)
  data.forEach((point, i) => {
    const x = 50 + i * stepX
    const y = 40 + chartHeight - (point.sessions / maxValue) * chartHeight

    i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y)

    // Draw point
    ctx.fillStyle = "#f093fb"
    ctx.beginPath()
    ctx.arc(x, y, Math.max(3, width / 200), 0, 2 * Math.PI)
    ctx.fill()
  })
  ctx.stroke()

  // Draw labels
  ctx.fillStyle = "#6b7280"
  ctx.textAlign = "center"
  data.forEach((point, i) => {
    const x = 50 + i * stepX
    ctx.fillText(point.day, x, height - 10)
  })

  // Draw Y-axis labels
  ctx.textAlign = "right"
  for (let i = 0; i <= 5; i++) {
    const value = Math.round((maxValue / 5) * (5 - i))
    const y = 40 + (chartHeight / 5) * i
    ctx.fillText(value.toLocaleString(), 45, y + 4)
  }

  return { data, maxValue }
}

// Fix category chart for mobile
function drawCategoryChart(canvas) {
  const ctx = canvas.getContext("2d")

  // Get actual canvas size
  const rect = canvas.getBoundingClientRect()
  const dpr = window.devicePixelRatio || 1

  // Set canvas size for high DPI displays
  canvas.width = rect.width * dpr
  canvas.height = rect.height * dpr

  // Scale context for high DPI
  ctx.scale(dpr, dpr)

  const width = rect.width, height = rect.height
  const centerX = width / 2, centerY = height / 2
  const radius = Math.min(centerX, centerY) - 60

  ctx.clearRect(0, 0, width, height)

  const data = [
    { label: "Strength", value: 35, color: "#6366f1" },
    { label: "Cardio", value: 28, color: "#10b981" },
    { label: "HIIT", value: 22, color: "#f59e0b" },
    { label: "Flexibility", value: 15, color: "#ef4444" },
  ]

  let currentAngle = -Math.PI / 2

  // Responsive font size
  const fontSize = Math.max(8, Math.min(12, width / 40))
  const labelFontSize = Math.max(6, Math.min(10, width / 50))

  data.forEach((segment) => {
    const sliceAngle = (segment.value / 100) * 2 * Math.PI

    // Draw slice
    ctx.beginPath()
    ctx.moveTo(centerX, centerY)
    ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle)
    ctx.closePath()
    ctx.fillStyle = segment.color
    ctx.fill()

    // Draw border
    ctx.strokeStyle = "#ffffff"
    ctx.lineWidth = Math.max(2, width / 200)
    ctx.stroke()

    // Draw label only if there's enough space
    if (radius > 50) {
      const labelAngle = currentAngle + sliceAngle / 2
      const labelX = centerX + Math.cos(labelAngle) * (radius * 0.7)
      const labelY = centerY + Math.sin(labelAngle) * (radius * 0.7)

      ctx.fillStyle = "#ffffff"
      ctx.font = `bold ${fontSize}px Inter`
      ctx.textAlign = "center"
      ctx.fillText(`${segment.value}%`, labelX, labelY)

      if (width > 300) {
        ctx.font = `${labelFontSize}px Inter`
        ctx.fillText(segment.label, labelX, labelY + 15)
      }
    }

    currentAngle += sliceAngle
  })

  // Draw legend only if there's enough space
  if (width > 250) {
    data.forEach((segment, i) => {
      const legendY = 20 + i * 25
      ctx.fillStyle = segment.color
      ctx.fillRect(20, legendY, 15, 15)
      ctx.fillStyle = "#374151"
      ctx.font = `${fontSize}px Inter`
      ctx.textAlign = "left"
      ctx.fillText(`${segment.label} (${segment.value}%)`, 40, legendY + 12)
    })
  }

  return { data }
}

function updateChartsForPeriod(period) {
  showNotification(`Updating charts for ${period} period...`, "info", 2000)

  // Simulate data loading
  setTimeout(() => {
    // Redraw charts with new data
    if (charts.activity) {
      const canvas = document.getElementById("activityChart")
      if (canvas) drawActivityChart(canvas)
    }

    showNotification("Charts updated successfully!", "success")
  }, 1000)
}

function filterActivities(filter) {
  document.querySelectorAll(".activity-item").forEach((item) => {
    const show = filter === "all" || item.classList.contains(`activity-${filter}`)
    item.style.display = show ? "flex" : "none"
    if (show) item.style.animation = "slideUp 0.3s ease-out"
  })
}

function refreshStatCard(statType) {
  const statCard = document.querySelector(`[onclick*="${statType}"]`).closest(".stat-card")
  statCard.classList.add("loading")
  setTimeout(() => {
    statCard.classList.remove("loading")
    const statNumber = statCard.querySelector(".stat-number")
    const currentValue = Number.parseInt(statNumber.textContent.replace(/,/g, ""))
    const newValue = currentValue + Math.floor(Math.random() * 50) - 25
    animateNumberChange(statNumber, currentValue, Math.max(0, newValue))
    showNotification(`${statType} statistics refreshed!`, "success")
  }, 1500)
}

function startRealTimeUpdates() {
  // Update stats every 30 seconds
  updateInterval = setInterval(() => {
    updateDashboardStats()
    updateMiniCharts()
  }, 30000)

  // Update activity timeline every 2 minutes
  setInterval(updateActivityTimeline, 120000)
}

function updateMiniCharts() {
  ["usersChart", "workoutsChart", "dietsChart", "ratingChart"].forEach((chartId, i) => {
    const canvas = document.getElementById(chartId)
    if (canvas) drawMiniChart(canvas, generateMiniChartData(), ["#6366f1", "#10b981", "#f59e0b", "#3b82f6"][i])
  })
}

// Fix load more activity for mobile
function loadMoreActivity() {
  const timeline = document.querySelector(".activity-timeline")
  const loadBtn = document.querySelector(".activity-footer .btn")
  if (!timeline || !loadBtn) return
  loadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...'
  loadBtn.disabled = true
  setTimeout(() => {
    [
      {
        type: "users",
        iconType: "success",
        icon: "fas fa-user-check",
        title: "Profile completed",
        description: "Alex Thompson completed their fitness assessment",
        time: "4 hours ago",
        actions: [{ label: "View Assessment", onclick: 'viewAssessment("alex-thompson")' }],
      },
      {
        type: "workouts",
        iconType: "primary",
        icon: "fas fa-trophy",
        title: "Milestone achieved",
        description: "Lisa Park completed 50 workouts this month",
        time: "5 hours ago",
        actions: [{ label: "Send Badge", onclick: 'sendAchievementBadge("lisa-park")' }],
      },
    ].forEach((activity, i) => {
      const activityElement = document.createElement("div")
      activityElement.className = `activity-item activity-${activity.type}`

      // Mobile-friendly layout
      const isMobile = window.innerWidth <= 768
      activityElement.innerHTML = `
        <div class="activity-icon ${activity.iconType}">
          <i class="${activity.icon}"></i>
        </div>
        <div class="activity-content">
          <div class="activity-header">
            <h4>${activity.title}</h4>
            <span class="activity-time">${activity.time}</span>
          </div>
          <p>${activity.description}</p>
          <div class="activity-actions">
            ${activity.actions.map((action) => `<button class="btn-link" onclick="${action.onclick}">${action.label}</button>`).join("")}
          </div>
        </div>
      `

      activityElement.style.opacity = "0"
      activityElement.style.transform = "translateY(20px)"
      timeline.appendChild(activityElement)

      setTimeout(() => {
        activityElement.style.transition = "all 0.4s ease-out"
        activityElement.style.opacity = "1"
        activityElement.style.transform = "translateY(0)"
      }, 100 + i * 100)
    })
    loadBtn.innerHTML = '<i class="fas fa-plus"></i> Load More Activity'
    loadBtn.disabled = false
    showNotification("More activities loaded!", "success")
  }, 1500)
}

// Add function to redraw charts on resize
function redrawChart(chartId) {
  const canvas = document.getElementById(chartId)
  if (!canvas) return

  switch (chartId) {
    case "activityChart":
      drawActivityChart(canvas)
      break
    case "categoryChart":
      drawCategoryChart(canvas)
      break
    case "usersChart":
    case "workoutsChart":
    case "dietsChart":
    case "ratingChart":
      drawMiniChart(canvas, generateMiniChartData(), {
        usersChart: "#6366f1",
        workoutsChart: "#10b981",
        dietsChart: "#f59e0b",
        ratingChart: "#3b82f6",
      }[chartId])
      break
  }
}

// Add resize observer for charts
function initializeChartResizeObserver() {
  if (typeof ResizeObserver !== "undefined") {
    const chartObserver = new ResizeObserver((entries) => {
      entries.forEach((entry) => {
        const canvas = entry.target.querySelector("canvas")
        if (canvas) setTimeout(() => redrawChart(canvas.id), 100)
      })
    })

    // Observe chart containers
    document.querySelectorAll(".chart-container").forEach((container) => chartObserver.observe(container))
  }
}

// --- Begin merged common.js code (deduplicated) ---

// Enhanced common functionality across all admin pages
document.addEventListener("DOMContentLoaded", () => {
  // Dashboard-specific initialization
  initializeDashboard()
  loadDashboardData()
  initializeCharts()
  setupEventListeners()
  startRealTimeUpdates()
  animateCounters()
  initializeChartResizeObserver()

  // Common.js initialization
  checkAuth();
  setActiveNavigation();
  setupMenuFunctions();
  setupTopBarActionButtons();
  setupModalHandlers();
  initializeTooltips();
  setupGlobalEventListeners();
});

// --- Menu, Quick Actions (+), Fullscreen, Notification ---
function setupMenuFunctions() {
  const quickActionsBtn = document.querySelector('[onclick="toggleQuickActions()"]');
  if (quickActionsBtn) quickActionsBtn.addEventListener("click", toggleQuickActions);
  const fullscreenBtn = document.querySelector('[onclick="toggleFullscreen()"]');
  if (fullscreenBtn) fullscreenBtn.addEventListener("click", toggleFullscreen);
  const notificationBtn = document.querySelector('[onclick="toggleNotifications()"]');
  if (notificationBtn) notificationBtn.addEventListener("click", toggleNotifications);
}
function setupTopBarActionButtons() {
  document.querySelectorAll('.action-btn[onclick="toggleQuickActions()"]').forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      toggleQuickActions();
    });
  });
  document.querySelectorAll('.action-btn[onclick="toggleNotifications()"]').forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      toggleNotifications();
    });
  });
  document.querySelectorAll('.action-btn[onclick="toggleFullscreen()"]').forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      toggleFullscreen();
    });
  });
}
function toggleQuickActions() {
  const panel = document.getElementById("quickActionsPanel");
  if (!panel) return;
  panel.classList.toggle("show");
  const notificationsPanel = document.getElementById("notificationsPanel");
  if (notificationsPanel) notificationsPanel.classList.remove("show");
  // Adjust positioning for mobile
  if (window.innerWidth <= 768) {
    panel.style.right = "10px"
    panel.style.left = "10px"
    panel.style.width = "auto"
  }
}
function toggleNotifications() {
  const panel = document.getElementById("notificationsPanel");
  if (!panel) return;
  panel.classList.toggle("show");
  const quickActionsPanel = document.getElementById("quickActionsPanel");
  if (quickActionsPanel) quickActionsPanel.classList.remove("show");
  // Adjust positioning for mobile
  if (window.innerWidth <= 768) {
    panel.style.right = "10px"
    panel.style.left = "10px"
    panel.style.width = "auto"
  }
}
function toggleFullscreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen();
  } else {
    document.exitFullscreen();
  }
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
    // Close panels
    const notificationsPanel = document.getElementById("notificationsPanel")
    const notificationBtn = document.querySelector('[onclick="toggleNotifications()"]')
    if (notificationsPanel && !notificationsPanel.contains(e.target) && !notificationBtn?.contains(e.target)) {
      notificationsPanel.classList.remove("show")
    }
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

// --- Touch Events ---
function setupTouchEvents() {
  const cards = document.querySelectorAll(".stat-card, .quick-action-card")
  cards.forEach((card) => {
    card.addEventListener("touchstart", function () {
      this.style.transform = "scale(0.98)"
    })
    card.addEventListener("touchend", function () {
      this.style.transform = "scale(1)"
    })
  })
  const buttons = document.querySelectorAll(".btn, .action-btn")
  buttons.forEach((button) => {
    button.addEventListener("touchstart", function () {
      this.style.transform = "scale(0.95)"
    })
    button.addEventListener("touchend", function () {
      this.style.transform = "scale(1)"
    })
  })
}

// --- Utility Functions ---
function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric",
  })
}
function formatDateTime(dateString) {
  const date = new Date(dateString)
  return date.toLocaleString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  })
}
function formatTimeAgo(dateString) {
  const date = new Date(dateString)
  const now = new Date()
  const diffInSeconds = Math.floor((now - date) / 1000)
  if (diffInSeconds < 60) return "Just now"
  if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`
  if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`
  if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 86400)} days ago`
  return formatDate(dateString)
}
function generateId() {
  return Date.now() + Math.random().toString(36).substr(2, 9)
}
function saveToStorage(key, data) {
  try {
    localStorage.setItem(key, JSON.stringify(data))
    return true
  } catch (error) {
    console.error("Error saving to storage:", error)
    showNotification("Error saving data", "error")
    return false
  }
}

// --- Export/Download Functions (deduplicated, use these for export) ---
function exportToCSV(data, filename) {
  if (!data || !data.length) {
    showNotification("No data to export.", "warning")
    return
  }
  const headers = Object.keys(data[0])
  const csvRows = [headers.join(",")]
  data.forEach((item) => {
    const values = headers.map((header) => {
      let value = item[header]
      if (typeof value === "string") {
        value = value.replace(/"/g, '""')
        return `"${value}"`
      }
      return value
    })
    csvRows.push(values.join(","))
  })
  const csvString = csvRows.join("\n")
  const blob = new Blob([csvString], { type: "text/csv" })
  const url = URL.createObjectURL(blob)
  const a = document.createElement("a")
  a.href = url
  a.download = filename
  document.body.appendChild(a)
  a.click()
  document.body.removeChild(a)
  URL.revokeObjectURL(url)
  showNotification(`${filename} downloaded successfully!`, "success")
}
function exportToJSON(data, filename) {
  const json = JSON.stringify(data, null, 2)
  const blob = new Blob([json], { type: "application/json" })
  const url = URL.createObjectURL(blob)
  const a = document.createElement("a")
  a.href = url
  a.download = filename
  document.body.appendChild(a)
  a.click()
  document.body.removeChild(a)
  URL.revokeObjectURL(url)
  showNotification(`${filename} downloaded successfully!`, "success")
}

// --- Export data functions (use the above helpers) ---
function exportDashboardData() {
  const data = {
    stats: {
      totalUsers: dashboardData.users.length,
      totalWorkouts: dashboardData.workouts.length,
      activeDietPlans: dashboardData.dietPlans.length,
      averageRating: calculateAverageRating(),
    },
    exportDate: new Date().toISOString(),
    users: dashboardData.users,
    workouts: dashboardData.workouts,
    dietPlans: dashboardData.dietPlans,
  }
  exportToJSON(data, `dashboard-export-${new Date().toISOString().split("T")[0]}.json`)
}
function exportUsers() {
  exportToCSV(dashboardData.users, `users-export-${new Date().toISOString().split("T")[0]}.csv`)
}
function exportWorkouts() {
  exportToCSV(dashboardData.workouts, `workouts-export-${new Date().toISOString().split("T")[0]}.csv`)
}
function exportDiets() {
  exportToCSV(dashboardData.dietPlans, `diets-export-${new Date().toISOString().split("T")[0]}.csv`)
}
function exportFeedback() {
  exportToCSV(loadFromStorage("feedback", []), `feedback-export-${new Date().toISOString().split("T")[0]}.csv`)
}
function exportAllData() {
  showNotification("Preparing complete data export...", "info")
  setTimeout(exportDashboardData, 1000)
}

// --- Notification/Toast Functions (deduplicated) ---
function showNotification(message, type = "info", duration = 3000) {
  let notificationContainer = document.getElementById("notification-container");
  if (!notificationContainer) {
    notificationContainer = document.createElement("div");
    notificationContainer.id = "notification-container";
    document.body.appendChild(notificationContainer);
  }
  const notification = document.createElement("div");
  notification.className = `notification notification-${type}`;
  notification.textContent = message;
  notificationContainer.appendChild(notification);
  setTimeout(() => {
    notification.remove();
  }, duration);
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

// Helper functions (assumed to be defined elsewhere)
function loadFromStorage(key, defaultValue) {
  try {
    const storedValue = localStorage.getItem(key)
    return storedValue ? JSON.parse(storedValue) : defaultValue
  } catch {
    return defaultValue
  }
}

// --- Stat menu (three-dot) functions (keep all) ---
function toggleStatMenu(button) {
  const dropdown = button.nextElementSibling
  const allDropdowns = document.querySelectorAll(".stat-menu-dropdown")
  allDropdowns.forEach((dd) => {
    if (dd !== dropdown) dd.classList.remove("show")
  })
  dropdown.classList.toggle("show")
}
