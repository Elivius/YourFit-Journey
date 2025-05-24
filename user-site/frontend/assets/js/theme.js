document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Function to update theme icon
    function updateThemeIcon(isDarkTheme) {
        if (!themeToggle) return;
        const icon = themeToggle.querySelector('i');
        if (icon) {
            icon.classList.toggle('fa-moon', !isDarkTheme);
            icon.classList.toggle('fa-sun', isDarkTheme);
        }
    }

    // Determine initial theme (from localStorage or system preference)
    const savedTheme = localStorage.getItem('theme');
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const useDarkTheme = savedTheme === 'dark' || (!savedTheme && prefersDarkMode);

    body.classList.toggle('dark-theme', useDarkTheme);
    updateThemeIcon(useDarkTheme);

    // Handle toggle click
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const isDarkTheme = body.classList.toggle('dark-theme');
            localStorage.setItem('theme', isDarkTheme ? 'dark' : 'light');
            updateThemeIcon(isDarkTheme);
        });
    }
});
