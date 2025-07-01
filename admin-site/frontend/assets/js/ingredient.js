// ===============================
// DOM Elements
// ===============================
const addBtn = document.getElementById('addBtn');
const addModal = document.getElementById('addModal');
const addBackdrop = document.getElementById('addBackdrop');

const addname = document.getElementById('addName');
const addProtein = document.getElementById('addProtein');
const addCarbs = document.getElementById('addCarbs');
const addFats = document.getElementById('addFats');
const addCalories = document.getElementById('addCalories');
const addCreatedAt = document.getElementById('addCreatedAt');
const addCancel = document.getElementById('addCancel');
const addCloseBtn = document.getElementById('addCloseBtn');

const editBtn = document.getElementById('editBtn');
const updateModal = document.getElementById('updateModal');
const updateBackdrop = document.getElementById('updateBackdrop');

const updateName = document.getElementById('updateName');
const updateProtein = document.getElementById('updateProtein');
const updateCarbs = document.getElementById('updateCarbs');
const updateFats = document.getElementById('updateFats');
const updateCalories = document.getElementById('updateCalories');
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
    addname.value = '';
    addProtein.value = '';
    addCarbs.value = '';
    addFats.value = '';
    addCalories.value = '';
    addCreatedAt.value = '';
    setTimeout(() => addname.focus(), 120);
});

function closeAddModal() {
    addModal.classList.remove('active');
    addBackdrop.classList.remove('active');
}
addCancel.addEventListener('click', closeAddModal);
addCloseBtn.addEventListener('click', closeAddModal);
addBackdrop.addEventListener('click', closeAddModal);

editBtn.addEventListener('click', () => {
    openUpdateModal(); // Placeholder for now
});

function openUpdateModal() {
    hideAllModals();
    updateModal.classList.add('active');
    updateBackdrop.classList.add('active');
    updateName.value = '';
    updateProtein.value = '';
    updateCarbs.value = '';
    updateFats.value = '';
    updateCalories.value = '';
    updateCreatedAt.value = '';
    setTimeout(() => updateName.focus(), 120);
}

function closeUpdateModal() {
    updateModal.classList.remove('active');
    updateBackdrop.classList.remove('active');
}
updateCancel.addEventListener('click', closeUpdateModal);
updateCloseBtn.addEventListener('click', closeUpdateModal);
updateBackdrop.addEventListener('click', closeUpdateModal);