// ===============================
// DOM Elements
// ===============================
const addBtn = document.getElementById('addBtn');
const addModal = document.getElementById('addModal');
const addBackdrop = document.getElementById('addBackdrop');

const addCategory = document.getElementById('addCategory');
const addSubject = document.getElementById('addSubject');
const addMessage = document.getElementById('addMessage');
const addCreatedAt = document.getElementById('addCreatedAt');
const addCancel = document.getElementById('addCancel');
const addCloseBtn = document.getElementById('addCloseBtn');

const editBtn = document.getElementById('editBtn');
const updateModal = document.getElementById('updateModal');
const updateBackdrop = document.getElementById('updateBackdrop');

const updateCategory = document.getElementById('updateCategory');
const updateSubject = document.getElementById('updateSubject');
const updateMessage = document.getElementById('updateMessage');
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
    addCategory.value = '';
    addSubject.value = '';
    addMessage.value = '';
    addCreatedAt.value = '';
    setTimeout(() => addCategory.focus(), 120);
});

function closeAddModal() {
    addModal.classList.remove('active');
    addBackdrop.classList.remove('active');
}
addCancel.addEventListener('click', closeAddModal);
addCloseBtn.addEventListener('click', closeAddModal);
addBackdrop.addEventListener('click', closeAddModal);

editBtn.addEventListener('click', () => {
    openUpdateModal(); // You can later add logic to get the correct index/data
});

function openUpdateModal() {
    hideAllModals();
    updateModal.classList.add('active');
    updateBackdrop.classList.add('active');
    updateCategory.value = '';
    updateSubject.value = '';
    updateMessage.value = '';
    updateCreatedAt.value = '';
    setTimeout(() => updateCategory.focus(), 120);
}

function closeUpdateModal() {
    updateModal.classList.remove('active');
    updateBackdrop.classList.remove('active');
}
updateCancel.addEventListener('click', closeUpdateModal);
updateCloseBtn.addEventListener('click', closeUpdateModal);
updateBackdrop.addEventListener('click', closeUpdateModal);