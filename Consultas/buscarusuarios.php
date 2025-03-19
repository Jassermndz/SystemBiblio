<?php
include '../conexiones/conexion.php';

$nombre_usuario = isset($_GET['nombre_usuario']) ? $_GET['nombre_usuario'] : '';

$sql = $nombre_usuario ? "SELECT id, nombre FROM Usuarios WHERE nombre LIKE ?" : "SELECT id, nombre FROM usuarios";
$stmt = $conn->prepare($sql);

if ($nombre_usuario) {
    $searchTerm = "%" . $nombre_usuario . "%";
    $stmt->bind_param("s", $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuarios = [];
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre']
        ];
    }
    echo json_encode(['usuarios' => $usuarios]);
} else {
    echo json_encode(['error' => 'No se encontraron usuarios']);
}

$stmt->close();
$conn->close();
?>
