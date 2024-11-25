<?php
// Iniciar sesión para verificar si el usuario es administrador
session_start();

// Verificar si el usuario está autenticado como administrador
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php"); // Si no está logueado, redirigir al login
    exit();
}

include('header.php');
?>

<h2>Panel de Administración</h2>

<!-- Sección para agregar un nuevo paquete -->
<h3>Agregar Nuevo Paquete</h3>
<form method="POST" action="agregar.php">
    <!-- El número de paquete y estado no son visibles, se generan automáticamente -->
    <label for="ubicacion">Ubicación:</label>
    <input type="text" id="ubicacion" name="ubicacion" required>

    <label for="ubicacion_final">Iframe de Ubicación:</label>
    <textarea id="ubicacion_final" name="ubicacion_final" rows="4" cols="50" placeholder="Pegue aquí el iframe del mapa" required></textarea>

    <label for="correo_electronico">Correo:</label>
    <input type="text" id="correo_electronico" name="correo_electronico" required>


    <button type="submit" name="agregar">Agregar Paquete</button>
</form>

<!-- Listado de paquetes existentes -->
<h3>Paquetes Registrados</h3>
<table border="1">
    <thead>
        <tr>
            <th>Número de Paquete</th>
            <th>Ubicación</th>
            <th>Estado</th>
            <th>Comentarios</th>
            <th>Correo Electronico</th>
            <th>Vinculo del Iframe</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Conectar a la base de datos
        include('conectar.php');
        
        // Obtener todos los paquetes
        $sql = "SELECT * FROM paquetes";
        $resultado = $conn->query($sql);
        
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                // Mostrar solo el vínculo del iframe como texto
                echo "<tr>
                        <td>" . $row['numero_paquete'] . "</td>
                        <td>" . $row['ubicacion'] . "</td>
                        <td>" . $row['estado'] . "</td>
                        <td>" . $row['comentarios'] . "</td>
                        <td>" . $row['correo_Electronico'] . "</td> 
                        <td><a href='" . htmlspecialchars($row['ubicacion_final']) . "' target='_blank'>" . htmlspecialchars($row['ubicacion_final']) . "</a></td>
                        <td>
                            <a href='editar.php?id=" . $row['id'] . "'>Editar</a> | 
                            <a href='confirmacion.php?id=" . $row['id'] . "'>Eliminar</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No se encontraron paquetes registrados.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Incluir el pie de página
include('footer.php');
?>
