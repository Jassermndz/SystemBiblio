<?php
require '../conexiones/conexion.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Correo inválido.</div>";
        exit;
    } else {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            echo "<div class='alert alert-success'>El correo está registrado. Puedes proceder con la recuperación.</div>";
        } else {
            echo "<div class='alert alert-danger'>El correo no está registrado.</div>";
        }
        
        $stmt->close();
    }

    $conn->close();
}
?>

