document.addEventListener('DOMContentLoaded', function () {
    if (localStorage.getItem('dark-mode') === 'enabled') {
        document.body.classList.add('dark-mode');
    }
});
