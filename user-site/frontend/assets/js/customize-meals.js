document.querySelector('.btn-refresh').addEventListener('click', async () => {
    const container = document.getElementById('meal-recommendations-container');
    container.innerHTML = '<p>Loading...</p>';

    try {
        const res = await fetch('../backend/preload_customize_meals.php?ts=' + new Date().getTime());
        const data = await res.json();

        // ✅ If backend returns error message
        if (data.error) {
            container.innerHTML = `<p class="text-danger mx-1">${data.error}</p>`;
            return;
        }

        const meals = data.personalized_meals;
        const userMacros = data.user_macros;
        const mealMacros = data.total_macros;

        container.innerHTML = ''; // clear loading

        // Calculate difference status
        function getDiffStatus(actual, target, label) {
            const diff = actual - target;
            const abs = Math.abs(diff);
            const isCal = label === 'Calories';
            const tol = isCal ? 100 : 10;

            let status = '';
            if (abs <= tol) {
                status = `✅ ${label} matched`;
            } else if (diff > 0) {
                status = `⚠️ ${label} over by ${abs.toFixed(1)}${isCal ? '' : 'g'}`;
            } else {
                status = `⚠️ ${label} under by ${abs.toFixed(1)}${isCal ? '' : 'g'}`;
            }

            return status;
        }

        const proteinStatus = getDiffStatus(mealMacros.protein, userMacros.protein, 'Protein');
        const carbsStatus = getDiffStatus(mealMacros.carbs, userMacros.carbs, 'Carbs');
        const fatsStatus = getDiffStatus(mealMacros.fats, userMacros.fats, 'Fats');
        const caloriesStatus = getDiffStatus(mealMacros.calories, userMacros.calories, 'Calories');

        // Show macro comparison section
        const userMacroCard = document.createElement('div');
        userMacroCard.className = 'col-12';
        userMacroCard.innerHTML = `
            <div class="alert alert-info mb-3">
                <h6>Your Daily Target Macros</h6>
                <div class="d-flex gap-3 flex-wrap mt-2">
                    <div class="macro-pill protein"><strong>${userMacros.protein.toFixed(1)}g</strong> Protein</div>
                    <div class="macro-pill carbs"><strong>${userMacros.carbs.toFixed(1)}g</strong> Carbs</div>
                    <div class="macro-pill fats"><strong>${userMacros.fats.toFixed(1)}g</strong> Fats</div>
                    <div class="macro-pill calories"><strong>${userMacros.calories.toFixed(1)}</strong> kcal</div>
                </div>
            </div>

            <div class="alert alert-success mb-3">
                <h6>Meal Plan Total Macros</h6>
                <div class="d-flex gap-3 flex-wrap mt-2">
                    <div class="macro-pill protein"><strong>${mealMacros.protein.toFixed(1)}g</strong> Protein</div>
                    <div class="macro-pill carbs"><strong>${mealMacros.carbs.toFixed(1)}g</strong> Carbs</div>
                    <div class="macro-pill fats"><strong>${mealMacros.fats.toFixed(1)}g</strong> Fats</div>
                    <div class="macro-pill calories"><strong>${mealMacros.calories.toFixed(1)}</strong> kcal</div>
                </div>
            </div>

            <div class="alert alert-warning mb-0">
                <h6>Macro Matching Summary</h6>
                <ul class="mb-0">
                    <li>${proteinStatus}</li>
                    <li>${carbsStatus}</li>
                    <li>${fatsStatus}</li>
                    <li>${caloriesStatus}</li>
                </ul>
            </div>
        `;
        container.appendChild(userMacroCard);

        // Show personalized meals
        meals.forEach(meal => {
            const card = document.createElement('div');
            card.className = 'col-md-4 mb-2';
            card.innerHTML = `
                <div class="recipe-card">
                    <div class="recipe-image">
                        <img src="${meal.image_url}" alt="${meal.meal_name}" class="img-fluid rounded-top">
                        <div class="recipe-time">
                            <i class="fas fa-clock"></i> ~${meal.estimated_preparation_min} min
                        </div>
                    </div>
                    <div class="recipe-content">
                        <h6>${meal.meal_name}</h6>
                        <div class="recipe-macros">
                            <div class="macro-pill protein"><strong>${meal.meal_macros.protein.toFixed(1)}g</strong> Protein</div>
                            <div class="macro-pill carbs"><strong>${meal.meal_macros.carbs.toFixed(1)}g</strong> Carbs</div>
                            <div class="macro-pill fats"><strong>${meal.meal_macros.fat.toFixed(1)}g</strong> Fats</div>
                            <div class="macro-pill calories"><strong>${meal.meal_macros.calories.toFixed(1)}</strong> kcal</div>
                        </div>
                        <button class="btn btn-sm btn-primary mt-3 w-100">View Recipe</button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

    } catch (err) {
        container.innerHTML = '<p class="text-danger">Failed to load meals. Please try again</p>';
        console.error('Meal fetch error:', err);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.btn-refresh').click();
});
