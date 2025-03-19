document.addEventListener('DOMContentLoaded', function () {
    fetch('../Consultas/consultar_estadisticas.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); 

            if (data && data.total_usuarios !== undefined) {
                document.getElementById('usuarios').innerText = data.total_usuarios;
                document.getElementById('libros').innerText = data.total_libros;
                document.getElementById('autores').innerText = data.total_autores;
                document.getElementById('editoriales').innerText = data.total_editoriales;
            } else {
                console.error('Datos incorrectos', data);
                alert('Hubo un error al cargar las estadísticas.');
            }
        })
        .catch(error => {
            console.error('Error al obtener las estadísticas:', error);
            alert('Hubo un error al obtener los datos.');
        });
});

