document.addEventListener('DOMContentLoaded', function() {
    fetch('../Consultas/categorias.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('categoria-table-container').innerHTML = data;
    })
    .catch(error => {
        document.getElementById('categoria-table-container').innerHTML = '<tr><td colspan="2">Error al cargar las categorías.</td></tr>';
    });
});

