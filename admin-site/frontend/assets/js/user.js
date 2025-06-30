// ===============================
// DOM Elements
// ===============================
const dataTable = document.getElementById('dataTable');
const selectAll = document.getElementById('selectAll');
const toast = document.getElementById('toast');

// Add Modal Elements
const addBtn = document.getElementById('addBtn');
const addModal = document.getElementById('addModal');
const addBackdrop = document.getElementById('addBackdrop');

const addFirstName = document.getElementById('addFirstName');
const addLastName = document.getElementById('addLastName');
const addEmail = document.getElementById('addEmail');
const addPassword = document.getElementById('addPassword');
const addProfilePicture = document.getElementById('addProfilePicture');
const addRole = document.getElementById('addRole');
const addGender = document.getElementById('addGender');
const addWeight = document.getElementById('addWeight');
const addHeight = document.getElementById('addHeight');
const addActivityLevel = document.getElementById('addActivityLevel');
const addGoal = document.getElementById('addGoal');
const addCreatedAt = document.getElementById('addCreatedAt');

const addSubmit = document.getElementById('addSubmit');
const addCancel = document.getElementById('addCancel');
const addCloseBtn = document.getElementById('addCloseBtn');

// Edit Modal Elements
const editBtn = document.getElementById('editBtn');
const updateModal = document.getElementById('updateModal');
const updateBackdrop = document.getElementById('updateBackdrop');

const updateFirstName = document.getElementById('updateFirstName');
const updateLastName = document.getElementById('updateLastName');
const updateEmail = document.getElementById('updateEmail');
const updatePassword = document.getElementById('updatePassword');
const updateProfilePicture = document.getElementById('updateProfilePicture');
const updateRole = document.getElementById('updateRole');
const updateGender = document.getElementById('updateGender');
const updateWeight = document.getElementById('updateWeight');
const updateHeight = document.getElementById('updateHeight');
const updateActivityLevel = document.getElementById('updateActivityLevel');
const updateGoal = document.getElementById('updateGoal');
const updateCreatedAt = document.getElementById('updateCreatedAt');

const updateSubmit = document.getElementById('updateSubmit');
const updateCancel = document.getElementById('updateCancel');
const updateCloseBtn = document.getElementById('updateCloseBtn');

// Filter Elements
const filterInput = document.getElementById('filterInput');
const clearFilterBtn = document.getElementById('clearFilterBtn');

// Delete Button
const deleteBtn = document.getElementById('deleteBtn');

// ===============================
// Filter Logic
// ===============================
filterInput.addEventListener('input', () => {
    renderTable();
    clearFilterBtn.style.display = filterInput.value ? 'block' : 'none';
    filterInput.style.borderColor = filterInput.value ? '#6c63ff' : '#d1d7fa';
    filterInput.style.boxShadow = filterInput.value ? '0 0 0 2px #ececff' : 'none';
});

filterInput.addEventListener('focus', () => {
    filterInput.style.borderColor = '#6c63ff';
    filterInput.style.boxShadow = '0 0 0 2px #ececff';
});

filterInput.addEventListener('blur', () => {
    filterInput.style.borderColor = filterInput.value ? '#6c63ff' : '#d1d7fa';
    filterInput.style.boxShadow = 'none';
});

clearFilterBtn.addEventListener('click', () => {
    filterInput.value = '';
    filterInput.focus();
    clearFilterBtn.style.display = 'none';
    filterInput.style.borderColor = '#d1d7fa';
    filterInput.style.boxShadow = 'none';
    renderTable();
});

