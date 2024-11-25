<?php
session_start();
include('conectar.php');

// Verificar si el usuario es repartidor
if (!isset($_SESSION['repartidor_logged_in'])) {
    header("Location: loginRepartidor.php");
    exit();
}

// Verificar si se ha enviado un ID de paquete
if (!isset($_GET['id'])) {
    echo "ID de paquete no especificado.";
    exit();
}

$paquete_id = intval($_GET['id']);

// Obtener los datos del paquete actual
$sql = "SELECT * FROM paquetes WHERE id = $paquete_id";
$resultado = $conn->query($sql);
if ($resultado->num_rows == 0) {
    echo "Paquete no encontrado.";
    exit();
}

$paquete = $resultado->fetch_assoc();

// Actualizar los comentarios si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentarios = isset($_POST['comentarios']) ? $_POST['comentarios'] : null;

    // Si el estado es "Entregado", solo se actualizan los comentarios
    if ($paquete['estado'] === 'Entregado') {
        $sql_update = "UPDATE paquetes SET comentarios = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param('si', $comentarios, $paquete_id);
    } else {
        $estado = $_POST['estado'];
        $sql_update = "UPDATE paquetes SET estado = ?, comentarios = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param('ssi', $estado, $comentarios, $paquete_id);
    }

    if ($stmt->execute()) {
        echo "Datos actualizados exitosamente.";
        header("Location: repartidor.php");
        exit();
    } else {
        echo "Error al actualizar los datos.";
    }
}
?>

<h2>Actualizar Estado del Paquete</h2>
<form method="POST">
    <label for="estado">Estado:</label>
    <select id="estado" name="estado" <?php if ($paquete['estado'] === 'Entregado') echo 'disabled'; ?> required>
        <option value="Entregado" <?php if ($paquete['estado'] === 'Entregado') echo 'selected'; ?>>Entregado</option>
        <option value="Pendiente" <?php if ($paquete['estado'] === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
        <option value="No entregado" <?php if ($paquete['estado'] === 'No entregado') echo 'selected'; ?>>No entregado</option>
    </select>

    <div id="comentarios_seccion">
        <label for="comentarios">Comentarios:</label>
        <textarea id="comentarios" name="comentarios" rows="4" cols="50"><?php echo htmlspecialchars($paquete['comentarios']); ?></textarea>
    </div>

    <button type="submit">Actualizar</button>
</form>

<script>
    // Deshabilitar selección de estado si está en "Entregado"
    const estadoSelect = document.getElementById('estado');
    const comentariosSeccion = document.getElementById('comentarios_seccion');

    if (estadoSelect.value === 'Entregado') {
        estadoSelect.disabled = true;
    }
</script>
