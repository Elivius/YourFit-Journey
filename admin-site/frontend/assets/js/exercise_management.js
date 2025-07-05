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

document.getElementById('addModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeAddModal();
    }
});

// Edit Modal
document.getElementById('editBtn').addEventListener('click', function () {
    const selected = document.querySelector('.rowCheckbox:checked');
    if (!selected) return;

    const row = selected.closest('tr');
    const cells = row.querySelectorAll('td');

    // Fill the update form with data
    document.getElementById('updateExerciseName').value = cells[2].innerText;
    
    const img = cells[3].querySelector('img');
    if (img) {
        document.getElementById('updateImageUrl').value = img.getAttribute('src');
    } else {
        document.getElementById('updateImageUrl').value = '';
    }
    document.getElementById('updateCategory').value = cells[4].innerText;

    const muscleDivs = cells[5].querySelectorAll('div');
    const muscles = Array.from(muscleDivs)
        .map(div => div.innerText.replace(/^•\s*/, '').trim())
        .filter(m => m.length > 0)
        .join(', ');
    document.getElementById('updateTargetedMuscle').value = muscles;

    document.getElementById('updateInstructions').value = cells[6].innerText;

    let idInput = document.getElementById('updateExerciseId');
    if (!idInput) {
        idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'exerciseId';
        idInput.id = 'updateExerciseId';
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

document.getElementById('updateModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeUpdateModal();
    }
});

// Delete User
document.getElementById('deleteBtn').addEventListener('click', function () {
    const selected = Array.from(document.querySelectorAll('.rowCheckbox:checked')).map(cb => cb.value);
    if (selected.length === 0) return;

    if (confirm(`Are you sure you want to delete ${selected.length} exercise(s)?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../backend/process_delete_exercise_management.php';

        selected.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'exerciseIds[]';
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
        const exerciseName = row.cells[2].textContent.toLowerCase().trim();
        const targetedMuscle = row.cells[5].textContent.toLowerCase().trim();
        const combined = `${exerciseName} ${targetedMuscle}`;
        const visible = combined.includes(filterValue);
        row.style.display = visible ? '' : 'none';
    });

    clearFilterBtn.style.display = filterValue ? 'inline' : 'none';
});

clearFilterBtn.addEventListener('click', function () {
    filterInput.value = '';
    filterInput.dispatchEvent(new Event('input'));
});