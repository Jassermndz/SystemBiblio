<?php
session_start();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');

    if (!isset($_SESSION['usuario'])) {
        echo json_encode(['authenticated' => false]);
        exit();
    } else {
        echo json_encode(['authenticated' => true]);
        exit();
    }
}

if (!isset($_SESSION['usuario'])) {
    session_destroy();
    header("Location: /SystemBiblio/index.html");
    exit();
}
?>


