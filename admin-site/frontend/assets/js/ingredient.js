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

const addname = document.getElementById('addName');
const addProtein = document.getElementById('addProtein');
const addCarbs = document.getElementById('addCarbs');
const addFats = document.getElementById('addFats');
const addCalories = document.getElementById('addCalories');
const addCreatedAt = document.getElementById('addCreatedAt');

const addSubmit = document.getElementById('addSubmit');
const addCancel = document.getElementById('addCancel');
const addCloseBtn = document.getElementById('addCloseBtn');

// Edit Modal Elements
const editBtn = document.getElementById('editBtn');
const updateModal = document.getElementById('updateModal');
const updateBackdrop = document.getElementById('updateBackdrop');

const updateName = document.getElementById('updateName');
const updateProtein = document.getElementById('updateProtein');
const updateCarbs = document.getElementById('updateCarbs');
const updateFats = document.getElementById('updateFats');
const updateCalories = document.getElementById('updateCalories');
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
            row.name.toLowerCase().includes(filterValue)
        )
        : data;

    if (filteredData.length === 0) {
        dataTable.innerHTML = `<tr class="empty-row"><td colspan="13">No data. Add a ingredients above!</td></tr>`;
    } else {
        filteredData.forEach((row, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="checkbox" class="row-checkbox" data-index="${data.indexOf(row)}" aria-label="Select row ${idx + 1}"></td>
                <td>${row.ingredientId || ''}</td>
                <td>${row.name || ''}</td>
                <td>${row.protein || ''}</td>
                <td>${row.carbs || ''}</td>
                <td>${row.fats || ''}</td>
                <td>${row.calories || ''}</td>
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
    addname.value = '';
    addProtein.value = '';
    addCarbs.value = '';
    addFats.value = '';
    addCalories.value = '';
    addCreatedAt.value = '';
    addSubmit.dataset.idx = '';
    setTimeout(() => addName.focus(), 120);
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
    const ingredient = data[idx];
    updateName.value = ingredient.name || '';
    updateProtein.value = ingredient.protein || '';
    updateCarbs.value = ingredient.carbs || '';
    updateFats.value = ingredient.fats || '';
    updateCalories.value = ingredient.calories || '';
    updateCreatedAt.value = ingredient.createdAt || '';
    updateSubmit.dataset.idx = idx;
    editIndex = idx;
    setTimeout(() => updateName.focus(), 120);
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
    const ingredient = {
        ingredientId: (data.length > 0 ? (parseInt(data[data.length - 1].ingredientId) + 1).toString() : '1'),
        name: addname.value.trim(),
        protein: addProtein.value.trim(),
        carbs: addCarbs.value.trim(),
        fats: addFats.value.trim(),
        calories: addCalories.value.trim(),
        createdAt: addCreatedAt.value.trim()
    };
    data.push(ingredient);
    renderTable();
    showToast('Ingredients added!');
    closeAddModal();
});

updateSubmit.addEventListener('click', e => {
    e.preventDefault();
    const idx = +updateSubmit.dataset.idx;
    const ingredient = {
        ingredientId: data[idx].ingredientId,
        name: updateName.value.trim(),
        protein: updateProtein.value.trim(),
        carbs: updateCarbs.value.trim(),
        fats: updateFats.value.trim(),
        calories: updateCalories.value.trim(),
        createdAt: updateCreatedAt.value.trim()
    };
    data[idx] = ingredient;
    renderTable();
    showToast('ngredient updated!');
    closeUpdateModal();
});

deleteBtn.addEventListener('click', () => {
    const checked = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => Number(cb.dataset.index));
    if (checked.length > 0) {
        if (window.confirm(`Delete ${checked.length} Ingredient(s)? This action cannot be undone.`)) {
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
    ingredientId: '1',
    name: 'Pistachios',
    protein: '20.2',
    carbs: '27.5',
    fats: '45.4',
    calories: '562',
    createdAt: '2025-06-22 18:17:56'
  }
];
let editIndex = null;