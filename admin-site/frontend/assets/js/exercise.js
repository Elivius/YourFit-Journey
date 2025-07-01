// ===============================
// DOM Elements
// ===============================
const addBtn = document.getElementById('addBtn');
const addModal = document.getElementById('addModal');
const addBackdrop = document.getElementById('addBackdrop');
const addExerciseName = document.getElementById('addExerciseName');
const addImageUrl = document.getElementById('addImageUrl');
const addCategory = document.getElementById('addCategory');
const addTargetMuscle = document.getElementById('addTargetMuscle');
const addInstructions = document.getElementById('addInstructions');
const addSets = document.getElementById('addSets');
const addReps = document.getElementById('addReps');
const addRest = document.getElementById('addRest');
const addCreatedAt = document.getElementById('addCreatedAt');
const addCancel = document.getElementById('addCancel');
const addCloseBtn = document.getElementById('addCloseBtn');

const editBtn = document.getElementById('editBtn');
const updateModal = document.getElementById('updateModal');
const updateBackdrop = document.getElementById('updateBackdrop');
const updateExerciseName = document.getElementById('updateExerciseName');
const updateImageUrl = document.getElementById('updateImageUrl');
const updateCategory = document.getElementById('updateCategory');
const updateTargetMuscle = document.getElementById('updateTargetMuscle');
const updateInstructions = document.getElementById('updateInstructions');
const updateSets = document.getElementById('updateSets');
const updateReps = document.getElementById('updateReps');
const updateRest = document.getElementById('updateRest');
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
    addExerciseName.value = '';
    addImageUrl.value = '';
    addCategory.value = '';
    addTargetMuscle.value = '';
    addInstructions.value = '';
    addSets.value = '';
    addReps.value = '';
    addRest.value = '';
    addCreatedAt.value = '';
    setTimeout(() => addExerciseName.focus(), 120);
});

function closeAddModal() {
    addModal.classList.remove('active');
    addBackdrop.classList.remove('active');
}
addCancel.addEventListener('click', closeAddModal);
addCloseBtn.addEventListener('click', closeAddModal);
addBackdrop.addEventListener('click', closeAddModal);

editBtn.addEventListener('click', () => {
    // Placeholder: You can call openUpdateModal(index) with the right index later
    openUpdateModal(0); // Using 0 just for demo
});

function openUpdateModal(idx) {
    hideAllModals();
    updateModal.classList.add('active');
    updateBackdrop.classList.add('active');
    updateExerciseName.value = '';
    updateImageUrl.value = '';
    updateCategory.value = '';
    updateTargetMuscle.value = '';
    updateInstructions.value = '';
    updateSets.value = '';
    updateReps.value = '';
    updateRest.value = '';
    updateCreatedAt.value = '';
    setTimeout(() => updateExerciseName.focus(), 120);
}

function closeUpdateModal() {
    updateModal.classList.remove('active');
    updateBackdrop.classList.remove('active');
}
updateCancel.addEventListener('click', closeUpdateModal);
updateCloseBtn.addEventListener('click', closeUpdateModal);
updateBackdrop.addEventListener('click', closeUpdateModal);
