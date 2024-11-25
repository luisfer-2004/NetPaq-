<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    if ($usuario == 'admin' && $contraseña == 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<h2>Login de Administrador</h2>
<form method="POST">
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required>
    
    <label for="contraseña">Contraseña:</label>
    <input type="password" id="contraseña" name="contraseña" required>
    
    <button type="submit">Iniciar sesión</button>
</form
