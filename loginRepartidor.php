<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    if ($usuario == 'repartidor' && $contraseña == 'repartidor123') {
        $_SESSION['repartidor_logged_in'] = true;
        header("Location: repartidor.php");
        exit();
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<h2>Login Repartidor</h2>
<form method="POST">
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required>
    
    <label for="contraseña">Contraseña:</label>
    <input type="password" id="contraseña" name="contraseña" required>
    
    <button type="submit">Iniciar sesión</button>
</form
