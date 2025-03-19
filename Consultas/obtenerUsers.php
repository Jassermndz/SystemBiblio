<?php
include '../conexiones/conexion.php';  

$tipo = "Estudiante";
$sql = "SELECT id, nombre, email, direccion, telefono, tipo, fecha_registro FROM usuarios";



$result = $conn->query($sql);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['nombre'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['telefono'] . "</td>";
    echo "<td>" . $row['direccion'] . "</td>";
    echo "<td>" . $row['tipo'] . "</td>";
    echo "<td>" . $row['fecha_registro'] . "</td>";
    echo "<td>
            <button class='btn btn-primary btn-update' data-id='" . $row['id'] . "'>Actualizar</button>
            <button class='btn btn-danger btn-delete' data-id='" . $row['id'] . "'>Eliminar</button>
          </td>";
    echo "</tr>";
}

} else {
    echo '<tr><td colspan="2">No hay registro de usuarios disponibles.</td></tr>';
}

$conn->close();
?>