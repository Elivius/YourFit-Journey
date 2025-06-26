document.addEventListener('DOMContentLoaded', function() {
    // Workout Category Selection
    const workoutCategories = document.querySelectorAll('.workout-category-card');
    
    workoutCategories.forEach(category => {
        category.addEventListener('click', function() {
            // Remove active class from all categories
            workoutCategories.forEach(cat => {
                cat.classList.remove('active');
            });
            
            // Add active class to clicked category
            this.classList.add('active');
            
            // Here you would typically load the appropriate workout plan
            // based on the selected category
            const categoryName = this.querySelector('h4').textContent;
            console.log(`Selected category: ${categoryName}`);
        });
    });
    
    // Print Workout Button
    const printWorkoutBtn = document.querySelector('.card-actions .btn-outline-primary');
    
    if (printWorkoutBtn) {
        printWorkoutBtn.addEventListener('click', function() {
            // Here you would typically open a print dialog
            // For demo purposes, we'll just show an alert
            alert('Printing workout plan...');
            window.print();
        });
    }

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