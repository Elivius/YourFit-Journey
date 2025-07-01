// ===============================
// DOM Elements
// ===============================
const addBtn = document.getElementById('addBtn');
const addModal = document.getElementById('addModal');
const addBackdrop = document.getElementById('addBackdrop');

const addMealName = document.getElementById('addMealName');
const addEstimatedPrepMinutes = document.getElementById('addEstimatedPrepMinutes');
const addImageUrl = document.getElementById('addImageUrl');
const addCategory = document.getElementById('addCategory');
const addCreatedAt = document.getElementById('addCreatedAt');

const addCancel = document.getElementById('addCancel');
const addCloseBtn = document.getElementById('addCloseBtn');

const editBtn = document.getElementById('editBtn');
const updateModal = document.getElementById('updateModal');
const updateBackdrop = document.getElementById('updateBackdrop');

const updateMealName = document.getElementById('updateMealName');
const updateEstimatedPrepMinutes = document.getElementById('updateEstimatedPrepMinutes');
const updateImageUrl = document.getElementById('updateImageUrl');
const updateCategory = document.getElementById('updateCategory');
const updateCreatedAt = document.getElementById('updateCreatedAt');

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

addBtn.addEventListener('click', () => {
    hideAllModals();
    addModal.classList.add('active');
    addBackdrop.classList.add('active');
    addMealName.value = '';
    addEstimatedPrepMinutes.value = '';
    addImageUrl.value = '';
    addCategory.value = '';
    addCreatedAt.value = '';
    setTimeout(() => addMealName.focus(), 120);
});

function closeAddModal() {
    addModal.classList.remove('active');
    addBackdrop.classList.remove('active');
}
addCancel.addEventListener('click', closeAddModal);
addCloseBtn.addEventListener('click', closeAddModal);
addBackdrop.addEventListener('click', closeAddModal);

editBtn.addEventListener('click', () => {
    hideAllModals();
    updateModal.classList.add('active');
    updateBackdrop.classList.add('active');
    updateMealName.value = '';
    updateEstimatedPrepMinutes.value = '';
    updateImageUrl.value = '';
    updateCategory.value = '';
    updateCreatedAt.value = '';
    setTimeout(() => updateMealName.focus(), 120);
});

function closeUpdateModal() {
    updateModal.classList.remove('active');
    updateBackdrop.classList.remove('active');
}
updateCancel.addEventListener('click', closeUpdateModal);
updateCloseBtn.addEventListener('click', closeUpdateModal);
updateBackdrop.addEventListener('click', closeUpdateModal);
