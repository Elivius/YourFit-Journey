document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById("weightChart").getContext("2d");
    const macroCanvas = document.getElementById("macronutrientChart");
    let macroChart = null;

    const primary = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim();

    // Gradient for weight chart
    const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
    gradient.addColorStop(0, primary + '88');
    gradient.addColorStop(1, primary + '00');

    const weightChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [],
            datasets: [{
                label: "Weight (kg)",
                data: [],
                borderColor: primary,
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: primary,
                pointBorderColor: "#fff",
                pointHoverRadius: 8,
                pointHoverBackgroundColor: primary,
                pointHoverBorderColor: "#fff",
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif",
                            size: 14,
                            weight: "normal"
                        },
                        color: "#999"
                    },
                    grid: { color: "rgba(200, 200, 200, 0.2)" }
                },
                y: {
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif",
                            size: 14,
                            weight: "normal"
                        },
                        color: "#999",
                        stepSize: 1,
                        callback: value => Number.isInteger(value) ? value : ''
                    },
                    grid: { color: "rgba(200, 200, 200, 0.2)" },
                    beginAtZero: true
                }
            },
            plugins: {
                legend: { display: false },
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
                        label: context => ` Weight: ${parseFloat(context.raw).toFixed(1)} kg`
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: "easeInOutQuart"
            }
        }
    });

    // Load weight logs
    fetch("../backend/preload_weight_logs.php")
        .then(res => res.json())
        .then(data => {
            weightChart.data.labels = data.labels || [new Date().toISOString().split("T")[0]];
            weightChart.data.datasets[0].data = data.data || [0];
            weightChart.update();
        })
        .catch(err => {
            console.error("Failed to load weight data", err);
            weightChart.data.labels = [new Date().toISOString().split("T")[0]];
            weightChart.data.datasets[0].data = [0];
            weightChart.update();
        });

    // Load macronutrient chart
    async function loadNutritionChart() {
        const formattedDate = new Date().toISOString().split("T")[0];

        try {
            const res = await fetch(`../backend/preload_meal_summary.php?date=${formattedDate}`);
            const data = await res.json();
            const consumed = data.consumed;
            const goal = data.goal;

            if (!macroCanvas) return;

            if (macroChart) macroChart.destroy();

            const success = getComputedStyle(document.documentElement).getPropertyValue('--success').trim();
            const warning = getComputedStyle(document.documentElement).getPropertyValue('--warning').trim();
            const grey = getComputedStyle(document.documentElement).getPropertyValue('--secondary').trim();

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

            macroChart = new Chart(macroCanvas, {
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
                                color: "#999",
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
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
                            label: context => {
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
        } catch (err) {
            console.error("Failed to load nutrition chart", err);
        }
    }

    loadNutritionChart();
});
