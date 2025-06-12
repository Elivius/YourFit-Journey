document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Determine initial theme (from localStorage or system preference)
    const savedTheme = localStorage.getItem('theme');
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const useDarkTheme = savedTheme === 'dark' || (!savedTheme && prefersDarkMode);

    // Set initial state
    body.classList.toggle('dark-theme', useDarkTheme);
    if (themeToggle) {
        themeToggle.checked = useDarkTheme;
    }

    // Handle toggle change
    if (themeToggle) {
        themeToggle.addEventListener('change', function() {
            const isDarkTheme = this.checked;
            body.classList.toggle('dark-theme', isDarkTheme);
            localStorage.setItem('theme', isDarkTheme ? 'dark' : 'light');
        });
    }

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        if (!localStorage.getItem('theme')) {
            const isDarkTheme = e.matches;
            body.classList.toggle('dark-theme', isDarkTheme);
            if (themeToggle) {
                themeToggle.checked = isDarkTheme;
            }
        }
    });
});