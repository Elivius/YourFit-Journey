// Select
document.getElementById('selectAll').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('.rowCheckbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    toggleActionButtons();
});

document.querySelectorAll('.rowCheckbox').forEach(cb => {
    cb.addEventListener('change', toggleActionButtons);
});

function toggleActionButtons() {
    const selectedCount = document.querySelectorAll('.rowCheckbox:checked').length;
    document.getElementById('editBtn').disabled = selectedCount !== 1;
    document.getElementById('deleteBtn').disabled = selectedCount === 0;
}

// Add Modal
document.getElementById('addBtn').addEventListener('click', () => {
    document.getElementById('addModal').classList.add('active');
    document.getElementById('addBackdrop').classList.add('active');
});

document.getElementById('addCloseBtn').addEventListener('click', closeAddModal);
document.getElementById('addCancel').addEventListener('click', closeAddModal);

function closeAddModal() {
    document.getElementById('addModal').classList.remove('active');
    document.getElementById('addBackdrop').classList.remove('active');
}

document.getElementById('addBackdrop').addEventListener('click', closeAddModal);

// Edit Modal
document.getElementById('editBtn').addEventListener('click', function () {
    const selected = document.querySelector('.rowCheckbox:checked');
    if (!selected) return;

    const row = selected.closest('tr');
    const cells = row.querySelectorAll('td');

    // Fill the update form with data
    document.getElementById('updateMealID').value = cells[2].innerText;
    document.getElementById('updateIngredientID').value = cells[3].innerText;
    document.getElementById('updateBaseGrams').value = cells[4].innerText;

    let idInput = document.getElementById('updateDietId');
    if (!idInput) {
        idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'mealIngredientId';
        idInput.id = 'updateDietId';
        document.querySelector('#updateModal form').appendChild(idInput);
    }
    idInput.value = cells[1].innerText;

    // Show update modal
    document.getElementById('updateModal').classList.add('active');
    document.getElementById('updateBackdrop').classList.add('active');
});

document.getElementById('updateCloseBtn').addEventListener('click', closeUpdateModal);
document.getElementById('updateCancel').addEventListener('click', closeUpdateModal);

function closeUpdateModal() {
    document.getElementById('updateModal').classList.remove('active');
    document.getElementById('updateBackdrop').classList.remove('active');
}

document.getElementById('updateBackdrop').addEventListener('click', closeUpdateModal);

// Delete diet
document.getElementById('deleteBtn').addEventListener('click', function () {
    const selected = Array.from(document.querySelectorAll('.rowCheckbox:checked')).map(cb => cb.value);
    if (selected.length === 0) return;

    if (confirm(`Are you sure you want to delete ${selected.length} diet item(s)?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../backend/process_delete_diet_management.php';

        selected.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'mealIngredientIds[]';
            input.value = id;
            form.appendChild(input);
        });

        const csrfToken = document.querySelector('input[name="csrf_token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = csrfToken.value;
            form.appendChild(csrfInput);
        }

        document.body.appendChild(form);
        form.submit();
    }
});

const filterInput = document.getElementById('filterInput');
const clearFilterBtn = document.getElementById('clearFilterBtn');
const dataTable = document.getElementById('dataTable');

filterInput.addEventListener('input', function () {
    const filterValue = this.value.toLowerCase();
    const rows = dataTable.getElementsByTagName('tr');

    Array.from(rows).forEach(row => {
        const baseGrams = row.cells[4].textContent.toLowerCase().trim(); // Base Grams
        const visible = baseGrams.includes(filterValue);
        row.style.display = visible ? '' : 'none';
    });

    clearFilterBtn.style.display = filterValue ? 'inline' : 'none';
});

clearFilterBtn.addEventListener('click', function () {
    filterInput.value = '';
    filterInput.dispatchEvent(new Event('input'));
});