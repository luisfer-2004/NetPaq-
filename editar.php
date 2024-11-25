<?php
// Iniciar sesión y verificar acceso
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include('conectar.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Obtener la información del paquete
    $sql = "SELECT * FROM paquetes WHERE id = '$id'";
    $resultado = $conn->query($sql);
    
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
    } else {
        echo "Paquete no encontrado.";
        exit();
    }
} else {
    echo "ID no especificado.";
    exit();
}

if (isset($_POST['actualizar'])) {
    $numero_paquete = $_POST['numero_paquete'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $comentarios = $_POST['comentarios'];
    $ubicacion_final = $_POST['ubicacion_final'];
    $correo_electronico = $_POST['correo_Electronico'];

    // Actualizar el paquete
    $sql = "UPDATE paquetes SET numero_paquete='$numero_paquete', ubicacion='$ubicacion', estado='$estado', ubicacion_final='$ubicacion_final', correo_electronico='$correo_electronico' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Paquete actualizado correctamente.";
        header("Location: admin.php"); // Redirigir al panel de administración
    } else {
        echo "Error al actualizar el paquete: " . $conn->error;
    }
}
?>

<h2>Editar Paquete</h2>
<form method="POST">
    <label for="numero_paquete">Número de Paquete:</label>
    <input type="text" id="numero_paquete" name="numero_paquete" value="<?php echo $row['numero_paquete']; ?>" required>
    
    <label for="ubicacion">Ubicación:</label>
    <input type="text" id="ubicacion" name="ubicacion" value="<?php echo $row['ubicacion']; ?>" required>
    
    <label for="estado">Estado:</label>
    <select id="estado" name="estado" required>
        <option value="Entregado" <?php if ($row['estado'] == 'Entregado') echo 'selected'; ?>>Entregado</option>
        <option value="Pendiente" <?php if ($row['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
        <option value="No entregado" <?php if ($row['estado'] == 'No entregado') echo 'selected'; ?>>No entregado</option>
    </select>
    
    <label for="correo_Electronico">Correo Electrónico:</label>
    <input type="text" id="correo_Electronico" name="correo_Electronico" value="<?php echo $row['correo_Electronico']; ?>" required>
    
    <br>

    <label for="ubicacion_final">Iframe de Ubicación:</label>
    <textarea id="ubicacion_final" name="ubicacion_final" rows="4" cols="50" required><?php echo $row['ubicacion_final']; ?></textarea>

    <label for="Comentarios">Comentarios:</label>
    <textarea id="Comentarios" name="Comentarios" rows="4" cols="50"><?php echo $row['comentarios']; ?></textarea>

    <button type="submit" name="actualizar">Actualizar Paquete</button>
</form>

