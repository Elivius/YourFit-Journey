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

const addBaseGrams = document.getElementById('addBaseGrams');
const addCreatedAt = document.getElementById('addCreatedAt');

const addSubmit = document.getElementById('addSubmit');
const addCancel = document.getElementById('addCancel');
const addCloseBtn = document.getElementById('addCloseBtn');

// Edit Modal Elements
const editBtn = document.getElementById('editBtn');
const updateModal = document.getElementById('updateModal');
const updateBackdrop = document.getElementById('updateBackdrop');

const updateBaseGrams = document.getElementById('updateBaseGrams');
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
            row.baseGrams.toLowerCase().includes(filterValue)
        )
        : data;

    if (filteredData.length === 0) {
        dataTable.innerHTML = `<tr class="empty-row"><td colspan="13">No data. Add a meal and ingredient above!</td></tr>`;
    } else {
        filteredData.forEach((row, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="checkbox" class="row-checkbox" data-index="${data.indexOf(row)}" aria-label="Select row ${idx + 1}"></td>
                <td>${row.mealIngredientId || ''}</td>
                <td>${row.mealId || ''}</td>
                <td>${row.ingredientId || ''}</td>
                <td>${row.baseGrams || ''}</td>
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
    addBaseGrams.value = '';
    addCreatedAt.value = '';
    addSubmit.dataset.idx = '';
    setTimeout(() => addBaseGrams.focus(), 120);
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
    const mealIngredient = data[idx];
    updateBaseGrams.value = mealIngredient.baseGrams || '';
    updateCreatedAt.value = mealIngredient.createdAt || '';
    updateSubmit.dataset.idx = idx;
    editIndex = idx;
    setTimeout(() => updateBaseGrams.focus(), 120);
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
    const mealIngredient = {
        mealIngredientId: (data.length > 0 ? (parseInt(data[data.length - 1].mealIngredientId) + 1).toString() : '1'),
        mealId: (data.length > 0 ? (parseInt(data[data.length - 1].mealId) + 1).toString() : '1'),
        ingredientId: (data.length > 0 ? (parseInt(data[data.length - 1].ingredientId) + 1).toString() : '1'),
        baseGrams: addBaseGrams.value.trim(),
        createdAt: addCreatedAt.value.trim()
    };
    data.push(mealIngredient);
    renderTable();
    showToast('Meal and Ingredient added!');
    closeAddModal();
});

updateSubmit.addEventListener('click', e => {
    e.preventDefault();
    const idx = +updateSubmit.dataset.idx;
    const mealIngredient = {
        mealIngredientId: data[idx].mealIngredientId,
        mealId: data[idx].mealId,
        ingredientId: data[idx].ingredientId,
        baseGrams: updateBaseGrams.value.trim(),
        createdAt: updateCreatedAt.value.trim()
    };
    data[idx] = mealIngredient;
    renderTable();
    showToast('Meal and Ingredient updated!');
    closeUpdateModal();
});

deleteBtn.addEventListener('click', () => {
    const checked = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => Number(cb.dataset.index));
    if (checked.length > 0) {
        if (window.confirm(`Delete ${checked.length} meal and ingredient(s)? This action cannot be undone.`)) {
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
    mealIngredientId: '116',
    mealId: '42',
    ingredientId: '7',
    baseGrams: '100',
    createdAt: '2025-06-22 18:35:43'
  },
];
let editIndex = null;