// Sidebar Toggle Functionality
document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const toggleSidebarBtn = document.getElementById("toggle-sidebar");
  const closeSidebarBtn = document.getElementById("close-sidebar");
  const sidebarItems = document.querySelectorAll(".sidebar-item");

  // Create overlay for mobile
  const overlay = document.createElement("div");
  overlay.className = "sidebar-overlay";
  document.body.appendChild(overlay);

  // Set animation index for items
  sidebarItems.forEach((item, index) => {
    item.style.setProperty("--item-index", index);
  });

  function openSidebar() {
    sidebar.classList.add("active");
    sidebar.classList.remove("collapsed");
    overlay.classList.add("active");
    if (window.innerWidth < 992) {
      document.body.style.overflow = "hidden";
    }
  }

  function closeSidebar() {
    sidebar.classList.remove("active");
    sidebar.classList.add("collapsed");
    overlay.classList.remove("active");
    document.body.style.overflow = "";
  }


  function toggleSidebar() {
    const isCollapsed = sidebar.classList.contains("collapsed");
    if (isCollapsed) {
      openSidebar();
    } else {
      closeSidebar();
    }
  }

  // Toggle button
  if (toggleSidebarBtn) {
    toggleSidebarBtn.addEventListener("click", (e) => {
      e.preventDefault();
      toggleSidebar();
    });
  }

  // Close button
  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener("click", (e) => {
      e.preventDefault();
      closeSidebar();
    });
  }

  // Overlay click
  overlay.addEventListener("click", closeSidebar);

  // Resize behavior
  window.addEventListener("resize", () => {
    if (window.innerWidth >= 992) {
      // Reset to default for desktop
      overlay.classList.remove("active");
      sidebar.classList.remove("active");
      sidebar.classList.add("collapsed");
      document.body.style.overflow = "";
    } else {
      // For mobile: if sidebar is open, keep body overflow hidden
      if (!sidebar.classList.contains("collapsed")) {
        document.body.style.overflow = "hidden";
      }
    }
  });

  // Restore state on load
  const savedState = localStorage.getItem("sidebarCollapsed");
  if (savedState === "true") {
    sidebar.classList.add("collapsed");
  } else {
    sidebar.classList.add("collapsed"); // default to collapsed on load
  }

  // Sidebar icon scaling animation
  const sidebarLinks = document.querySelectorAll(".sidebar-link");
  sidebarLinks.forEach((link) => {
    link.addEventListener("mouseenter", () => {
      const icon = link.querySelector("i");
      if (icon) icon.style.transform = "scale(1.2)";
    });

    link.addEventListener("mouseleave", () => {
      const icon = link.querySelector("i");
      if (icon) icon.style.transform = "scale(1)";
    });
  });
});
