<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include('conectar.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Eliminar el paquete
    $sql = "DELETE FROM paquetes WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Paquete eliminado correctamente.";
        header("Location: admin.php"); // Redirigir al panel de administración
    } else {
        echo "Error al eliminar el paquete: " . $conn->error;
    }
} else {
    echo "ID no especificado.";
}
?>
