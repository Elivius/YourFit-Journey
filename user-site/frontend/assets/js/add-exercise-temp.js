let selectedExercises = JSON.parse(localStorage.getItem("selectedExercises") || "[]");
let hasRenderedOnce = false;

document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".add-exercise-btn");
    const accordionContainer = document.getElementById("selectedExercises");

    renderExercises();

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("data-id");
            const name = button.getAttribute("data-name");
            const muscles = button.getAttribute("data-target-muscles");

            if (selectedExercises.some(e => e.id === id)) {
                alert("Exercise already added!");
                return;
            }

            selectedExercises.push({ id, name, muscles });
            localStorage.setItem("selectedExercises", JSON.stringify(selectedExercises));
            renderExercises();
        });
    });

    function renderExercises() {
        accordionContainer.innerHTML = "";

        if (selectedExercises.length === 0) {
            accordionContainer.innerHTML = '<p class="muted-p ms-2">No exercises added yet.</p>';
            return;
        }

        selectedExercises.forEach((ex, index) => {
            const headingId = `exercise${ex.id}Heading`;
            const collapseId = `exercise${ex.id}Collapse`;

            const isFirstAndFirstRender = index === 0 && !hasRenderedOnce;

            const accordionItem = document.createElement("div");
            accordionItem.className = "accordion-item";

            accordionItem.innerHTML = `
                <h2 class="accordion-header" id="${headingId}">
                    <button class="accordion-button ${isFirstAndFirstRender ? '' : 'collapsed'}" type="button"
                        data-bs-toggle="collapse" data-bs-target="#${collapseId}"
                        aria-expanded="${isFirstAndFirstRender}" aria-controls="${collapseId}">
                        <div class="exercise-header">
                            <span class="exercise-number">${index + 1}</span>
                            <div class="exercise-title">
                                <h6>${ex.name}</h6>
                                <span class="exercise-target muted-p">Target: ${ex.muscles}</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </button>
                </h2>
                <div id="${collapseId}" class="accordion-collapse collapse ${isFirstAndFirstRender ? 'show' : ''}"
                    aria-labelledby="${headingId}">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="exercise-parameters">
                                    <div class="parameter">
                                        <span class="parameter-label">Sets:</span>
                                        <span class="parameter-value">
                                            <input type="number" class="form-control form-control-sm" value="3" min="1">
                                        </span>
                                    </div>
                                    <div class="parameter">
                                        <span class="parameter-label">Reps:</span>
                                        <span class="parameter-value">
                                            <input type="text" class="form-control form-control-sm" value="10-12">
                                        </span>
                                    </div>
                                    <div class="parameter">
                                        <span class="parameter-label">Rest:</span>
                                        <span class="parameter-value">
                                            <input type="number" class="form-control form-control-sm" value="60" min="0"> sec
                                        </span>
                                    </div>
                                    <div class="parameter">
                                        <span class="parameter-label">Weight:</span>
                                        <span class="parameter-value">
                                            <input type="text" class="form-control form-control-sm" placeholder="Optional">
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label">Notes:</label>
                                    <textarea class="form-control" rows="2" placeholder="Add notes for this exercise..."></textarea>
                                </div>
                                <div class="mt-3 text-end">
                                    <button class="btn btn-danger btn-sm remove-exercise-btn" data-id="${ex.id}">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            accordionContainer.appendChild(accordionItem);
        });

        // Only first render should expand the first one
        hasRenderedOnce = true;

        document.querySelectorAll(".remove-exercise-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                const idToRemove = btn.getAttribute("data-id");
                selectedExercises = selectedExercises.filter(e => e.id !== idToRemove);
                localStorage.setItem("selectedExercises", JSON.stringify(selectedExercises));
                renderExercises();
            });
        });
    }

    document.getElementById("remove-all-btn").addEventListener("click", () => {
        if (confirm("Are you sure you want to remove all selected exercises?")) {
            selectedExercises = [];
            localStorage.removeItem("selectedExercises");
            renderExercises(); // Call your existing render function
        }
    });
});
