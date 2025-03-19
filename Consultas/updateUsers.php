<?php
include '../conexiones/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];  
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $tipo = $_POST['tipo'];
    $fechaRegistro = $_POST['fecha_registro'];  

    $password = isset($_POST['password']) && !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    $sql = "UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, direccion = ?, tipo = ?, fecha_registro = ?" . 
           ($password ? ", password = ?" : "") . " WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if ($password) {
        $stmt->bind_param("sssssssi", $nombre, $email, $telefono, $direccion, $tipo, $fechaRegistro, $password, $id);
    } else {
        $stmt->bind_param("ssssssi", $nombre, $email, $telefono, $direccion, $tipo, $fechaRegistro, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>



