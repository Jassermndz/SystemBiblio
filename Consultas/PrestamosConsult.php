<?php
require_once '../conexiones/conexion.php';

function obtenerPrestamos() {
    global $conn;

    $sql = "SELECT p.id AS id_prestamo, u.nombre AS nombre_usuario, l.titulo AS libro, 
                   p.fecha_prestamo, p.fecha_devolucion,
                   CASE 
                       WHEN p.fecha_devolucion < CURDATE() THEN 'TARDÍA' 
                       ELSE p.fecha_devolucion 
                   END AS estado_devolucion
            FROM prestamos p
            JOIN usuarios u ON p.id_usuario = u.id
            JOIN libros l ON p.id_libro = l.id
            LIMIT 25";

    $resultado = $conn->query($sql);

    if ($resultado === false) {
        die(json_encode(["error" => "Error en la consulta: " . $conn->error]));
    }

    $prestamos = array();
    while ($row = $resultado->fetch_assoc()) {
        $prestamos[] = $row;
    }

    echo json_encode($prestamos);
}

obtenerPrestamos();
$conn->close();
?>













