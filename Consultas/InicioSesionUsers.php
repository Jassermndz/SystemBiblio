<?php
session_start();
include '../conexiones/conexion.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $sql = "SELECT id, nombre, email, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            header("Location: ../BiblioVirtual/libros.html"); 
            exit();
        } else {
            header("Location: ../BiblioVirtual/IniciarSesion.html?error=Contraseña incorrecta");
            exit();
        }
    } else {
        header("Location: ../BiblioVirtual/IniciarSesion.html?error=El email no está registrado");
        exit();
    }

    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
} else {
    header("Location: pLocation: ../BiblioVirtual/IniciarSesion.html?error=Método de acceso no permitido");
    exit();
}

?>
