<?php
include '../conexiones/conexion.php';
session_start();

$usuario = $_SESSION['usuario']; 
$rol_sesion = $_SESSION['rol']; 

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tipo = $_FILES['imagen']['type'];

    $extensiones_validas = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($imagen_tipo, $extensiones_validas)) {
        $imagen_nombre_unico = uniqid() . '-' . $imagen_nombre;
        $imagen_ruta = '../uploads/' . $imagen_nombre_unico;

        if (move_uploaded_file($imagen_tmp, $imagen_ruta)) {
            $sql = "UPDATE administradores SET imagen = ? WHERE usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $imagen_ruta, $usuario);
            if ($stmt->execute()) {

                header("Location: /SystemBiblio/Modulos/Configuracion.html?success=Imagen%20actualizada%20correctamente");
                exit();
            } else {
                header("Location: /SystemBiblio/Modulos/Configuracion.html?error=Error%20al%20actualizar%20la%20imagen");
                exit();
            }
        } else {
            header("Location: /SystemBiblio/Modulos/Configuracion.html?error=Error%20al%20subir%20la%20imagen");
            exit();
        }
    } else {
        header("Location: /SystemBiblio/Modulos/Configuracion.html?error=Formato%20de%20imagen%20no%20v%C3%A1lido");
        exit();
    }
}

if ($rol_sesion === 'Administrador' && isset($_POST['usuario']) && isset($_POST['rol'])) {
    $usuario_actualizar = $_POST['usuario'];
    $rol_nuevo = $_POST['rol'];

    $sql = "UPDATE administradores SET rol = ? WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $rol_nuevo, $usuario_actualizar);
    if ($stmt->execute()) {
        header("Location: /SystemBiblio/Modulos/Configuracion.html?success=Rol%20actualizado%20correctamente");
        exit();
    } else {
        header("Location: /SystemBiblio/Modulos/Configuracion.html?error=Error%20al%20actualizar%20el%20rol");
        exit();
    }
}

header("Location: /SystemBiblio/Modulos/Configuracion.html");
$conn->close();
?>


