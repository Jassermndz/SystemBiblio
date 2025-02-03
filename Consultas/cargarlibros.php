<?php
include '../conexiones/conexion.php';


$categoriaId = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : null;


$sqlLibros = "SELECT libros.id, libros.titulo, libros.autor, libros.editorial, libros.anio_publicacion, libros.cantidad_disponible, libros.imagen, libros.id_categoria, categorias.nombre AS categoria_nombre
        FROM Libros
        LEFT JOIN categorias ON libros.id_categoria = categorias.id";


if ($categoriaId) {
    $sqlLibros .= " WHERE libros.id_categoria = $categoriaId";
}

$resultLibros = $conn->query($sqlLibros);

$libros = [];
if ($resultLibros->num_rows > 0) {
    while ($row = $resultLibros->fetch_assoc()) {
        $libros[] = [
            'id' => $row['id'],
            'titulo' => $row['titulo'],
            'autor' => $row['autor'],
            'editorial' => $row['editorial'],
            'anio_publicacion' => $row['anio_publicacion'],
            'cantidad_disponible' => $row['cantidad_disponible'],
            'imagen' => $row['imagen'] ? $row['imagen'] : 'default-image.jpg',
            'categoria_id' => $row['id_categoria'],
            'categoria_nombre' => $row['categoria_nombre'],
        ];
    }
} else {
  
    $libros = [];
}


$sqlCategorias = "SELECT id, nombre FROM categorias";
$resultCategorias = $conn->query($sqlCategorias);

$categorias = [];
if ($resultCategorias->num_rows > 0) {
    while ($row = $resultCategorias->fetch_assoc()) {
        $categorias[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre']
        ];
    }
}


echo json_encode([
    'libros' => $libros,
    'categorias' => $categorias
]);

$conn->close();
?>


