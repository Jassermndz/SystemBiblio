<?php
include '../conexiones/conexion.php'; 

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die(json_encode(['error' => 'Error de conexión a la base de datos']));
}

$query = "SELECT id, nombre FROM categorias";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    $categorias = [];

    while ($fila = $resultado->fetch_assoc()) {
        $categorias[] = $fila;
    }

    echo json_encode(['categorias' => $categorias]);
} else {
    echo json_encode(['categorias' => []]);
}

$conexion->close();
?>
