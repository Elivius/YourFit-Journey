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
            
            // For demo purposes, we'll just update the title
            const planTitle = document.querySelector('.card-title');
            if (planTitle && planTitle.textContent.includes('Workout Plan')) {
                planTitle.textContent = `Beginner ${categoryName} Workout Plan`;
            }
        });
    });
    
    // Workout Options Selection
    const workoutOptions = document.querySelectorAll('.workout-options .btn');
    
    workoutOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            workoutOptions.forEach(opt => {
                opt.classList.remove('active');
                opt.classList.remove('btn-primary');
                opt.classList.add('btn-outline-primary');
            });
            
            // Add active class to clicked option
            this.classList.add('active');
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');
            
            // Here you would typically load the appropriate content
            // based on the selected option
            console.log(`Selected option: ${this.textContent}`);
        });
    });
    
    // Exercise Accordion Animation
    const accordionButtons = document.querySelectorAll('.accordion-button');
    
    accordionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            if (!isExpanded) {
                // Scroll to the expanded item after a short delay
                setTimeout(() => {
                    const accordionItem = this.closest('.accordion-item');
                    accordionItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 300);
            }
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