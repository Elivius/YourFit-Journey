// ===============================
// DOM Elements
// ===============================
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

// ===============================
// Modal Management
// ===============================
function hideAllModals() {
    addModal.classList.remove('active');
    addBackdrop.classList.remove('active');
    updateModal.classList.remove('active');
    updateBackdrop.classList.remove('active');
}

// Open Add Modal
addBtn.addEventListener('click', () => {
    hideAllModals();
    addModal.classList.add('active');
    addBackdrop.classList.add('active');
    addWorkoutName.value = '';
    addEstimatedDuration.value = '';
    addWorkoutDescription.value = '';
    addCreatedAt.value = '';
    setTimeout(() => addWorkoutName.focus(), 120);
});

// Close Add Modal
function closeAddModal() {
    addModal.classList.remove('active');
    addBackdrop.classList.remove('active');
}
addCancel.addEventListener('click', closeAddModal);
addCloseBtn.addEventListener('click', closeAddModal);
addBackdrop.addEventListener('click', closeAddModal);

// Open Update Modal
editBtn.addEventListener('click', () => {
    hideAllModals();
    updateModal.classList.add('active');
    updateBackdrop.classList.add('active');
    updateWorkoutName.value = '';
    updateEstimatedDuration.value = '';
    updateWorkoutDescription.value = '';
    updateCreatedAt.value = '';
    setTimeout(() => updateWorkoutName.focus(), 120);
});

// Close Update Modal
function closeUpdateModal() {
    updateModal.classList.remove('active');
    updateBackdrop.classList.remove('active');
}
updateCancel.addEventListener('click', closeUpdateModal);
updateCloseBtn.addEventListener('click', closeUpdateModal);
updateBackdrop.addEventListener('click', closeUpdateModal);
