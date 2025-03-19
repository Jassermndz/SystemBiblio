<?php
include '../conexiones/conexion.php';

$categoriaId = isset($_GET['categoria_id']) ? $_GET['categoria_id'] : null;

$sqlLibros = "SELECT libros.id, libros.titulo, libros.autor, libros.editorial, libros.anio_publicacion, 
                libros.cantidad_disponible, libros.imagen, libros.isbn, libros.estanteria, 
                categorias.nombre AS categoria_nombre
        FROM libros
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
            'isbn' => $row['isbn'],
            'estanteria' => $row['estanteria'],
            'categoria_nombre' => $row['categoria_nombre']
        ];
    }
} else {
    $libros = [];
}

echo json_encode([
    'libros' => $libros
]);

$conn->close();
?>
