function buscarUsuario() {
    const nombreUsuario = document.getElementById('usuario-nombre').value;

    fetch(`../Consultas/buscarusuarios.php?nombre_usuario=${nombreUsuario}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('usuario-seleccionado').value = '';
                alert(data.error);
                return;
            }

            const usuarioSeleccionado = document.getElementById('usuario-seleccionado');
            if (data.usuarios && data.usuarios.length > 0) {
                const usuario = data.usuarios[0];
                usuarioSeleccionado.value = usuario.id; 
                usuarioSeleccionado.setAttribute('data-nombre', usuario.nombre); 
            } else {
                usuarioSeleccionado.value = '';
            }
        })
        .catch(error => {
            console.error('Error al buscar usuario:', error);
        });
}