// ===============================
// Table Rendering
// ===============================
function renderTable() {
    dataTable.innerHTML = '';
    const filterValue = filterInput.value.trim().toLowerCase();
    const filteredData = filterValue
        ? data.filter(row =>
            row.firstName.toLowerCase().includes(filterValue) ||
            row.lastName.toLowerCase().includes(filterValue) ||
            row.email.toLowerCase().includes(filterValue)
        )
        : data;

    if (filteredData.length === 0) {
        dataTable.innerHTML = `<tr class="empty-row"><td colspan="13">No data. Add a user above!</td></tr>`;
    } else {
        filteredData.forEach((row, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="checkbox" class="row-checkbox" data-index="${data.indexOf(row)}" aria-label="Select row ${idx + 1}"></td>
                <td>${row.userId || ''}</td>
                <td>${row.firstName || ''}</td>
                <td>${row.lastName || ''}</td>
                <td>${row.email || ''}</td>
                <td>${row.password || ''}</td>
                <td>${row.profilePicture || ''}</td>
                <td>${row.role || ''}</td>
                <td>${row.gender || ''}</td>
                <td>${row.weight || ''}</td>
                <td>${row.height || ''}</td>
                <td>${row.activityLevel || ''}</td>
                <td>${row.goal || ''}</td>
                <td>${row.createdAt || ''}</td>
            `;
            dataTable.appendChild(tr);
        });
    }
    updateButtons();
}

function updateButtons() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const checked = Array.from(checkboxes).filter(cb => cb.checked);
    editBtn.disabled = checked.length !== 1;
    deleteBtn.disabled = checked.length === 0;
    checkboxes.forEach(cb => {
        cb.closest('tr').classList.toggle('selected', cb.checked);
    });
    selectAll.checked = checkboxes.length > 0 && checked.length === checkboxes.length;
    selectAll.indeterminate = checked.length > 0 && checked.length < checkboxes.length;
}

// ===============================
// Selection Logic
// ===============================
dataTable.addEventListener('change', e => {
    if (e.target.classList.contains('row-checkbox')) updateButtons();
});

selectAll.addEventListener('change', () => {
    const checked = selectAll.checked;
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = checked);
    updateButtons();
});

// ===============================
// Modal Management
// ===============================
function hideAllModals() {
    addModal.classList.remove('active');
    addBackdrop.classList.remove('active');
    updateModal.classList.remove('active');
    updateBackdrop.classList.remove('active');
}

addBtn.addEventListener('click', () => {
    hideAllModals();
    addModal.classList.add('active');
    addBackdrop.classList.add('active');
    addFirstName.value = '';
    addLastName.value = '';
    addEmail.value = '';
    addPassword.value = '';
    addProfilePicture.value = '';
    addRole.value = '';
    addGender.value = '';
    addWeight.value = '';
    addHeight.value = '';
    addActivityLevel.value = '';
    addGoal.value = '';
    addCreatedAt.value = '';
    addSubmit.dataset.idx = '';
    setTimeout(() => addFirstName.focus(), 120);
});

function closeAddModal() {
    addModal.classList.remove('active');
    addBackdrop.classList.remove('active');
}
addCancel.addEventListener('click', closeAddModal);
addCloseBtn.addEventListener('click', closeAddModal);
addBackdrop.addEventListener('click', closeAddModal);

editBtn.addEventListener('click', () => {
    const checked = document.querySelectorAll('.row-checkbox:checked');
    if (checked.length === 1) openUpdateModal(checked[0].dataset.index);
});

function openUpdateModal(idx) {
    hideAllModals();
    updateModal.classList.add('active');
    updateBackdrop.classList.add('active');
    const user = data[idx];
    updateFirstName.value = user.firstName || '';
    updateLastName.value = user.lastName || '';
    updateEmail.value = user.email || '';
    updatePassword.value = user.password || '';
    updateRole.value = user.role || '';
    updateProfilePicture.value = user.profilePicture || '';
    updateGender.value = user.gender || '';
    updateWeight.value = user.weight || '';
    updateHeight.value = user.height || '';
    updateActivityLevel.value = user.activityLevel || '';
    updateGoal.value = user.goal || '';
    updateCreatedAt.value = user.createdAt || '';
    updateSubmit.dataset.idx = idx;
    editIndex = idx;
    setTimeout(() => updateFirstName.focus(), 120);
}

function closeUpdateModal() {
    updateModal.classList.remove('active');
    updateBackdrop.classList.remove('active');
    editIndex = null;
}
updateCancel.addEventListener('click', closeUpdateModal);
updateCloseBtn.addEventListener('click', closeUpdateModal);
updateBackdrop.addEventListener('click', closeUpdateModal);

// ===============================
// Add, Update, Delete Events
// ===============================
addSubmit.addEventListener('click', e => {
    e.preventDefault();
    const user = {
        userId: (data.length > 0 ? (parseInt(data[data.length - 1].userId) + 1).toString() : '1'),
        firstName: addFirstName.value.trim(),
        lastName: addLastName.value.trim(),
        email: addEmail.value.trim(),
        password: addPassword.value.trim(),
        profilePicture: addProfilePicture.value.trim(),
        role: addRole.value.trim(),
        gender: addGender.value.trim(),
        weight: addWeight.value.trim(),
        height: addHeight.value.trim(),
        activityLevel: addActivityLevel.value.trim(),
        goal: addGoal.value.trim(),
        createdAt: addCreatedAt.value.trim()
    };
    data.push(user);
    renderTable();
    showToast('User added!');
    closeAddModal();
});

updateSubmit.addEventListener('click', e => {
    e.preventDefault();
    const idx = +updateSubmit.dataset.idx;
    const user = {
        userId: data[idx].userId,
        firstName: updateFirstName.value.trim(),
        lastName: updateLastName.value.trim(),
        email: updateEmail.value.trim(),
        password: updatePassword.value.trim(),
        profilePicture: updateProfilePicture.value.trim(),
        role: updateRole.value.trim(),
        gender: updateGender.value.trim(),
        weight: updateWeight.value.trim(),
        height: updateHeight.value.trim(),
        activityLevel: updateActivityLevel.value.trim(),
        goal: updateGoal.value.trim(),
        createdAt: updateCreatedAt.value.trim()
    };
    data[idx] = user;
    renderTable();
    showToast('User updated!');
    closeUpdateModal();
});

deleteBtn.addEventListener('click', () => {
    const checked = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => Number(cb.dataset.index));
    if (checked.length > 0) {
        if (window.confirm(`Delete ${checked.length} user(s)? This action cannot be undone.`)) {
        checked.sort((a, b) => b - a).forEach(idx => data.splice(idx, 1));
        renderTable();
        showToast('Deleted successfully.', 'danger');
        }
    }
});

// ===============================
// Toast Notification
// ===============================
function showToast(msg, type = 'info') {
    toast.textContent = msg;
    toast.style.background =
        type === 'danger'
        ? 'linear-gradient(90deg,#ff6584 60%,#e84663 100%)'
        : type === 'warn'
        ? 'linear-gradient(90deg,#43e97b 60%,#ffa000 100%)'
        : 'linear-gradient(90deg,#6c63ff 60%,#43e97b 100%)';
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2000);
}

// Initial Render
window.onload = () => renderTable();


// Sample Data
const data = [
  {
    userId: '1',
    firstName: 'Elivius',
    lastName: 'Vert',
    email: 'elivius@elivius.de',
    password: '$2y$10$pr.DU6icq6bYiyzuJeEJIumWYDLSY0G8xg0PEek1IIdN19Asuv1Ve',
    profilePicture: 'pfp_1_1751187520.jpg',
    role: 'user',
    gender: 'male',
    weight: 65.3,
    height: 165,
    activityLevel: 'active',
    goal: 'bulking',
    createdAt: '2025-06-28 11:08:22'
  }
];
let editIndex = null;