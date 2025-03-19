<?php
include('../Conexiones/conexion.php');

$selectedBook = $_GET['selectedBook'];  

$sql = "SELECT 
            p.id AS id_prestamo,
            u.nombre AS nombre_usuario,
            l.titulo AS titulo_libro,
            p.fecha_prestamo,
            p.fecha_devolucion,
            p.estado
        FROM prestamos p
        JOIN usuarios u ON p.id_usuario = u.id
        JOIN libros l ON p.id_libro = l.id
        WHERE l.id = ? AND p.estado = 'Prestado'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $selectedBook);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo json_encode($row);
} else {
    echo json_encode(["error" => "No se encontraron datos del préstamo"]);
}

$stmt->close();
$conn->close();
?>

