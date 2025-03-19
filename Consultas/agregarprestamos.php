<?php
include '../conexiones/conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario']; 
    $id_libro = $_POST['id_libro'];     
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $fecha_devolucion = $_POST['fecha_devolucion']; 

    $sql_usuario = "SELECT nombre FROM usuarios WHERE id = ?";
    $sql_libro = "SELECT titulo FROM libros WHERE id = ?";

    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_libro = $conn->prepare($sql_libro);

    $stmt_usuario->bind_param("i", $id_usuario);
    $stmt_libro->bind_param("i", $id_libro);

    $stmt_usuario->execute();
    $stmt_libro->execute();

    $result_usuario = $stmt_usuario->get_result();
    $result_libro = $stmt_libro->get_result();

    if ($result_usuario->num_rows > 0 && $result_libro->num_rows > 0) {
        $usuario = $result_usuario->fetch_assoc();
        $libro = $result_libro->fetch_assoc();

        $nombre_usuario = $usuario['nombre'];
        $titulo_libro = $libro['titulo'];

        $sql_insert = "INSERT INTO prestamos (id_libro, id_usuario, fecha_prestamo, fecha_devolucion, estado)
                       VALUES (?, ?, ?, ?, 'Prestado')";

        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iiss", $id_libro, $id_usuario, $fecha_prestamo, $fecha_devolucion);

        if ($stmt_insert->execute()) {
            echo "Préstamo agregado correctamente. Usuario: $nombre_usuario, Libro: $titulo_libro";
        } else {
            echo "Error al agregar el préstamo: " . $stmt_insert->error;
        }
    } else {
        echo "Usuario o libro no encontrado.";
    }

    $stmt_usuario->close();
    $stmt_libro->close();
    $stmt_insert->close();
} else {
    echo "Solicitud inválida.";
}
header("Location: ../SystemBiblio/Modulos/AgregarPrestamo.html");
$conn->close();
?>
