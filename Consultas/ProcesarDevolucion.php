<?php
include('../Conexiones/conexion.php'); // Asegúrate de que la conexión esté bien configurada

// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $idPrestamo = $_POST['id_prestamo'];
    $fechaDevolucion = $_POST['fecha_devolucion'];
    $descripcion = $_POST['descripcion'];

    // Depuración: Imprimir los datos recibidos
    error_log("Datos recibidos - id_prestamo: " . $idPrestamo . " fecha_devolucion: " . $fechaDevolucion . " descripcion: " . $descripcion);

    // Comprobar si los datos están completos
    if (empty($idPrestamo) || empty($fechaDevolucion) || empty($descripcion)) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
        exit;
    }

    // Comenzar la transacción
    mysqli_begin_transaction($conexion);

    try {
        // Insertar en la tabla Devoluciones (solo inserción en esta tabla)
        $queryDevolucion = "INSERT INTO devoluciones (id_prestamo, fecha_devolucion, observaciones) 
                            VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $queryDevolucion);
        
        if (!$stmt) {
            // Si la preparación de la consulta falla, mostrar el error
            error_log('Error al preparar la consulta: ' . mysqli_error($conexion)); // Log del error
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . mysqli_error($conexion)]);
            exit;
        }
        
        mysqli_stmt_bind_param($stmt, "iss", $idPrestamo, $fechaDevolucion, $descripcion);
        $exec = mysqli_stmt_execute($stmt);
        
        if (!$exec) {
            // Si la ejecución de la consulta falla, mostrar el error
            error_log('Error al ejecutar la consulta: ' . mysqli_error($conexion)); // Log del error
            echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta: ' . mysqli_error($conexion)]);
            exit;
        }

        // Confirmar la transacción
        mysqli_commit($conexion);

        // Respuesta de éxito
        echo json_encode(['success' => true, 'message' => 'Devolución procesada correctamente.']);
    } catch (Exception $e) {
        // Si ocurre un error, hacer rollback
        mysqli_rollBack($conexion);
        error_log('Error al procesar la devolución: ' . $e->getMessage()); // Log del error
        echo json_encode(['success' => false, 'message' => 'Error al procesar la devolución: ' . $e->getMessage()]);
    }
}
?>




