<?php
include '../conexiones/conexion.php';

$categoriaId = isset($_GET['categoria_id']) ? intval($_GET['categoria_id']) : null;
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : null;

$sqlLibros = "SELECT libros.id, libros.titulo, libros.autor, libros.editorial, 
libros.anio_publicacion, libros.cantidad_disponible, libros.imagen, libros.id_categoria, 
categorias.nombre AS categoria_nombre FROM libros 
LEFT JOIN categorias ON libros.id_categoria = categorias.id";

$conditions = [];

if ($categoriaId) {
    $conditions[] = "libros.id_categoria = $categoriaId";
}
if ($buscar) {
    $buscar = $conn->real_escape_string($buscar);
    $conditions[] = "(libros.titulo LIKE '%$buscar%' OR libros.autor LIKE '%$buscar%')";
}

if (!empty($conditions)) {
    $sqlLibros .= " WHERE " . implode(" AND ", $conditions);
}

$resultLibros = $conn->query($sqlLibros);

if (!$resultLibros) {
    die(json_encode(["error" => "Error en la consulta: " . $conn->error]));
}

$libros = [];
while ($row = $resultLibros->fetch_assoc()) {
    $libros[] = $row;
}

$sqlCategorias = "SELECT id, nombre FROM categorias";
$resultCategorias = $conn->query($sqlCategorias);

if (!$resultCategorias) {
    die(json_encode(["error" => "Error en consulta de categorías: " . $conn->error]));
}

$categorias = [];
while ($row = $resultCategorias->fetch_assoc()) {
    $categorias[] = $row;
}

echo json_encode(["libros" => $libros, "categorias" => $categorias]);

$conn->close();
?>


