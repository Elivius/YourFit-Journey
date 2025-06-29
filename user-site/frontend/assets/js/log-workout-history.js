let justOpenedWorkoutHistory = false;

async function openWorkoutHistoryModal() {
    const modal = document.getElementById("workoutHistoryModal");
    const content = document.getElementById("workoutHistoryContent");
    const backdrop = document.getElementById("modalBackdrop");

    modal.classList.add("show");
    backdrop.classList.add("show");

    justOpenedWorkoutHistory = true;
    setTimeout(() => {
        justOpenedWorkoutHistory = false;
    }, 100);

    content.innerHTML = "<p>Loading...</p>";

    try {
        const res = await fetch("../backend/preload_workout_logs.php");
        const data = await res.json();

        if (!Array.isArray(data) || data.length === 0) {
            content.innerHTML = "<p>No workout history found.</p>";
            return;
        }

        content.innerHTML = data.map(workout => {
            return `
                <div class="modal-history card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">${workout.workout_name}</h6>
                        <small class="muted-p">${workout.date}</small>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="workout-pill time"><strong><i class="fas fa-clock me-1"></i> ${workout.duration}</strong></div>
                        <div class="workout-pill exercise"><strong><i class="fas fa-dumbbell me-1"></i> ${workout.exercise_count}</strong></div>
                    </div>
                </div>
            `;
        }).join("");
    } catch (err) {
        console.error("Failed to load workout history:", err);
        content.innerHTML = "<p>Error loading workout history.</p>";
    }
}

function closeWorkoutHistoryModal() {
    document.getElementById("workoutHistoryModal").classList.remove("show");
    document.getElementById("modalBackdrop").classList.remove("show");
}

document.addEventListener("click", function (e) {
    if (justOpenedWorkoutHistory) return;

    const modal = document.getElementById("workoutHistoryModal");
    const content = modal?.querySelector(".modal-content");

    if (modal?.classList.contains("show") && !content?.contains(e.target)) {
        closeWorkoutHistoryModal();
    }
});

document.getElementById("workoutHistoryBtn").addEventListener("click", openWorkoutHistoryModal);