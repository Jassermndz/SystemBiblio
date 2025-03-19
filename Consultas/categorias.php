<?php
include '../conexiones/conexion.php';  

$sql = "SELECT * FROM categorias ORDER BY id ASC"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nombre'] . "</td>
              </tr>";
    }
} else {
    echo '<tr><td colspan="2">No hay categorías disponibles.</td></tr>';
}

$conn->close();
?>
