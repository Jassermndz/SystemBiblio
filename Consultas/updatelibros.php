<?php
include '../conexiones/conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campos_requeridos = ['id', 'titulo', 'autor', 'editorial', 'isbn', 'categoria', 'cantidad_disponible'];
    foreach ($campos_requeridos as $campo) {
        if (empty($_POST[$campo])) {
            header("Location: ../Modulos/Libros.html?error=Todos%20los%20campos%20son%20obligatorios");
            exit;
        }
    }

    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $isbn = $_POST['isbn'];
    $categoria_id = $_POST['categoria'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $anio_publicacion = !empty($_POST['anio_publicacion']) ? $_POST['anio_publicacion'] : null;

    $titulo = htmlspecialchars($titulo);
    $autor = htmlspecialchars($autor);
    $editorial = htmlspecialchars($editorial);
    $isbn = htmlspecialchars($isbn);

    if (!empty($_FILES["imagen"]["name"])) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/SystemBiblio/uploads/";

        if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                header("Location: ../Modulos/Libros.html?error=No%20se%20pudo%20crear%20el%20directorio%20de%20imágenes");
                exit;
            }
        }

        $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_file_name;

        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check === false) {
            header("Location: ../Modulos/Libros.html?error=El%20archivo%20no%20es%20una%20imagen");
            exit;
        }

        if ($_FILES["imagen"]["size"] > 5 * 1024 * 1024) {
            header("Location: ../Modulos/Libros.html?error=El%20archivo%20es%20demasiado%20grande");
            exit;
        }

        $allowed_types = ["jpg", "jpeg", "png"];
        if (!in_array($imageFileType, $allowed_types)) {
            header("Location: ../Modulos/Libros.html?error=Solo%20se%20permiten%20imágenes%20JPG,%20JPEG%20o%20PNG");
            exit;
        }

        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            header("Location: ../Modulos/Libros.html?error=Hubo%20un%20error%20al%20subir%20la%20imagen");
            exit;
        }

        $rutaImagen = "uploads/" . $new_file_name;

        $sql_old = "SELECT imagen FROM Libros WHERE id=?";
        $stmt_old = $conn->prepare($sql_old);
        $stmt_old->bind_param("i", $id);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        if ($row = $result_old->fetch_assoc()) {
            $imagen_anterior = $_SERVER['DOCUMENT_ROOT'] . "/SystemBiblio/" . $row['imagen'];
            if (!empty($row['imagen']) && file_exists($imagen_anterior)) {
                unlink($imagen_anterior);
            }
        }

        $sql = "UPDATE libros SET titulo=?, autor=?, editorial=?, anio_publicacion=?, isbn=?, id_categoria=?, cantidad_disponible=?, imagen=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisiisi", $titulo, $autor, $editorial, $anio_publicacion, $isbn, $categoria_id, $cantidad_disponible, $rutaImagen, $id);
    } else {
        $sql = "UPDATE libros SET titulo=?, autor=?, editorial=?, anio_publicacion=?, isbn=?, id_categoria=?, cantidad_disponible=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisiis", $titulo, $autor, $editorial, $anio_publicacion, $isbn, $categoria_id, $cantidad_disponible, $id);
    }

    if ($stmt->execute()) {
        header("Location: ../Modulos/EditarLibros.html?success=Libro%20actualizado%20correctamente");
        exit();
    } else {
        header("Location: ../Modulos/EditarLibros.html?error=Error%20al%20actualizar%20el%20libro:%20" . urlencode($conn->error));
        exit();
    }
}

$conn->close();
?>



