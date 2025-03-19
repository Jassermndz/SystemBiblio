<?php
include '../conexiones/conexion.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    $conexion = new mysqli($servername, $username, $password, $dbname);

    if ($conexion->connect_error) {
        throw new Exception('Error de conexión a la base de datos: ' . $conexion->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombreCategoria = trim($_POST['nombreCategoria'] ?? '');

        if (empty($nombreCategoria)) {
            throw new Exception('El nombre de la categoría es obligatorio.');
        }

        $stmt_check = $conexion->prepare("SELECT id FROM categorias WHERE nombre = ?");
        $stmt_check->bind_param("s", $nombreCategoria);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            throw new Exception('La categoría ya existe.');
        }
        $stmt_check->close();
        $stmt = $conexion->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombreCategoria);

        if (!$stmt->execute()) {
            throw new Exception('Error al crear la categoría.');
        }

        echo json_encode(['success' => true, 'message' => 'Categoría creada con éxito.']);
        $stmt->close();
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>

