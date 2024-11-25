<?php include('header.php'); ?>

<?php
// Verificar si hay un parámetro 'error' en la URL
if (isset($_GET['error'])) {
    $mensaje_error = htmlspecialchars($_GET['error']);  // Escapar el mensaje de error para seguridad
    echo "<script>alert('$mensaje_error');</script>";  // Mostrar mensaje emergente con el error
}
?>

<div class="tracking-container">
    <!-- Primera fila: Formulario y mapa -->
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
        <iframe id="mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10889169.289907414!2d-72.74993353603723!3d3.2925692395483788!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e15a43aae1594a3%3A0x9a0d9a04eff2a340!2sColombia!5e0!3m2!1ses-419!2sco!4v1731002120119!5m2!1ses-419!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<?php include('footer.php'); ?>
