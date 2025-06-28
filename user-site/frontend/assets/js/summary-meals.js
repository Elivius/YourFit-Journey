document.addEventListener("DOMContentLoaded", () => {
    const dateDisplay = document.getElementById("current-date");
    const prevBtn = document.getElementById("prev-date");
    const nextBtn = document.getElementById("next-date");
    const macronutrientChartCanvas = document.getElementById('macronutrientChart');
    let macroChart = null;
    let currentDate = new Date();

    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }

    function formatDisplayDate(date) {
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }

    function updateDateDisplay() {
        dateDisplay.textContent = formatDisplayDate(currentDate);
    }

    async function loadMealSummary() {
        const formattedDate = formatDate(currentDate);
        try {
            const res = await fetch(`../backend/preload_meal_summary.php?date=${formattedDate}`);
            const data = await res.json();

            if (data.error) {
                alert(data.error);
                return;
            }

            const consumed = data.consumed;
            const goal = data.goal;
            const calorieDiff = goal.calories - consumed.calories;

            // Update text
            document.getElementById("calories-summary").innerText = `${consumed.calories.toFixed(1)} / ${goal.calories.toFixed(1)} kcal`;
            document.getElementById("calories-remaining").innerText =
                calorieDiff >= 0
                    ? `${calorieDiff.toFixed(1)} calories remaining`
                    : `Over ${Math.abs(calorieDiff).toFixed(1)} kcal`;
            document.getElementById("protein-summary").innerText = `${consumed.protein.toFixed(1)}g / ${goal.protein_g.toFixed(1)}g`;
            document.getElementById("carbs-summary").innerText = `${consumed.carbs.toFixed(1)}g / ${goal.carbs_g.toFixed(1)}g`;
            document.getElementById("fats-summary").innerText = `${consumed.fats.toFixed(1)}g / ${goal.fats_g.toFixed(1)}g`;

            // Update progress bars
            document.getElementById("calories-bar").style.width = `${Math.min(100, (consumed.calories / goal.calories) * 100)}%`;
            document.getElementById("protein-bar").style.width = `${Math.min(100, (consumed.protein / goal.protein_g) * 100)}%`;
            document.getElementById("carbs-bar").style.width = `${Math.min(100, (consumed.carbs / goal.carbs_g) * 100)}%`;
            document.getElementById("fats-bar").style.width = `${Math.min(100, (consumed.fats / goal.fats_g) * 100)}%`;


            // Update chart
            if (macronutrientChartCanvas) {
                if (macroChart) macroChart.destroy();

                const primary = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim();
                const success = getComputedStyle(document.documentElement).getPropertyValue('--success').trim();
                const warning = getComputedStyle(document.documentElement).getPropertyValue('--warning').trim();
                const grey = getComputedStyle(document.documentElement).getPropertyValue('--secondary').trim();
                const mutedColor = getComputedStyle(document.querySelector('.muted-p')).color;

                let chartData, chartLabels, chartColors;

                if (consumed.protein === 0 && consumed.carbs === 0 && consumed.fats === 0) {
                    chartData = [1];
                    chartLabels = ['No data'];
                    chartColors = [grey];
                } else {
                    chartData = [consumed.protein, consumed.carbs, consumed.fats];
                    chartLabels = ['Protein', 'Carbs', 'Fat'];
                    chartColors = [primary, success, warning];
                }

                macroChart = new Chart(macronutrientChartCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            data: chartData,
                            backgroundColor: chartColors,
                            borderWidth: 0,
                            hoverOffset: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: mutedColor,
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        family: "'Inter', sans-serif",
                                        size: 14,
                                        weight: "normal"
                                    },
                                }
                            },
                            tooltip: {
                                backgroundColor: "rgba(30, 30, 30, 0.9)",
                                titleFont: {
                                    family: "'Inter', sans-serif",
                                    size: 14,
                                    weight: "normal"
                                },
                                titleColor: "#fff",
                                bodyFont: {
                                    family: "'Inter', sans-serif",
                                    size: 14,
                                    weight: "normal"
                                },
                                bodyColor: "#ddd",
                                padding: 12,
                                borderColor: primary,
                                borderWidth: 2,
                                cornerRadius: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function (context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value}g (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        } catch (err) {
            console.error("Failed to load summary:", err);
        }
    }

    // Date navigation handlers
    prevBtn.addEventListener("click", () => {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDateDisplay();
        loadMealSummary();
    });

    nextBtn.addEventListener("click", () => {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDateDisplay();
        loadMealSummary();
    });

    // Initial load
    updateDateDisplay();
    loadMealSummary();
});
