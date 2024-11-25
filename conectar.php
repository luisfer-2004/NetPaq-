<?php
$servidor = "localhost"; // El servidor MySQL, generalmente 'localhost'
$usuario = "root"; // Tu usuario MySQL
$contraseña = ""; // Tu contraseña MySQL
$base_de_datos = "paquetes"; // El nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servidor, $usuario, $contraseña, $base_de_datos);

// Comprobar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}
?>
