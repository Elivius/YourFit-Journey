document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById("weightChart").getContext("2d");

    // Get --primary from CSS
    const primary = getComputedStyle(document.documentElement)
        .getPropertyValue('--primary')
        .trim();

    // Create gradient using --primary
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, primary + '88'); // top with ~50% opacity
    gradient.addColorStop(1, primary + '00'); // fully transparent at bottom

    const weightData = {
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
    };

    const weightChart = new Chart(ctx, {
        type: "line",
        data: weightData,
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
                        callback: function (value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    },
                    grid: { color: "rgba(200, 200, 200, 0.2)" },
                    beginAtZero: false
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
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
                            return ` Weight: ${parseFloat(context.raw).toFixed(1)} kg`;
                        }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: "easeInOutQuart"
            }
        }
    });

    // Load data from backend
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
});
