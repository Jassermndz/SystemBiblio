<?php
include '../conexiones/conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['titulo']) || empty($_POST['autor']) || empty($_POST['editorial']) || empty($_POST['anio_publicacion']) || empty($_POST['isbn']) || empty($_POST['categoria']) || empty($_POST['cantidad_disponible']) || empty($_POST['estanteria'])) {
        die("Todos los campos son obligatorios.");
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
        die("Debe seleccionar una categoría.");
    }

    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/SystemBiblio/uploads/";

   
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);  
    }

  
    if ($_FILES["imagen"]["error"] == 0) {
        $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $imageFileType;  
        $target_file = $target_dir . $new_file_name;

        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check === false) {
            die("El archivo no es una imagen.");
        }

        $max_size = 5 * 1024 * 1024;  
        if ($_FILES["imagen"]["size"] > $max_size) {
            die("El archivo es demasiado grande.");
        }

        $allowed_types = ["jpg", "jpeg", "png"];
        if (!in_array($imageFileType, $allowed_types)) {
            die("Solo se permiten imágenes JPG, JPEG o PNG.");
        }

        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            die("Hubo un error al subir la imagen.");
        }
        
        $rutaImagen = "uploads/" . $new_file_name; 
    } else {
  
        $rutaImagen = null;
    }

   
    $sql = "INSERT INTO Libros (titulo, autor, editorial, anio_publicacion, isbn, id_categoria, cantidad_disponible, estanteria, imagen) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssiss", $titulo, $autor, $editorial, $anio_publicacion, $isbn, $categoria_id, $cantidad_disponible, $estanteria, $rutaImagen);


    if ($stmt->execute()) {
        header("Location: ../Modulos/AgregarLibros.html?success=true");
        exit();
    } else {
        echo "<script>alert('Error al agregar el libro: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>






