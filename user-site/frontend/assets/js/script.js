document.addEventListener('DOMContentLoaded', function() {
    // Unified Password Toggle Visibility
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');

    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            let passwordInput = null;
            
            // First, check for an input in the same .input-group
            const inputGroup = this.closest('.input-group');
            if (inputGroup) {
                passwordInput = inputGroup.querySelector('input[type="password"], input[type="text"]');
            }

            // Fallback: check the previous element sibling
            if (!passwordInput) {
                const prevInput = this.previousElementSibling;
                if (prevInput && (prevInput.type === 'password' || prevInput.type === 'text')) {
                    passwordInput = prevInput;
                }
            }

            // If no password input found, do nothing
            if (!passwordInput) return;

            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Responsive Navigation
    const handleResponsiveLayout = () => {
        if (window.innerWidth < 992 && sidebar) {
            sidebar.classList.remove('show');
        }
    };
    
    window.addEventListener('resize', handleResponsiveLayout);
    
    // Initialize tooltips and popovers if Bootstrap JS is loaded
    let bootstrap;
    if (typeof bootstrap !== 'undefined') {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });
        
        const popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
        popovers.forEach(popover => {
            new bootstrap.Popover(popover);
        });
    }
    
    // Handle dropdowns manually if needed
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(event) {
            if (typeof bootstrap === 'undefined') {
                event.preventDefault();
                const dropdown = this.nextElementSibling;
                if (dropdown && dropdown.classList.contains('dropdown-menu')) {
                    dropdown.classList.toggle('show');
                }
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (typeof bootstrap === 'undefined') {
            const dropdowns = document.querySelectorAll('.dropdown-menu.show');
            dropdowns.forEach(dropdown => {
                const dropdownToggle = dropdown.previousElementSibling;
                if (dropdownToggle && !dropdownToggle.contains(event.target)) {
                    dropdown.classList.remove('show');
                }
            });
        }
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId !== '#') {
                e.preventDefault();
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80, // Adjust for header height
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Tab Navigation
    const topNavItems = document.querySelectorAll('.top-nav-item');
    const tabSections = document.querySelectorAll('.tab-section');

    function activateSection(target) {
        // Update active nav item
        topNavItems.forEach(navItem => {
            navItem.classList.toggle('active', navItem.getAttribute('data-target') === target);
        });

        // Show target section
        tabSections.forEach(section => {
            section.classList.toggle('active', section.id === target);
        });
    }

    function updateURL(section) {
        const url = new URL(window.location);
        url.searchParams.set('section', section);
        window.history.pushState({}, '', url);
    }

    window.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        const section = params.get('section') || getDefaultSection(); // fallback to 'profile'
        
        // Activate the correct section BEFORE showing any content
        activateSection(section);
    });

    // On nav item click, activate section and update URL
    topNavItems.forEach(item => {
        item.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            activateSection(target);
            updateURL(target);
        });
    });

    // Function to determine default section based on page
    function getDefaultSection() {
        // Example using body class or specific container
        if (document.body.classList.contains('workouts-page')) {
            return 'pre-built-workouts';
        } else {
            return 'profile';
        }
    }
    
    // Add accessibility attributes
    const addAccessibilityAttributes = () => {
        // Add aria-label to buttons without text
        document.querySelectorAll('button').forEach(button => {
            if (!button.textContent.trim() && !button.getAttribute('aria-label')) {
                const icon = button.querySelector('i');
                if (icon) {
                    const iconClass = Array.from(icon.classList).find(cls => cls.startsWith('fa-'));
                    if (iconClass) {
                        const label = iconClass.replace('fa-', '').replace(/-/g, ' ');
                        button.setAttribute('aria-label', label);
                    }
                }
            }
        });
        
        // Add aria-current to active navigation items
        document.querySelectorAll('.sidebar-item.active .sidebar-link').forEach(link => {
            link.setAttribute('aria-current', 'page');
        });
        
        // Add role="alert" to alert messages
        document.querySelectorAll('.alert').forEach(alert => {
            alert.setAttribute('role', 'alert');
        });
    };
    
    addAccessibilityAttributes();
});