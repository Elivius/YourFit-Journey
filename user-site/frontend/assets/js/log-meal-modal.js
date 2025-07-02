let justOpened = false;

function openMealModal(button) {
    const category = button?.dataset?.category || '';

    document.getElementById('mealCategoryLabel').textContent =
        category.charAt(0).toUpperCase() + category.slice(1);
    document.getElementById('mealCategoryInput').value = category;

    // Prefill form if it's an edit button
    if (button?.dataset?.mealName !== undefined) {
        document.getElementById('mealName').value = button.dataset.mealName || '';
        document.getElementById('protein').value = button.dataset.protein || '';
        document.getElementById('carbs').value = button.dataset.carbs || '';
        document.getElementById('fats').value = button.dataset.fats || '';
        document.getElementById('calories').value = button.dataset.calories || '';
        document.getElementById('mealLogIdInput').value = button.dataset.mealId || '';
    } else {
        // Reset the form if it's an "Add Food" button
        document.getElementById('mealName').value = '';
        document.getElementById('protein').value = '';
        document.getElementById('carbs').value = '';
        document.getElementById('fats').value = '';
        document.getElementById('calories').value = '';
        document.getElementById('mealLogIdInput').value = '';
    }

    document.getElementById('mealModal').classList.add('show');
    document.getElementById('modalBackdrop').classList.add('show');

    // Prevent immediate close due to same click
    justOpened = true;
    setTimeout(() => {
        justOpened = false;
    }, 100);
}

function closeMealModal() {
    document.getElementById('mealModal').classList.remove('show');
    document.getElementById('modalBackdrop').classList.remove('show');
}

document.addEventListener('click', function (e) {
    if (justOpened) return; // prevent immediate close

    const modal = document.getElementById('mealModal');
    const content = modal.querySelector('.modal-content');

    if (modal.classList.contains('show') && !content.contains(e.target)) {
        closeMealModal();
    }
});

// Auto calories calculation
const proteinInput = document.getElementById('protein');
const carbsInput = document.getElementById('carbs');
const fatsInput = document.getElementById('fats');
const caloriesInput = document.getElementById('calories');

function updateCalories() {
    const protein = parseFloat(proteinInput.value) || 0;
    const carbs = parseFloat(carbsInput.value) || 0;
    const fats = parseFloat(fatsInput.value) || 0;
    const calories = (protein * 4) + (carbs * 4) + (fats * 9);
    caloriesInput.value = calories.toFixed(1);
}

proteinInput.addEventListener('input', updateCalories);
carbsInput.addEventListener('input', updateCalories);
fatsInput.addEventListener('input', updateCalories);

function confirmDeleteMeal(button) {
    const mealId = button.dataset.mealId;
    if (!mealId) return alert("Meal ID missing");

    if (confirm("Are you sure you want to delete this meal?")) {
        const form = document.getElementById('deleteMealForm');
        document.getElementById('deleteMealLogIdInput').value = mealId;
        form.submit();
    }
}
