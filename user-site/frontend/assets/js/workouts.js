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

    // Filter exercise by category
    document.getElementById('category-filter').addEventListener('change', function () {
        const selectedCategory = this.value;
        const sections = document.querySelectorAll('.exercise-category-section');

        sections.forEach(section => {
            const category = section.getAttribute('data-category');
            if (selectedCategory === '' || category === selectedCategory) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    });
});