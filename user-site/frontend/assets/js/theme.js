document.addEventListener('DOMContentLoaded', function() {
    // Theme Toggle
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;
    
    // Check for saved theme preference or use preferred color scheme
    const savedTheme = localStorage.getItem('theme');
    
    if (savedTheme) {
        body.classList.toggle('dark-theme', savedTheme === 'dark');
        updateThemeIcon(savedTheme === 'dark');
    } else {
        // Check if user prefers dark mode
        const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        body.classList.toggle('dark-theme', prefersDarkMode);
        updateThemeIcon(prefersDarkMode);
    }
    
    // Theme toggle click handler
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const isDarkTheme = body.classList.toggle('dark-theme');
            localStorage.setItem('theme', isDarkTheme ? 'dark' : 'light');
            updateThemeIcon(isDarkTheme);
        });
    }
    
    function updateThemeIcon(isDarkTheme) {
        if (!themeToggle) return;
        
        const icon = themeToggle.querySelector('i');
        if (icon) {
            if (isDarkTheme) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }
    }
});