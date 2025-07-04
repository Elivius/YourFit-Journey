const filterInput = document.getElementById('filterInput');
const clearFilterBtn = document.getElementById('clearFilterBtn');
const dataTable = document.getElementById('dataTable');

filterInput.addEventListener('input', function () {
    const filterValue = this.value.toLowerCase();
    const rows = dataTable.getElementsByTagName('tr');

    Array.from(rows).forEach(row => {
        const workoutName = row.cells[2].textContent.toLowerCase().trim(); // Workout Log
        const visible = workoutName.includes(filterValue);
        row.style.display = visible ? '' : 'none';
    });

    clearFilterBtn.style.display = filterValue ? 'inline' : 'none';
});

clearFilterBtn.addEventListener('click', function () {
    filterInput.value = '';
    filterInput.dispatchEvent(new Event('input'));
});