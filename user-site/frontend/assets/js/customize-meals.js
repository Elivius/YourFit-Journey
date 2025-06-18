document.querySelector('.btn-refresh').addEventListener('click', async () => {
    const container = document.getElementById('meal-recommendations-container');
    container.innerHTML = '<p>Loading...</p>';

    try {
        const res = await fetch('../backend/preload_customize_meals.php');
        const data = await res.json();

        const meals = data.personalized_meals;

        container.innerHTML = ''; // clear loading

        meals.forEach(meal => {
            const card = document.createElement('div');
            card.className = 'col-md-4';
            card.innerHTML = `
                <div class="recipe-card">
                    <div class="recipe-image">
                        <img src="${meal.image_url}" alt="${meal.meal_name}" class="img-fluid rounded">
                        <div class="recipe-time">
                            <i class="fas fa-clock"></i> ~${meal.estimated_preparation_min} min
                        </div>
                    </div>
                    <div class="recipe-content">
                        <h6>${meal.meal_name}</h6>
                        <p>Customized meal plan tailored to your macros.</p>
                        <div class="recipe-macros">
                        <div class="macro-pill protein"><span>${meal.meal_macros.protein.toFixed(1)}g P</span></div>
                        <div class="macro-pill carbs"><span>${meal.meal_macros.carbs.toFixed(1)}g C</span></div>
                        <div class="macro-pill fats"><span>${meal.meal_macros.fat.toFixed(1)}g F</span></div>
                        <div class="macro-pill"><span>${meal.meal_macros.calories.toFixed(1)} cal</span></div>
                        </div>
                        <button class="btn btn-sm btn-primary mt-3 w-100">View Recipe</button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

    } catch (err) {
        container.innerHTML = '<p class="text-danger">Failed to load meals. Please try again.</p>';
        console.error('Meal fetch error:', err);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.btn-refresh').click();
});