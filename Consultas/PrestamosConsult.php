<?php
require_once '../conexiones/conexion.php';

function obtenerPrestamos() {
    global $conn;

    $sql = "SELECT p.id_prestamo, u.nombre AS nombre_usuario, l.titulo AS libro, a.usuario AS nombre_admin, p.fecha_prestamo, p.fecha_devolucion
            FROM Prestamos p
            JOIN Usuarios u ON p.id_usuario = u.id
            JOIN Libros l ON p.id_libro = l.id
            JOIN Administradores a ON p.id_administrador = a.id";
    $resultado = $conn->query($sql);

    if ($resultado === false) {
        die("Error en la consulta: " . $conn->error);
    }

    $prestamos = array();
    while ($row = $resultado->fetch_assoc()) {
        $prestamos[] = $row;
    }

    return $prestamos;
}

header('Content-Type: application/json');
echo json_encode(obtenerPrestamos());

$conn->close();
?>









