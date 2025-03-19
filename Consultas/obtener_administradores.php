<?php
include '../conexiones/conexion.php'; 

$sql = "SELECT usuario, rol FROM administradores";
$result = $conn->query($sql);

$admins = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}

echo json_encode($admins);

$conn->close();
?>

