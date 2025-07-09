document.addEventListener('DOMContentLoaded', function() {
    // Workout Category Selection
    const workoutCategories = document.querySelectorAll('.workout-category-card');
    
    workoutCategories.forEach(category => {
        category.addEventListener('click', function() {
            // Remove active class from all categories
            workoutCategories.forEach(cat => {
                cat.classList.remove('active');
            });
            
            this.classList.add('active');
            
            const categoryName = this.querySelector('h4').textContent;
            console.log(`Selected category: ${categoryName}`);
        });
    });
    
    // Print Workout Button
    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-outline-primary');

        if (btn && btn.innerText.includes('Print')) {
            alert('Printing workout plan...');
            window.print();
        }
    });


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