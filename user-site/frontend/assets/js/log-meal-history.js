let justOpenedHistory = false;

async function openMealHistoryModal() {
    const modal = document.getElementById("mealHistoryModal");
    const content = document.getElementById("mealHistoryContent");
    const backdrop = document.getElementById("modalBackdrop");

    // Show modal and backdrop
    modal.classList.add("show");
    backdrop.classList.add("show");

    // Prevent immediate close on outside click
    justOpenedHistory = true;
    setTimeout(() => {
        justOpenedHistory = false;
    }, 100);

    // Show loading
    content.innerHTML = "<p>Loading...</p>";

    try {
        const res = await fetch("../backend/load_meal_history.php");
        const data = await res.json();

        if (!Array.isArray(data) || data.length === 0) {
            content.innerHTML = "<p>No meal history found.</p>";
            return;
        }

        // Render history
        content.innerHTML = data.map(meal => {
            const date = formatDateTime(meal.uml_created_at);
            return `
                <div class="modal-history card p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-1">${meal.uml_meal_name}</h6>
                            <span class="badge bg-primary mb-1">${meal.uml_category.charAt(0).toUpperCase() + meal.uml_category.slice(1)}</span>
                        </div>
                        <small class="muted-p">${date}</small>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="macro-pill protein"><strong>${meal.uml_protein_g.toFixed(1)}g</strong> Protein</div>
                        <div class="macro-pill carbs"><strong>${meal.uml_carbs_g.toFixed(1)}g</strong> Carbs</div>
                        <div class="macro-pill fats"><strong>${meal.uml_fats_g.toFixed(1)}g</strong> Fats</div>
                        <div class="macro-pill calories"><strong>${meal.uml_calories.toFixed(1)}</strong> kcal</div>
                    </div>
                </div>
            `;
        }).join("");
    } catch (err) {
        console.error("Failed to load meal history:", err);
        content.innerHTML = "<p>Error loading meal history.</p>";
    }
}

function closeMealHistoryModal() {
    document.getElementById("mealHistoryModal").classList.remove("show");
    document.getElementById("modalBackdrop").classList.remove("show");
}

// Close if clicked outside
document.addEventListener("click", function (e) {
    if (justOpenedHistory) return;

    const modal = document.getElementById("mealHistoryModal");
    const content = modal?.querySelector(".modal-content");

    if (modal?.classList.contains("show") && !content?.contains(e.target)) {
        closeMealHistoryModal();
    }
});

function formatDateTime(isoString) {
    const d = new Date(isoString);
    return d.toLocaleString(undefined, {
        year: 'numeric', month: 'short', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
}

document.getElementById("mealHistoryBtn").addEventListener("click", openMealHistoryModal);
