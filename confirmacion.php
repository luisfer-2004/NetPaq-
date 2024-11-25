<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include('conectar.php');

// Verificar si se ha recibido el ID del paquete
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Mostrar mensaje de confirmación con JavaScript
    echo "
        <script>
            if (confirm('¿Estás seguro de que deseas eliminar este paquete?')) {
                // Si el usuario confirma, redirige al script PHP para eliminar el paquete
                window.location.href = 'eliminar.php?id=$id';
            } else {
                // Si el usuario cancela, redirige al panel de administración
                window.location.href = 'admin.php';
            }
        </script>
    ";
} else {
    echo "ID no especificado.";
}
?>
