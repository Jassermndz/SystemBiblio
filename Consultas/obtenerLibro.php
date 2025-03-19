<?php
include '../conexiones/conexion.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Consulta para obtener el nombre del archivo PDF del libro
    $sql = "SELECT pdf FROM libros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($pdf);
        $stmt->fetch();

        $relativePdfPath = $pdf;  

        $pdfPath = $_SERVER['DOCUMENT_ROOT'] . '/SystemBiblio/' . $relativePdfPath;  

        // Muestra la ruta completa para depuración (esto es opcional)
        // echo "<p>Ruta completa del archivo PDF: " . $pdfPath . "</p>";

        if (file_exists($pdfPath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($pdfPath) . '"');
            readfile($pdfPath);  
            exit;
        } else {
            echo "<p>El archivo PDF no se encuentra disponible en la ruta: " . $pdfPath . "</p>";
        }
    } else {
        echo "<p>Libro no encontrado.</p>";
    }

    $stmt->close();
} else {
    echo "<p>ID no proporcionado.</p>";
}

$conn->close();
?>








