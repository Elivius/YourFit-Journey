document.addEventListener('DOMContentLoaded', function() {
    // Set chart.js defaults to match theme
    Chart.defaults.color = getComputedStyle(document.documentElement).getPropertyValue('--body-color');
    Chart.defaults.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--card-border');
    
    // Workout Activity Chart
    const workoutActivityChart = document.getElementById('workoutActivityChart');
    if (workoutActivityChart) {
        const gradient = workoutActivityChart.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(var(--primary-rgb), 0.5)');
        gradient.addColorStop(1, 'rgba(var(--primary-rgb), 0)');
        
        new Chart(workoutActivityChart, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Workouts',
                    data: [5, 7, 3, 5, 6, 8, 4],
                    borderColor: getComputedStyle(document.documentElement).getPropertyValue('--primary').trim(),
                    backgroundColor: gradient,
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--primary').trim(),
                    pointBorderColor: getComputedStyle(document.documentElement).getPropertyValue('--card-bg').trim(),
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(var(--primary-rgb), 0.1)'
                        },
                        ticks: {
                            padding: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            padding: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--card-bg').trim(),
                        titleColor: getComputedStyle(document.documentElement).getPropertyValue('--body-color').trim(),
                        bodyColor: getComputedStyle(document.documentElement).getPropertyValue('--body-color').trim(),
                        borderColor: getComputedStyle(document.documentElement).getPropertyValue('--card-border').trim(),
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            title: function(tooltipItems) {
                                return tooltipItems[0].label;
                            },
                            label: function(context) {
                                return `${context.parsed.y} workouts completed`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Nutrition Chart
    const nutritionChart = document.getElementById('nutritionChart');
    if (nutritionChart) {
        new Chart(nutritionChart, {
            type: 'doughnut',
            data: {
                labels: ['Protein', 'Carbs', 'Fat'],
                datasets: [{
                    data: [30, 50, 20],
                    backgroundColor: [
                        getComputedStyle(document.documentElement).getPropertyValue('--primary').trim(),
                        getComputedStyle(document.documentElement).getPropertyValue('--success').trim(),
                        getComputedStyle(document.documentElement).getPropertyValue('--warning').trim()
                    ],
                    borderWidth: 0,
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--card-bg').trim(),
                        titleColor: getComputedStyle(document.documentElement).getPropertyValue('--body-color').trim(),
                        bodyColor: getComputedStyle(document.documentElement).getPropertyValue('--body-color').trim(),
                        borderColor: getComputedStyle(document.documentElement).getPropertyValue('--card-border').trim(),
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.parsed}%`;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // Update charts when theme changes
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            // Wait for theme to change
            setTimeout(() => {
                // Destroy and recreate charts
                Chart.instances.forEach(instance => {
                    instance.destroy();
                });
                
                // Reinitialize charts
                if (workoutActivityChart) {
                    const gradient = workoutActivityChart.getContext('2d').createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(var(--primary-rgb), 0.5)');
                    gradient.addColorStop(1, 'rgba(var(--primary-rgb), 0)');
                    
                    new Chart(workoutActivityChart, {
                        type: 'line',
                        data: {
                            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                            datasets: [{
                                label: 'Workouts',
                                data: [5, 7, 3, 5, 6, 8, 4],
                                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--primary').trim(),
                                backgroundColor: gradient,
                                tension: 0.4,
                                fill: true,
                                borderWidth: 3,
                                pointBackgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--primary').trim(),
                                pointBorderColor: getComputedStyle(document.documentElement).getPropertyValue('--card-bg').trim(),
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(var(--primary-rgb), 0.1)'
                                    },
                                    ticks: {
                                        padding: 10
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        padding: 10
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--card-bg').trim(),
                                    titleColor: getComputedStyle(document.documentElement).getPropertyValue('--body-color').trim(),
                                    bodyColor: getComputedStyle(document.documentElement).getPropertyValue('--body-color').trim(),
                                    borderColor: getComputedStyle(document.documentElement).getPropertyValue('--card-border').trim(),
                                    borderWidth: 1,
                                    padding: 12,
                                    displayColors: false,
                                    callbacks: {
                                        title: function(tooltipItems) {
                                            return tooltipItems[0].label;
                                        },
                                        label: function(context) {
                                            return `${context.parsed.y} workouts completed`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
                
                if (nutritionChart) {
                    new Chart(nutritionChart, {
                        type: 'doughnut',
                        data: {
                            labels: ['Protein', 'Carbs', 'Fat'],
                            datasets: [{
                                data: [30, 50, 20],
                                backgroundColor: [
                                    getComputedStyle(document.documentElement).getPropertyValue('--primary').trim(),
                                    getComputedStyle(document.documentElement).getPropertyValue('--success').trim(),
                                    getComputedStyle(document.documentElement).getPropertyValue('--warning').trim()
                                ],
                                borderWidth: 0,
                                hoverOffset: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        pointStyle: 'circle'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--card-bg').trim(),
                                    titleColor: getComputedStyle(document.documentElement).getPropertyValue('--body-color').trim(),
                                    bodyColor: getComputedStyle(document.documentElement).getPropertyValue('--body-color').trim(),
                                    borderColor: getComputedStyle(document.documentElement).getPropertyValue('--card-border').trim(),
                                    borderWidth: 1,
                                    padding: 12,
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.label}: ${context.parsed}%`;
                                        }
                                    }
                                }
                            },
                            cutout: '70%'
                        }
                    });
                }
            }, 100);
        });
    }
});