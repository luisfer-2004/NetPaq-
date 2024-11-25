<?php
$fechaActual = new DateTime();
include('conectar.php');

$ubicacion_final = "";
$estado = "";
$comentarios = "";

if (isset($_POST['consultar'])) {
    $numero_paquete = $_POST['consultar'];

    $sql = "SELECT ubicacion_final, estado, comentarios FROM paquetes WHERE numero_paquete = '$numero_paquete'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $ubicacion_final = $row['ubicacion_final'];
        $estado = $row['estado'];
        $comentarios = $row['comentarios'];
        
    } else {
        header("Location: index.php?error=El paquete no existe");
        exit();
    }
}
?>

<?php include('header.php'); ?>
<?php include('EnviarCorreo.php'); ?>
<div class="tracking-container">
    <div class="consulta">
        <form method="POST" action="consulta.php">
            <label for="consultar">Consultar:</label>
            <input type="text" id="consultar" name="consultar" required placeholder="Número de envío">
            <button type="submit">Consultar</button>
        </form>
        <p>Ingrese el número de envío asignado para consultar el estado actual de su paquete.</p>
    </div>

<div class="mapa-seguimiento">
    <h3>Ubicación Actual del Paquete</h3>
    <?php
    if ($ubicacion_final) {
        echo $ubicacion_final;
    } else {
        echo "<p>Paquete no encontrado.</p>";
    }
    ?>
    </div>
</div>
<div class="linea-tiempo-horizontal">
    <h3>Recorrido del Paquete</h3>
    <h3>Estado: </h3>
    <?php
    if ($estado === "No entregado") {
        echo $estado . "<br>" . "Comentario: ". $comentarios;
    } else {
        echo $estado;
    }
    ?>
    <div class="linea">
        <div class="punto activo" data-fecha="<?= $fechaActual->modify('-4 day')->format("d/m/Y") ?>">Bodega de Origen</div>
        <div class="punto activo" data-fecha="<?= $fechaActual->modify('+1 day')->format("d/m/Y") ?>">En tránsito</div>
        <div class="punto activo" data-fecha="<?= $fechaActual->modify('+1 day')->format("d/m/Y") ?>">Centro de Distribución</div>
        <div class="punto activo" data-fecha="<?= $fechaActual->modify('+1 day')->format("d/m/Y") ?>">En tránsito</div>
        <?php if ($estado === "Entregado") { ?>
            <div class="punto activo" data-fecha="<?= $fechaActual->modify('+1 day')->format("d/m/Y") ?>">Entrega Final</div>
        <?php } else { ?>
            <div class="punto" data-fecha="EN ESPERA">Entrega Final</div>
        <?php } ?>
    </div>
</div>


<?php include('footer.php'); ?>
