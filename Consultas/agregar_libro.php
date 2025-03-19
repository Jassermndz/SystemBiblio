<?php
include '../conexiones/conexion.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['titulo']) || empty($_POST['autor']) || empty($_POST['editorial']) || empty($_POST['anio_publicacion']) || empty($_POST['isbn']) || empty($_POST['categoria']) || empty($_POST['cantidad_disponible']) || empty($_POST['estanteria'])) {
        echo json_encode(["success" => false, "error" => "Todos los campos son obligatorios."]);
        exit();
    }

    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $anio_publicacion = $_POST['anio_publicacion'];
    $isbn = $_POST['isbn'];
    $categoria_id = $_POST['categoria'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $estanteria = $_POST['estanteria'];

    if (empty($categoria_id)) {
        echo json_encode(["success" => false, "error" => "Debe seleccionar una categoría."]);
        exit();
    }

    $image_dir = $_SERVER['DOCUMENT_ROOT'] . "/SystemBiblio/uploads/";
    $pdf_dir = $_SERVER['DOCUMENT_ROOT'] . "/SystemBiblio/uploads/pdfs/";

    if (!file_exists($image_dir)) {
        mkdir($image_dir, 0777, true);
    }
    if (!file_exists($pdf_dir)) {
        mkdir($pdf_dir, 0777, true);
    }

    $rutaImagen = null;
    if ($_FILES["imagen"]["error"] == 0) {
        $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
        $new_image_name = uniqid() . '.' . $imageFileType;
        $target_image = $image_dir . $new_image_name;

        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check === false) {
            echo json_encode(["success" => false, "error" => "El archivo no es una imagen."]);
            exit();
        }

        $max_size = 5 * 1024 * 1024;
        if ($_FILES["imagen"]["size"] > $max_size) {
            echo json_encode(["success" => false, "error" => "El archivo de imagen es demasiado grande."]);
            exit();
        }

        $allowed_types = ["jpg", "jpeg", "png"];
        if (!in_array($imageFileType, $allowed_types)) {
            echo json_encode(["success" => false, "error" => "Solo se permiten imágenes JPG, JPEG o PNG."]);
            exit();
        }

        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_image)) {
            echo json_encode(["success" => false, "error" => "Hubo un error al subir la imagen."]);
            exit();
        }

        $rutaImagen = "uploads/" . $new_image_name;
    }

    $rutaPDF = null;
    if ($_FILES["pdf"]["error"] == 0) {
        $pdfFileType = strtolower(pathinfo($_FILES["pdf"]["name"], PATHINFO_EXTENSION));
        $new_pdf_name = uniqid() . '.' . $pdfFileType;
        $target_pdf = $pdf_dir . $new_pdf_name;

        $max_pdf_size = 10 * 1024 * 1024;
        if ($_FILES["pdf"]["size"] > $max_pdf_size) {
            echo json_encode(["success" => false, "error" => "El archivo PDF es demasiado grande."]);
            exit();
        }

        if ($pdfFileType != "pdf") {
            echo json_encode(["success" => false, "error" => "Solo se permiten archivos PDF."]);
            exit();
        }

        if (!move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_pdf)) {
            echo json_encode(["success" => false, "error" => "Hubo un error al subir el archivo PDF."]);
            exit();
        }

        $rutaPDF = "uploads/pdfs/" . $new_pdf_name;
    }

    $sql = "INSERT INTO libros (titulo, autor, editorial, anio_publicacion, isbn, id_categoria, cantidad_disponible, estanteria, imagen, pdf) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiisss", $titulo, $autor, $editorial, $anio_publicacion, $isbn, $categoria_id, $cantidad_disponible, $estanteria, $rutaImagen, $rutaPDF);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}

$conn->close();
?>







