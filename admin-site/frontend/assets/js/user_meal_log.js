// ===============================
// DOM Elements
// ===============================
const dataTable = document.getElementById('dataTable');

// Filter Elements
const filterInput = document.getElementById('filterInput');
const clearFilterBtn = document.getElementById('clearFilterBtn');

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
            row.mealName.toLowerCase().includes(filterValue)
        )
        : data;

    if (filteredData.length === 0) {
        dataTable.innerHTML = `<tr class="empty-row"><td colspan="13">No data available!</td></tr>`;
    } else {
        filteredData.forEach((row, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="checkbox" class="row-checkbox" data-index="${data.indexOf(row)}" aria-label="Select row ${idx + 1}"></td>
                <td>${row.userMealLogId || ''}</td>
                <td>${row.userID || ''}</td>
                <td>${row.mealName || ''}</td>
                <td>${row.category || ''}</td>
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

// Initial Render
window.onload = () => renderTable();


// Sample Data
const data = [
  {
    userMealLogId: 1,
    userID: 101,
    mealName: 'Breakfast',
    category: 'Meal',
    protein: 20,
    carbs: 30,
    fats: 10,
    calories: 300,
    createdAt: '2025-06-28 11:08:22'
  }
];
let editIndex = null;