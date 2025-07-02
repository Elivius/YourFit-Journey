function renderMeals(data) {
    const container = document.getElementById('meal-recommendations-container');
    container.innerHTML = '';

    const meals = data.personalized_meals;
    const userMacros = data.user_macros;
    const mealMacros = data.total_macros;

    function getDiffStatus(actual, target, label) {
        const diff = actual - target;
        const abs = Math.abs(diff);
        const isCal = label === 'Calories';
        const tol = isCal ? 100 : 10;

        if (abs <= tol) return `✅ ${label} matched`;
        return diff > 0
            ? `⚠️ ${label} over by ${abs.toFixed(1)}${isCal ? '' : 'g'}`
            : `⚠️ ${label} under by ${abs.toFixed(1)}${isCal ? '' : 'g'}`;
    }

    const userMacroCard = document.createElement('div');
    userMacroCard.className = 'col-12';
    userMacroCard.innerHTML = `
        <div class="alert alert-info mb-0">
            <h6>Macro Matching Summary (Within Tolerance)</h6>
            <ul class="mb-0">
                <li>${getDiffStatus(mealMacros.protein, userMacros.protein, 'Protein')}</li>
                <li>${getDiffStatus(mealMacros.carbs, userMacros.carbs, 'Carbs')}</li>
                <li>${getDiffStatus(mealMacros.fats, userMacros.fats, 'Fats')}</li>
                <li>${getDiffStatus(mealMacros.calories, userMacros.calories, 'Calories')}</li>
            </ul>
        </div>
    `;
    container.appendChild(userMacroCard);

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
                <span class="badge category-badge mx-4 mt-2 mb-2">${meal.category.charAt(0).toUpperCase() + meal.category.slice(1)}</span>
                <div class="recipe-content">
                    <h6 class="mx-1">${meal.meal_name}</h6>
                    <div class="recipe-macros mb-2">
                        <div class="macro-pill protein"><strong>${meal.meal_macros.protein.toFixed(1)}g</strong> Protein</div>
                        <div class="macro-pill carbs"><strong>${meal.meal_macros.carbs.toFixed(1)}g</strong> Carbs</div>
                        <div class="macro-pill fats"><strong>${meal.meal_macros.fat.toFixed(1)}g</strong> Fats</div>
                        <div class="macro-pill calories"><strong>${meal.meal_macros.calories.toFixed(1)}</strong> kcal</div>
                    </div>
                    <hr class="muted-p">
                    <div class="ingredients mx-1">
                        <p class="ingredients-heading d-block mb-1">Ingredients:</p>
                        <ul class="list-unstyled small mb-0">
                            ${meal.ingredients.map(ing => `
                                <li>
                                    <span class="ingredient-name">${ing.name}</span> -
                                    <strong class="ingredient-grams">${ing.grams}g</strong>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                </div>
            </div>
        `;

        const recipeContent = card.querySelector('.recipe-content');
        const formTemplate = document.getElementById('log-meal-form-customize-planner');
        const formClone = formTemplate.content.cloneNode(true);

        formClone.querySelector('[name="meal_id"]').value = meal.meal_id;
        formClone.querySelector('[name="meal_name"]').value = meal.meal_name;
        formClone.querySelector('[name="category"]').value = meal.category;
        formClone.querySelector('[name="protein"]').value = meal.meal_macros.protein;
        formClone.querySelector('[name="carbs"]').value = meal.meal_macros.carbs;
        formClone.querySelector('[name="fats"]').value = meal.meal_macros.fat;
        formClone.querySelector('[name="calories"]').value = meal.meal_macros.calories;

        recipeContent.appendChild(formClone);
        container.appendChild(card);
    });
}


document.querySelector('.btn-refresh').addEventListener('click', async () => {
    const container = document.getElementById('meal-recommendations-container');
    container.innerHTML = '<p>Loading...</p>';

    try {
        const res = await fetch('../backend/preload_customize_meals.php?ts=' + new Date().getTime());
        const data = await res.json();

        if (data.error) {
            container.innerHTML = `<p class="text-danger mx-1">${data.error}</p>`;
            return;
        }

        sessionStorage.setItem('customMeals', JSON.stringify(data));
        renderMeals(data);

    } catch (err) {
        container.innerHTML = '<p class="text-danger mx-1">Failed to load meals. Please try again</p>';
        console.error('Meal fetch error:', err);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const cached = sessionStorage.getItem('customMeals');
    if (cached) {
        renderMeals(JSON.parse(cached));
    } else {
        document.querySelector('.btn-refresh').click();
    }
});
