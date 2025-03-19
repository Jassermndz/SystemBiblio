<?php
include '../conexiones/conexion.php';  

$tipo = "Profesores";
$sql = "SELECT u.id, u.nombre, u.email, u.telefono, u.direccion, l.titulo from usuarios u
INNER JOIN prestamos p on u.id = p.id_usuario
INNER JOIN libros l on l.id = p.id_libro
WHERE tipo = '$tipo' order by u.id asc;";




$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc())    {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['telefono'] . "</td>
                <td>" . $row['direccion'] . "</td>
                <td>" . $row['titulo'] . "</td>
              </tr>";
    }
} else {
    echo '<tr><td colspan="2">No hay registro de profesores disponibles.</td></tr>';
}

$conn->close();
?>
