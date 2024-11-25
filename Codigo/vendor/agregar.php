<?php
// Iniciar sesión para verificar si el usuario es administrador
session_start();

// Verificar si el usuario está autenticado como administrador
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php"); // Si no está logueado, redirigir al login
    exit();
}

// Conectar a la base de datos
include('conectar.php');

// Función para generar un número aleatorio único de paquete
function generarNumeroPaquete() {
    global $conn;
    do {
        // Generar un número aleatorio de 1 a 10 cifras
        $numero_paquete = strval(rand(1000000000, 9999999999)); // Genera números entre 1 a 10 cifras
        // Verificar si el número ya existe en la base de datos
        $sql = "SELECT id FROM paquetes WHERE numero_paquete = '$numero_paquete'";
        $resultado = $conn->query($sql);
    } while ($resultado->num_rows > 0); // Repetir si el número ya existe

    return $numero_paquete;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    // Obtener los valores del formulario
    $ubicacion = $_POST['ubicacion'];
    $ubicacion_final = $_POST['ubicacion_final'];
    $correo_electronico = $_POST['correo_electronico'];

    // Generar un número aleatorio único para el paquete
    $numero_paquete = generarNumeroPaquete();

    // El estado siempre será "Pendiente"
    $estado = 'Pendiente';

    // Consulta para agregar el nuevo paquete a la base de datos
    $sql = "INSERT INTO paquetes (numero_paquete, ubicacion, estado, ubicacion_final, correo_electronico) 
            VALUES ('$numero_paquete', '$ubicacion', '$estado', '$ubicacion_final', '$correo_electronico')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir al panel de administración con un mensaje de éxito
        header("Location: admin.php?success=Paquete agregado exitosamente");
        exit();
    } else {
        // Redirigir con un mensaje de error
        header("Location: admin.php?error=Error al agregar el paquete");
        exit();
    }
}

include('header.php');
?>

<h2>Panel de Administración</h2>

<!-- Sección para agregar un nuevo paquete -->
<h3>Agregar Nuevo Paquete</h3>
<form method="POST" action="agregar.php">
    <label for="ubicacion">Ubicación:</label>
    <input type="text" id="ubicacion" name="ubicacion" required>

    <label for="ubicacion_final">Iframe de Ubicación:</label>
    <textarea id="ubicacion_final" name="ubicacion_final" rows="4" cols="50" placeholder="Pegue aquí el iframe del mapa" required></textarea>

    <label for="correo_Electronico">Correo Electrónico:</label>
    <input type="email" id="correo_Electronico" name="correo_Electronico" required>

    <button type="submit" name="agregar">Agregar Paquete</button>
</form>

