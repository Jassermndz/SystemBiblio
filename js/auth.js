document.addEventListener("DOMContentLoaded", function () {
    fetch('../Consultas/auth.php', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                window.location.href = "/SystemBiblio/BiblioVirtual/login.html";
            }
        })
        .catch(error => console.error('Error verificando la sesión:', error));
});