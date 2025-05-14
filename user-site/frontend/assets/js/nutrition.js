document.addEventListener('DOMContentLoaded', function() {
    // Set chart.js defaults to match theme
    Chart.defaults.color = getComputedStyle(document.documentElement).getPropertyValue('--body-color');
    Chart.defaults.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--card-border');
    
    // Macronutrient Chart
    const macronutrientChart = document.getElementById('macronutrientChart');
    if (macronutrientChart) {
        new Chart(macronutrientChart, {
            type: 'doughnut',
            data: {
                labels: ['Protein', 'Carbs', 'Fat'],
                datasets: [{
                    data: [85, 120, 45],
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
                cutout: '70%',
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
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value}g (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Add Food Button Event Listeners
    const addFoodButtons = document.querySelectorAll('.btn-primary:contains("Add Food")');
    addFoodButtons.forEach(button => {
        button.addEventListener('click', function() {
            const addFoodModal = new bootstrap.Modal(document.getElementById('addFoodModal'));
            addFoodModal.show();
        });
    });

    // Water Tracker Controls
    const waterMinusBtn = document.querySelector('.water-controls .btn:first-child');
    const waterPlusBtn = document.querySelector('.water-controls .btn:last-child');
    const waterLevel = document.querySelector('.water-level');
    const waterOverlaySpan = document.querySelector('.water-overlay span');
    
    if (waterMinusBtn && waterPlusBtn && waterLevel && waterOverlaySpan) {
        let currentGlasses = 6;
        const totalGlasses = 10;
        
        waterMinusBtn.addEventListener('click', function() {
            if (currentGlasses > 0) {
                currentGlasses--;
                updateWaterTracker();
            }
        });
        
        waterPlusBtn.addEventListener('click', function() {
            if (currentGlasses < totalGlasses) {
                currentGlasses++;
                updateWaterTracker();
            }
        });
        
        function updateWaterTracker() {
            const percentage = (currentGlasses / totalGlasses) * 100;
            waterLevel.style.height = `${percentage}%`;
            waterOverlaySpan.textContent = `${currentGlasses}/${totalGlasses}`;
            
            // Update water info text
            const waterInfo = document.querySelector('.water-info');
            if (waterInfo) {
                const waterInfoParagraphs = waterInfo.querySelectorAll('p');
                if (waterInfoParagraphs.length >= 2) {
                    const liters = (currentGlasses * 0.25).toFixed(1);
                    waterInfoParagraphs[1].textContent = `Current: ${currentGlasses} glasses (${liters}L)`;
                }
            }
        }
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
                
                // Reinitialize macronutrient chart
                if (macronutrientChart) {
                    new Chart(macronutrientChart, {
                        type: 'doughnut',
                        data: {
                            labels: ['Protein', 'Carbs', 'Fat'],
                            datasets: [{
                                data: [85, 120, 45],
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
                            cutout: '70%',
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
                                            const label = context.label || '';
                                            const value = context.parsed || 0;
                                            const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                                            const percentage = Math.round((value / total) * 100);
                                            return `${label}: ${value}g (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }, 100);
        });
    }

    // jQuery-like contains function for vanilla JS
    if (!Element.prototype.matches) {
        Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
    }
    
    if (!Element.prototype.closest) {
        Element.prototype.closest = function(s) {
            var el = this;
            do {
                if (el.matches(s)) return el;
                el = el.parentElement || el.parentNode;
            } while (el !== null && el.nodeType === 1);
            return null;
        };
    }
    
    // Custom contains selector
    NodeList.prototype.forEach = Array.prototype.forEach;
    HTMLCollection.prototype.forEach = Array.prototype.forEach;
    
    function contains(selector, text) {
        const elements = document.querySelectorAll(selector);
        return Array.from(elements).filter(function(element) {
            return element.textContent.includes(text);
        });
    }
});