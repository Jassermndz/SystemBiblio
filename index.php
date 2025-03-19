<?php
// Ruta relativa dentro del servidor
$ruta = $_SERVER['DOCUMENT_ROOT'] . '/SystemBiblio/BiblioVirtual/index.html';

// Verifica si el archivo existe antes de redirigir
if (file_exists($ruta)) {
    header("Location: /SystemBiblio/BiblioVirtual/index.html");
    exit();
} else {
    echo "El archivo no existe.";
}
?>
