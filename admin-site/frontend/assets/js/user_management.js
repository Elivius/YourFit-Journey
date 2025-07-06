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
    const selected = document.querySelectorAll('.rowCheckbox:checked');
    const selectedCount = selected.length;

    // If selected is admin, disable edit and delete buttons
    let hasAdmin = false;
    selected.forEach(cb => {
        const row = cb.closest('tr');
        const roleCell = row.cells[7];
        const role = roleCell.textContent.trim().toLowerCase();
        if (role === 'admin') {
            hasAdmin = true;
        }
    });

    const editBtn = document.getElementById('editBtn');
    const deleteBtn = document.getElementById('deleteBtn');

    if (hasAdmin) {
        editBtn.disabled = true;
        deleteBtn.disabled = true;
    } else {
        editBtn.disabled = selectedCount !== 1;
        deleteBtn.disabled = selectedCount === 0;
    }
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
    document.getElementById('updateFirstName').value = cells[2].innerText;
    document.getElementById('updateLastName').value = cells[3].innerText;
    document.getElementById('updateEmail').value = cells[4].innerText;
    document.getElementById('updateRole').value = cells[7].innerText;
    document.getElementById('updateAge').value = cells[8].innerText;
    document.getElementById('updateGender').value = cells[9].innerText;
    document.getElementById('updateWeight').value = cells[10].innerText;
    document.getElementById('updateHeight').value = cells[11].innerText;
    document.getElementById('updateActivityLevel').value = cells[12].innerText;
    document.getElementById('updateGoal').value = cells[13].innerText;

    // Ensure there's a hidden userId input in the form
    let idInput = document.getElementById('updateUserId');
    if (!idInput) {
        idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'userId';
        idInput.id = 'updateUserId';
        document.querySelector('#updateModal form').appendChild(idInput);
    }
    idInput.value = cells[1].innerText; // user ID

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

    if (confirm(`Are you sure you want to delete ${selected.length} user(s)?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../backend/process_delete_user_management.php';

        selected.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'userIds[]';
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
        const firstName = row.cells[2].textContent.toLowerCase().trim();
        const lastName = row.cells[3].textContent.toLowerCase().trim();
        const fullName = `${firstName} ${lastName}`;
        const visible = fullName.includes(filterValue);
        row.style.display = visible ? '' : 'none';
    });

    clearFilterBtn.style.display = filterValue ? 'inline' : 'none';
});

clearFilterBtn.addEventListener('click', function () {
    filterInput.value = '';
    filterInput.dispatchEvent(new Event('input'));
});