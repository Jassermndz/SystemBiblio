<?php
include '../conexiones/conexion.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['usuario']) || empty($_POST['contrasena']) || empty($_POST['rol'])) {
            header("Location: ../Modulos/Administradores.html?error=Todos%20los%20campos%20obligatorios%20deben%20ser%20completados");
            exit();
        }
        
        $usuario    = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $rol        = $_POST['rol'];


        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
        $imagenRuta = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/SystemBiblio/uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $allowed   = ['jpg', 'jpeg', 'png'];
            if (!in_array($extension, $allowed)) {
                header("Location: ../Modulos/Administradores.html?error=Solo%20se%20permiten%20im%C3%A1genes%20JPG,%20JPEG%20o%20PNG");
                exit();
            }

            if ($_FILES['imagen']['size'] > 20 * 1024 * 1024) {
                header("Location: ../Modulos/Administradores.html?error=El%20tama%C3%B1o%20de%20la%20im%C3%A1gen%20es%20demasiado%20grande");
                exit();
            }
         
            $newFileName = uniqid() . '.' . $extension;
            $targetFile  = $targetDir . $newFileName;
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile)) {
                header("Location: ../Modulos/Administradores.html?error=Error%20al%20subir%20la%20im%C3%A1gen");
                exit();
            }
            
            $imagenRuta = "uploads/" . $newFileName;
        }

        $sql = "INSERT INTO Administradores (usuario, contrasena, rol, imagen) VALUES (?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $usuario, $hashedPassword, $rol, $imagenRuta);
            
            if ($stmt->execute()) {
                header("Location: ../Modulos/Administradores.html?success=Administrador%20creado%20exitosamente");
                exit();
            } else {
                header("Location: ../Modulos/Administradores.html?error=Error%20al%20insertar:%20" . urlencode($stmt->error));
                exit();
            }
        } else {
            header("Location: ../Modulos/Administradores.html?error=Error%20al%20preparar%20la%20consulta:%20" . urlencode($conn->error));
            exit();
        }
    } else {
        header("Location: ../Modulos/Administradores.html?error=M%C3%A9todo%20no%20permitido");
        exit();
    }
} finally {

    $conn->close();
}
?>
