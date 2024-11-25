<?php
// Iniciar sesión para verificar si el usuario es repartidor
session_start();

// Verificar si el usuario está autenticado como repartidor
if (!isset($_SESSION['repartidor_logged_in'])) {
    header("Location: loginRepartidor.php"); // Si no está logueado, redirigir al login
    exit();
}

include('header.php');
?>

<h2>Panel del Repartidor</h2>

<!-- Listado de paquetes asignados -->
<h3>Paquetes Asignados</h3>
<table border="1">
    <thead>
        <tr>
            <th>Número de Paquete</th>
            <th>Ubicación</th>
            <th>Estado</th>
            <th>Comentarios</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Conectar a la base de datos
        include('conectar.php');

        // Obtener todos los paquetes registrados
        $sql = "SELECT * FROM paquetes";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['numero_paquete'] . "</td>
                        <td>" . $row['ubicacion'] . "</td>
                        <td>" . $row['estado'] . "</td>
                        <td>" . htmlspecialchars($row['comentarios']) . "</td>
                        
                        <td>
                            <a href='cambiarEstado.php?id=" . $row['id'] . "'>Actualizar Estado</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay paquetes asignados.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
include('footer.php');
?>
