let justOpened = false;

function openMealModal(button) {
    const category = button?.dataset?.category || '';

    const label = document.getElementById('mealCategoryLabel');
    if (label) {
        label.textContent = category.charAt(0).toUpperCase() + category.slice(1);
    }

    const hiddenInput = document.getElementById('mealCategoryInput');
    if (hiddenInput) {
        hiddenInput.value = category;
    }

    document.getElementById('mealModal').classList.add('show');
    document.getElementById('modalBackdrop').classList.add('show');

    // Prevent immediate close due to the same click
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

