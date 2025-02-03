<?php
include '../conexiones/conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campos_requeridos = ['id', 'titulo', 'autor', 'editorial', 'isbn', 'categoria', 'cantidad_disponible'];
    foreach ($campos_requeridos as $campo) {
        if (empty($_POST[$campo])) {
            echo json_encode(["error" => "Todos los campos son obligatorios."]);
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
                echo json_encode(["error" => "No se pudo crear el directorio de imágenes."]);
                exit;
            }
        }

        $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_file_name;

        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check === false) {
            echo json_encode(["error" => "El archivo no es una imagen."]);
            exit;
        }

        if ($_FILES["imagen"]["size"] > 5 * 1024 * 1024) {
            echo json_encode(["error" => "El archivo es demasiado grande."]);
            exit;
        }

        $allowed_types = ["jpg", "jpeg", "png"];
        if (!in_array($imageFileType, $allowed_types)) {
            echo json_encode(["error" => "Solo se permiten imágenes JPG, JPEG o PNG."]);
            exit;
        }

        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            echo json_encode(["error" => "Hubo un error al subir la imagen."]);
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


        $sql = "UPDATE Libros SET titulo=?, autor=?, editorial=?, anio_publicacion=?, isbn=?, id_categoria=?, cantidad_disponible=?, imagen=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisiisi", $titulo, $autor, $editorial, $anio_publicacion, $isbn, $categoria_id, $cantidad_disponible, $rutaImagen, $id);
    } else {
        $sql = "UPDATE Libros SET titulo=?, autor=?, editorial=?, anio_publicacion=?, isbn=?, id_categoria=?, cantidad_disponible=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisiis", $titulo, $autor, $editorial, $anio_publicacion, $isbn, $categoria_id, $cantidad_disponible, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error al actualizar el libro: " . $conn->error]);
    }
}

$conn->close();
?>



