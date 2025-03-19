<?php
include '../conexiones/conexion.php';

if (isset($_POST['id_libro'], $_POST['id_usuario'], $_POST['fecha_prestamo'], $_POST['fecha_devolucion'], $_POST['estado'])) {
    $id_libro = $_POST['id_libro'];
    $id_usuario = $_POST['id_usuario'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $fecha_devolucion = $_POST['fecha_devolucion'];
    $estado = $_POST['estado'];
    if (strtotime($fecha_prestamo) && strtotime($fecha_devolucion)) {
        $sql = "INSERT INTO prestamos (id_libro, id_usuario, fecha_prestamo, fecha_devolucion, estado) 
                VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("iisss", $id_libro, $id_usuario, $fecha_prestamo, $fecha_devolucion, $estado);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Préstamo registrado correctamente']);
            } else {
                echo json_encode(['error' => 'Error al registrar el préstamo']);
            }

            $stmt->close();
        } else {
            echo json_encode(['error' => 'Error en la preparación de la consulta']);
        }
    } else {
        echo json_encode(['error' => 'Las fechas proporcionadas no son válidas']);
    }
} else {
    echo json_encode(['error' => 'Faltan datos para registrar el préstamo']);
}

$conn->close();
?>







