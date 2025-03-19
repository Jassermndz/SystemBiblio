<?php
include '../conexiones/conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $tipo = $_POST['tipo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

  
    $stmt = $conn->prepare("SELECT id FROM Usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('El correo ya está registrado.'); window.location.href='../CrearCuenta.html';</script>";
        exit();
    }
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, telefono, direccion, tipo, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $email, $telefono, $direccion, $tipo, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado correctamente.'); window.location.href='../index.html';</script>";
    } else {
        echo "<script>alert('Error al registrar usuario.'); window.location.href='../CrearCuenta.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
