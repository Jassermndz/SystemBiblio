function cerrarSesion() {
    fetch('../Consultas/cerrar_sesion.php')
        .then(response => {
            if (response.ok) {
                window.location.href = "/SystemBiblio/index.html";
            }
        })
        .catch(error => console.error('Error al cerrar sesión:', error));
}
