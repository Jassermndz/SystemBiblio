<?php
include '../conexiones/conexion.php';

$sql_usuarios = "SELECT COUNT(*) AS total_usuarios FROM Usuarios";
$sql_libros = "SELECT COUNT(*) AS total_libros FROM Libros";
$sql_autores = "SELECT COUNT(DISTINCT autor) AS total_autores FROM Libros";
$sql_editoriales = "SELECT COUNT(DISTINCT editorial) AS total_editoriales FROM Libros";

$usuarios_result = $conn->query($sql_usuarios);
$libros_result = $conn->query($sql_libros);
$autores_result = $conn->query($sql_autores);
$editoriales_result = $conn->query($sql_editoriales);

if ($usuarios_result && $libros_result && $autores_result && $editoriales_result) {
    $usuarios = $usuarios_result->fetch_assoc();
    $libros = $libros_result->fetch_assoc();
    $autores = $autores_result->fetch_assoc();
    $editoriales = $editoriales_result->fetch_assoc();

    echo json_encode([
        'total_usuarios' => $usuarios['total_usuarios'],
        'total_libros' => $libros['total_libros'],
        'total_autores' => $autores['total_autores'],
        'total_editoriales' => $editoriales['total_editoriales']
    ]);
} else {
    echo json_encode(['error' => 'Error al consultar la base de datos']);
}

$conn->close();
?>

