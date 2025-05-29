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
    
    // Add to My Workouts Button
    const addToMyWorkoutsBtn = document.querySelector('.card-actions .btn-primary');
    
    if (addToMyWorkoutsBtn) {
        addToMyWorkoutsBtn.addEventListener('click', function() {
            // Here you would typically add the workout to the user's saved workouts
            // For demo purposes, we'll just show an alert
            alert('Workout added to My Workouts!');
            
            // Change button text to indicate it's been added
            this.innerHTML = '<i class="fas fa-check"></i> Added to My Workouts';
            this.classList.add('btn-success');
            this.classList.remove('btn-primary');
            
            // Disable the button to prevent multiple clicks
            this.disabled = true;
            
            // After a delay, reset the button
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-plus"></i> Add to My Workouts';
                this.classList.remove('btn-success');
                this.classList.add('btn-primary');
                this.disabled = false;
            }, 3000);
        });
    }
    
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
});