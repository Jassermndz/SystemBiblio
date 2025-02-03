document.addEventListener("DOMContentLoaded", function () {
    const usuario = "NombreDeUsuario"; 

    fetch(`obtener_datos_usuario.php?usuario=${usuario}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("userImage").src = data.imagen;
                document.getElementById("userName").textContent = data.usuario;
                document.getElementById("userRole").textContent = data.rol;
                const topImage = document.getElementById("topUserImage");
                if (topImage) {
                    topImage.src = data.imagen;
                }
            } else {
                console.error("Error:", data.message);
            }
        })
        .catch(error => console.error("Error:", error));
});
