const toggleButton = document.getElementById('theme-toggle');
const htmlElement = document.documentElement;
const inputDarkmode = document.getElementById('dark-mode-input');

function applyTheme(theme) {
    htmlElement.setAttribute('data-bs-theme', theme);

    if (theme === 'dark') {
        inputDarkmode.checked = true;
    } else {
        inputDarkmode.checked = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedTheme = localStorage.getItem('theme') || (systemPrefersDark ? 'dark' : 'light');

    applyTheme(savedTheme);
});

inputDarkmode.addEventListener('change', () => {
    const currentTheme = htmlElement.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    applyTheme(newTheme);
    localStorage.setItem('theme', newTheme);
});

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    if (!localStorage.getItem('theme')) {
        applyTheme(event.matches ? 'dark' : 'light');
    }
});
