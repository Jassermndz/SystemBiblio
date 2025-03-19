<?php
include '../conexiones/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $tipo = $_POST['tipo'];

    $sql = "INSERT INTO usuarios (nombre, email, telefono, direccion, tipo) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $nombre, $email, $telefono, $direccion, $tipo);

        if ($stmt->execute()) {
            header("Location: ../Modulos/CrearUsuarios.html?success=Usuario%20creado%20exitosament");
        } else {
            header("Location: ../Modulos/CrearUsuarios.html?error=true");
        }
        $stmt->close();
    } else {
        header("Location: ../Modulos/CrearUsuarios.html?error=true");
    }

    $conn->close();
}
?>






