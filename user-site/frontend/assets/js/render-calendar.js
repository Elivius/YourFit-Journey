const calendarContainer = document.querySelector(".calendar-placeholder");
let currentDate = new Date();
let workoutDates = [];

async function loadWorkoutDates() {
    const res = await fetch("../backend/preload_workout_dates.php");
    workoutDates = await res.json();
}

function renderCalendar(date = new Date()) {
    const year = date.getFullYear();
    const month = date.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const prevMonthLastDate = new Date(year, month, 0).getDate();
    const startDay = firstDay.getDay();
    const today = new Date();

    const days = [];

    // Previous month's tail
    for (let i = startDay - 1; i >= 0; i--) {
        days.push(`<td class="inactive">${prevMonthLastDate - i}</td>`);
    }

    // Current month days
    for (let i = 1; i <= lastDay.getDate(); i++) {
        const current = new Date(year, month, i);
        const isoDate = current.toLocaleDateString('en-CA');
        const isToday = current.toDateString() === today.toDateString();
        const hasWorkout = workoutDates.includes(isoDate);

        const classes = [
            isToday ? "active today" : "",
            hasWorkout ? "has-workout" : ""
        ].join(" ").trim();

        days.push(`<td class="${classes}">${i}</td>`);
    }

    // Next month's head
    while (days.length % 7 !== 0) {
        days.push(`<td class="inactive">${days.length - lastDay.getDate() - startDay + 1}</td>`);
    }

    // Break into weeks
    const weeks = [];
    for (let i = 0; i < days.length; i += 7) {
        weeks.push(`<tr>${days.slice(i, i + 7).join("")}</tr>`);
    }

    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    calendarContainer.innerHTML = `
        <div class="calendar-header">
            <button class="btn btn-sm btn-icon" id="prevMonth"><i class="fas fa-chevron-left"></i></button>
            <h6>${monthNames[month]} ${year}</h6>
            <button class="btn btn-sm btn-icon" id="nextMonth"><i class="fas fa-chevron-right"></i></button>
        </div>
        <table class="calendar-table">
            <thead>
                <tr>
                    <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th>
                    <th>Thu</th><th>Fri</th><th>Sat</th>
                </tr>
            </thead>
            <tbody>${weeks.join("")}</tbody>
        </table>
    `;

    // Navigation
    document.getElementById("prevMonth").onclick = () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    };

    document.getElementById("nextMonth").onclick = () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    };
}

// Load workout data and render
loadWorkoutDates().then(() => renderCalendar(currentDate));
