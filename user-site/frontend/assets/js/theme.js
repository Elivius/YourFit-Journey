document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Update the shape of the switch handle
    function updateThemeShape(isDarkTheme) {
        const handle = document.querySelector('.switch-handle');
        if (handle) {
            if (isDarkTheme) {
                handle.classList.remove('sun-shape');
                handle.classList.add('moon-shape');
            } else {
                handle.classList.remove('moon-shape');
                handle.classList.add('sun-shape');
            }
        }
    }

    // Determine initial theme
    const savedTheme = localStorage.getItem('theme');
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const useDarkTheme = savedTheme === 'dark' || (!savedTheme && prefersDarkMode);

    // Set initial state
    body.classList.toggle('dark-theme', useDarkTheme);
    if (themeToggle) {
        themeToggle.checked = useDarkTheme;
        updateThemeShape(useDarkTheme);
    }

    // Handle toggle change
    if (themeToggle) {
        themeToggle.addEventListener('change', function() {
            const isDarkTheme = this.checked;
            body.classList.toggle('dark-theme', isDarkTheme);
            localStorage.setItem('theme', isDarkTheme ? 'dark' : 'light');
            updateThemeShape(isDarkTheme);
        });
    }

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        if (!localStorage.getItem('theme')) {
            const isDarkTheme = e.matches;
            body.classList.toggle('dark-theme', isDarkTheme);
            if (themeToggle) {
                themeToggle.checked = isDarkTheme;
                updateThemeShape(isDarkTheme);
            }
        }
    });
});