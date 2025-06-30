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

const addWorkoutName = document.getElementById('addWorkoutName');
const addEstimatedDuration = document.getElementById('addEstimatedDuration');
const addWorkoutDescription = document.getElementById('addWorkoutDescription');
const addCreatedAt = document.getElementById('addCreatedAt');

const addSubmit = document.getElementById('addSubmit');
const addCancel = document.getElementById('addCancel');
const addCloseBtn = document.getElementById('addCloseBtn');

// Edit Modal Elements
const editBtn = document.getElementById('editBtn');
const updateModal = document.getElementById('updateModal');
const updateBackdrop = document.getElementById('updateBackdrop');

const updateWorkoutName = document.getElementById('updateWorkoutName');
const updateEstimatedDuration = document.getElementById('updateEstimatedDuration');
const updateWorkoutDescription = document.getElementById('updateWorkoutDescription');
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
            row.workoutName.toLowerCase().includes(filterValue)
        )
        : data;

    if (filteredData.length === 0) {
        dataTable.innerHTML = `<tr class="empty-row"><td colspan="13">No data. Add a workout above!</td></tr>`;
    } else {
        filteredData.forEach((row, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="checkbox" class="row-checkbox" data-index="${data.indexOf(row)}" aria-label="Select row ${idx + 1}"></td>
                <td>${row.workoutId || ''}</td>
                <td>${row.userId || ''}</td>
                <td>${row.workoutName || ''}</td>
                <td>${row.estimatedDuration || ''}</td>
                <td>${row.workoutDescription || ''}</td>
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
    addWorkoutName.value = '';
    addEstimatedDuration.value = '';
    addWorkoutDescription.value = '';
    addCreatedAt.value = '';
    addSubmit.dataset.idx = '';
    setTimeout(() => addWorkoutName.focus(), 120);
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
    const workout = data[idx];
    updateWorkoutName.value = workout.workoutName || '';
    updateEstimatedDuration.value = workout.estimatedDuration || '';
    updateWorkoutDescription.value = workout.workoutDescription || '';
    updateCreatedAt.value = workout.createdAt || '';
    updateSubmit.dataset.idx = idx;
    editIndex = idx;
    setTimeout(() => updateWorkoutName.focus(), 120);
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
    const workout = {
        workoutId: (data.length > 0 ? (parseInt(data[data.length - 1].workoutId) + 1).toString() : '1'),
        userId: (data.length > 0 ? (parseInt(data[data.length - 1].userId) + 1).toString() : '1'),
        workoutName: addWorkoutName.value.trim(),
        estimatedDuration: addEstimatedDuration.value.trim(),
        workoutDescription: addWorkoutDescription.value.trim(),
        createdAt: addCreatedAt.value.trim()
    };
    data.push(workout);
    renderTable();
    showToast('Workout added!');
    closeAddModal();
});

updateSubmit.addEventListener('click', e => {
    e.preventDefault();
    const idx = +updateSubmit.dataset.idx;
    const workout = {
        workoutId: data[idx].workoutId,
        userId: data[idx].userId,
        workoutName: updateWorkoutName.value.trim(),
        estimatedDuration: updateEstimatedDuration.value.trim(),
        workoutDescription: updateWorkoutDescription.value.trim(),
        createdAt: updateCreatedAt.value.trim()
    };
    data[idx] = workout;
    renderTable();
    showToast('Workout updated!');
    closeUpdateModal();
});

deleteBtn.addEventListener('click', () => {
    const checked = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => Number(cb.dataset.index));
    if (checked.length > 0) {
        if (window.confirm(`Delete ${checked.length} workout(s)? This action cannot be undone.`)) {
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
    workoutId: '1',
    userId: '1',
    workoutName: 'Morning Yoga',
    estimatedDuration: '30 mins',
    workoutDescription: 'A relaxing morning yoga routine.',
    createdAt: '2023-10-01'
  },
  {
    workoutId: '2',
    userId: '2',
    workoutName: 'Evening Run',
    estimatedDuration: '45 mins',
    workoutDescription: 'A refreshing evening run in the park.',
    createdAt: '2023-10-02'
  }
];
let editIndex = null;