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
            $stmt->execute();
            $stmt->close();

            echo json_encode(['success' => 'Imagen actualizada correctamente']);
            exit();
        } else {
            echo json_encode(['error' => 'Error al subir la imagen']);
            exit();
        }
    } else {
        echo json_encode(['error' => 'Formato de imagen no válido']);
        exit();
    }
}

if ($rol_sesion === 'Administrador' && isset($_POST['rol'])) {
    $rol = $_POST['rol'];
    $sql = "UPDATE administradores SET rol = ? WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $rol, $usuario);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => 'Rol actualizado correctamente']);
    exit();
}
header("Location: ../SystemBiblio/Modulos/Configuracion.html");
$conn->close();
?>
