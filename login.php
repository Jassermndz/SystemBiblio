<?php
session_start();
include('conexiones/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM administradores WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['contrasena'])) {
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['rol'] = $row['rol']; 
            $_SESSION['imagen'] = $row['imagen'] ? $row['imagen'] : 'user-avatar.png'; 

            if ($row['rol'] == "Administrador") {
                header("Location: /SystemBiblio/Modulos/home.html");
            } else {
                header("Location: /SystemBiblio/Modulos/home.html");
            }
            exit(); 
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
}
$conn->close();
?>


