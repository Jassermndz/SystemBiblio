document.addEventListener('DOMContentLoaded', function () {
    fetch('../Consultas/datos_usuario.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            document.getElementById('user-name').innerText = data.usuario;
            document.getElementById('user-role').innerText = data.rol;

            const userImage = document.getElementById('user-image');
            userImage.src = data.imagen ? data.imagen : '../img/imgperfil.png';
        })
        .catch(error => {
            console.error('Error al cargar los datos del usuario:', error);
        });
});
