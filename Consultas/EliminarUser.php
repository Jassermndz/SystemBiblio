<?php
include '../conexiones/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: editarLibro.php?success=Usuario eliminado correctamente");
    } else {
        header("Location: editarLibro.php?error=Error al eliminar usuario");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: editarLibro.php?error=No se especificó el ID del usuario");
}
?>
