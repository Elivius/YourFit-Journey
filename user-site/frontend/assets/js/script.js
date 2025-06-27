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

    // ==============================
    // Tab Navigation (Section Logic)
    // ==============================
    const topNavItems = document.querySelectorAll('.top-nav-item');
    const tabSections = document.querySelectorAll('.tab-section');

    function activateSection(target) {
        topNavItems.forEach(navItem => {
            navItem.classList.toggle('active', navItem.getAttribute('data-target') === target);
        });

        tabSections.forEach(section => {
            section.classList.toggle('active', section.id === target);
        });
    }

    function updateURL(section, category = null) {
        const url = new URL(window.location);
        url.searchParams.set('section', section);
        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }
        window.history.pushState({}, '', url);
    }

    // ==============================
    // Workout Category Handling
    // ==============================
    const workoutCategories = document.querySelectorAll('.workout-category-card');
    const workoutCategorySections = document.querySelectorAll('.workout-category-section');

    function activateWorkoutCategory(category) {
        workoutCategories.forEach(card => {
            card.classList.toggle('active', card.dataset.category === category);
        });

        workoutCategorySections.forEach(section => {
            const isMatch = section.id === `pre-built-${category}-workouts`;
            section.classList.toggle('active', isMatch);
            section.style.display = isMatch ? 'block' : 'none';
            section.style.visibility = isMatch ? 'visible' : 'hidden';
            section.style.height = isMatch ? 'auto' : '0';
        });
    }

    // ==============================
    // Event Listeners
    // ==============================
    topNavItems.forEach(navItem => {
        navItem.addEventListener('click', e => {
            e.preventDefault();
            const targetSection = navItem.dataset.target;
            activateSection(targetSection);

            if (targetSection === 'pre-built-workouts') {
                activateWorkoutCategory('chest'); // Default category
                updateURL(targetSection, 'chest');
            } else {
                updateURL(targetSection);
            }
        });
    });
    
    workoutCategories.forEach(categoryCard => {
        categoryCard.addEventListener('click', e => {
            e.preventDefault();
            const category = categoryCard.dataset.category;
            activateWorkoutCategory(category);
            updateURL('pre-built-workouts', category);
        });
    });
    
    // ==============================
    // Save Scroll Position Before Submit
    // ==============================
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            sessionStorage.setItem('scrollY', window.scrollY);
        });
    });

    // ==============================
    // Initialization on Page Load
    // ==============================
    window.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        const section = params.get('section') || getDefaultSection(); // fallback to 'profile'
        const category = params.get('category') || 'chest';

        activateSection(section);

        if (section === 'pre-built-workouts') {
            activateWorkoutCategory(category);
        }

         // Restore scroll position if available
        const savedScrollY = sessionStorage.getItem('scrollY');
        if (savedScrollY !== null) {
            window.scrollTo(0, parseInt(savedScrollY));
            sessionStorage.removeItem('scrollY');
        }
    });

    // ==============================
    // Utility: Fallback Section
    // ==============================
    function getDefaultSection() {
        return document.body.classList.contains('workouts-page') ? 'pre-built-workouts' : 'profile';
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

    // Category chevron
    const select = document.getElementById('category-filter');
    const chevron = document.getElementById('select-chevron');

    // Show rotate when clicked (mousedown)
    select.addEventListener('mousedown', () => {
        chevron.classList.add('rotate');
    });

    // Always remove rotate after a short delay (dropdown closed)
    select.addEventListener('change', () => {
        setTimeout(() => {
            chevron.classList.remove('rotate');
        }, 15); // slight delay lets dropdown close naturally
    });

    // Remove rotate on blur (user tabs or clicks away)
    select.addEventListener('blur', () => {
        chevron.classList.remove('rotate');
    });

    // Backup: Click anywhere outside
    document.addEventListener('click', (e) => {
        if (!select.contains(e.target)) {
            chevron.classList.remove('rotate');
        }
    });
});