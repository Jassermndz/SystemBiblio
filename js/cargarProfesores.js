document.addEventListener('DOMContentLoaded', function() {
    fetch('../Consultas/obtener_estudiantes.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('profesores-table-container').innerHTML = data;
    })
    .catch(error => {
        document.getElementById('profesores-table-container').innerHTML = '<tr><td colspan="2">Error al cargar los estudiantes.</td></tr>';
    });
});
