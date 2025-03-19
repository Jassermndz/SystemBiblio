<?php
include('../Conexiones/conexion.php');

$sql = "
    SELECT 
        p.id AS id_prestamo, 
        u.nombre AS nombre_usuario, 
        l.titulo AS titulo_libro, 
        p.fecha_prestamo, 
        p.fecha_devolucion, 
        p.estado
    FROM prestamos p
    JOIN libros l ON p.id_libro = l.id
    JOIN usuarios u ON p.id_usuario = u.id
    WHERE p.estado = 'Prestado'
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $prestamos = [];
    while ($row = $result->fetch_assoc()) {
        $prestamos[] = $row;
    }
    echo json_encode($prestamos);
} else {
    echo json_encode(["error" => "No se encontraron préstamos"]);
}

$conn->close();
?>

