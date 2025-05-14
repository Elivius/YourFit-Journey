document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".navbar-nav .nav-link");
  const sections = Array.from(document.querySelectorAll("section[id]"));
  const navbarHeight = document.querySelector('.navbar').offsetHeight;

  // Scroll spy
  function updateActiveLink() {
    const centerY = window.innerHeight / 2;
    let currentSection = sections[0];

    for (const section of sections) {
      const rect = section.getBoundingClientRect();
      const sectionCenter = rect.top + rect.height / 2;

      if (sectionCenter < centerY) {
        currentSection = section;
      }
    }

    navLinks.forEach(link => {
      link.classList.remove("active");
      if (link.getAttribute("href") === `#${currentSection.id}`) {
        link.classList.add("active");
      }
    });
  }

  // Smooth scroll with offset
  document.querySelectorAll('a[data-scroll-to]').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const targetId = this.getAttribute('data-scroll-to');
      const target = document.getElementById(targetId);

      if (target) {
        const top = target.getBoundingClientRect().top + window.scrollY - navbarHeight + 10;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

  // Attach event listeners
  window.addEventListener("scroll", updateActiveLink);
  window.addEventListener("resize", updateActiveLink);
  updateActiveLink(); // Initial call

  // Nav Bar Collapse on Mobile
  const navbarCollapse = document.getElementById('navbarNav');
  document.querySelectorAll('.nav-link[data-scroll-to]').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth < 992) {
        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
          toggle: false
        });
        bsCollapse.hide();
      }
    });
  });

  // Nav Bar Collapse on Outside Click
  const navbar = document.querySelector('.navbar');
  const toggler = document.querySelector('.navbar-toggler');

  document.addEventListener('click', function (event) {
    const isClickInside = navbar.contains(event.target);
    const isExpanded = toggler.getAttribute('aria-expanded') === 'true';

    if (!isClickInside && isExpanded) {
      const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
        toggle: false
      });
      bsCollapse.hide();
    }
  });

});