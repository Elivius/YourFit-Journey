document.addEventListener('DOMContentLoaded', function() {    
    // Settings page tab navigation
    const settingsNavItems = document.querySelectorAll('.settings-nav-item');
    const settingsSections = document.querySelectorAll('.settings-section');

    function activateSection(target) {
    // Update active nav item
    settingsNavItems.forEach(navItem => {
        navItem.classList.toggle('active', navItem.getAttribute('data-target') === target);
    });

    // Show target section
    settingsSections.forEach(section => {
        section.classList.toggle('active', section.id === target);
    });
    }

    function updateURL(section) {
    const url = new URL(window.location);
    url.searchParams.set('section', section);
    window.history.pushState({}, '', url);
    }

    // On page load, activate based on URL or default to 'profile'
    window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const section = params.get('section') || 'profile';
    activateSection(section);
    });

    // On nav item click, activate section and update URL
    settingsNavItems.forEach(item => {
    item.addEventListener('click', function() {
        const target = this.getAttribute('data-target');
        activateSection(target);
        updateURL(target);
    });
    });

    
    // Toggle Password Visibility
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
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

    const urlParams = new URLSearchParams(window.location.search);
    const section = urlParams.get('section');

    if (section) {
        // Scroll to the section (e.g., an element with id="activity-level")
        const target = document.getElementById(section);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }

        // OPTIONAL: If you have tabs or accordions, activate the correct tab
        // Example: $('#myTab a[href="#' + section + '"]').tab('show');
    };
    
    // // Rating Stars
    // const ratingStars = document.querySelectorAll('.rating-stars');
    
    // ratingStars.forEach(container => {
    //     const stars = container.querySelectorAll('i');
        
    //     stars.forEach((star, index) => {
    //         star.addEventListener('click', function() {
    //             // Reset all stars
    //             stars.forEach((s, i) => {
    //                 if (i <= index) {
    //                     s.className = 'fas fa-star';
    //                 } else {
    //                     s.className = 'far fa-star';
    //                 }
    //             });
    //         });
            
    //         star.addEventListener('mouseover', function() {
    //             // Reset all stars
    //             stars.forEach((s, i) => {
    //                 if (i <= index) {
    //                     s.className = 'fas fa-star';
    //                 } else {
    //                     s.className = 'far fa-star';
    //                 }
    //             });
    //         });
    //     });
        
    //     container.addEventListener('mouseout', function() {
    //         // Find the last selected star
    //         const selectedIndex = Array.from(stars).findIndex(star => star.classList.contains('selected'));
            
    //         stars.forEach((s, i) => {
    //             if (selectedIndex >= 0 && i <= selectedIndex) {
    //                 s.className = 'fas fa-star';
    //             } else if (s.classList.contains('fas')) {
    //                 s.className = 'fas fa-star';
    //             } else {
    //                 s.className = 'far fa-star';
    //             }
    //         });
    //     });
    // });
    
   
    // // Primary Goal Selection
    // const primaryGoalRadios = document.querySelectorAll('input[name="primaryGoal"]');
    // const goalDetails = document.querySelector('.goal-details');
    
    // primaryGoalRadios.forEach(radio => {
    //     radio.addEventListener('change', function() {
    //         if (this.id === 'loseWeight') {
    //             document.getElementById('targetWeight').parentElement.style.display = 'block';
    //             document.getElementById('weeklyGoal').parentElement.style.display = 'block';
    //             document.querySelector('.goal-summary').style.display = 'block';
    //         } else if (this.id === 'buildMuscle') {
    //             document.getElementById('targetWeight').parentElement.style.display = 'block';
    //             document.getElementById('weeklyGoal').parentElement.style.display = 'none';
    //             document.querySelector('.goal-summary').style.display = 'block';
    //         } else {
    //             document.getElementById('targetWeight').parentElement.style.display = 'none';
    //             document.getElementById('weeklyGoal').parentElement.style.display = 'none';
    //             document.querySelector('.goal-summary').style.display = 'none';
    //         }
    //     });
    // });
    
    // Notification Category Toggles
    const categoryToggles = document.querySelectorAll('.notification-category-header .form-check-input');
    
    categoryToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const options = this.closest('.notification-category').querySelector('.notification-options');
            const checkboxes = options.querySelectorAll('input[type="checkbox"]');
            
            checkboxes.forEach(checkbox => {
                checkbox.disabled = !this.checked;
                if (!this.checked) {
                    checkbox.checked = false;
                }
            });
        });
    });
    
    // Delete Account Confirmation
    const deleteAccountBtn = document.querySelector('.data-action.danger-zone button');
    
    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                alert('Account deletion request submitted. You will receive a confirmation email.');
            }
        });
    }
    
    // Clear History Confirmation
    const clearHistoryBtns = document.querySelectorAll('.data-action:not(.danger-zone) .btn-outline-warning');
    
    clearHistoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const historyType = this.previousElementSibling.querySelector('h6').textContent;
            if (confirm(`Are you sure you want to clear your ${historyType.toLowerCase()}? This action cannot be undone.`)) {
                alert(`${historyType} has been cleared successfully.`);
            }
        });
    });
});