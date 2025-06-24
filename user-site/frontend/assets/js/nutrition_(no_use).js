document.addEventListener('DOMContentLoaded', function() {
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
});