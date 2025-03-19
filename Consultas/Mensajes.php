<?php
include '../conexiones/conexion.php.'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['name'];
    $email = $_POST['email'];
    $asunto = $_POST['subject'];
    $mensaje = $_POST['message'];

    if (!empty($nombre) && !empty($email) && !empty($asunto) && !empty($mensaje)) {
        $sql = "INSERT INTO mensajes (nombre, email, asunto, mensaje) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $email, $asunto, $mensaje);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Mensaje enviado con éxito."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al enviar el mensaje."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
    }
    $conn->close();
}
?>
