<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$fechaActual = new DateTime();
require 'vendor/autoload.php';
include('conectar.php');

// Verificar si el número de paquete ha sido pasado correctamente
if (isset($_POST['consultar']) || isset($_GET['numero_paquete'])) {
    // Se obtiene el número de paquete desde el formulario o la URL
    $numero_paquete = isset($_POST['consultar']) ? $_POST['consultar'] : $_GET['numero_paquete'];

    // Realizar la consulta para obtener los detalles del paquete
    $sql = "SELECT ubicacion_final, estado, comentarios, correo_Electronico FROM paquetes WHERE numero_paquete = '$numero_paquete'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // Si el paquete existe, obtener los detalles
        $row = $resultado->fetch_assoc();
        $ubicacion_final = $row['ubicacion_final'];
        $estado = $row['estado'];
        $comentarios = $row['comentarios'];
        $correo_electronico = $row['correo_Electronico'];

        // Verificar si se obtuvo un correo electrónico
        if (!empty($correo_electronico)) {
            // Crear el objeto PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'netpaq273@gmail.com';
                $mail->Password = 'ypxr pxhg fpsf pdcc';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Remitente
                $mail->setFrom('netpaq273@gmail.com', 'Netpaq');
                // Destinatario
                $mail->addAddress($correo_electronico, 'Destinatario');

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Informacion Paquete';
                $mail->Body = 'Numero Paquete: '. $numero_paquete .'<br>Estado: ' . $estado . '<br>Bodega Origen: ' . $fechaActual->modify('-4 day')->format("d/m/Y") . 
                '<br>En tránsito: ' . $fechaActual->modify('+1 day')->format("d/m/Y") . 
                '<br>Centro de Distribución: ' . $fechaActual->modify('+1 day')->format("d/m/Y") . 
                '<br>En tránsito: ' . $fechaActual->modify('+1 day')->format("d/m/Y");

                if ($estado === "Entregado") {
                $mail->Body .= '<br>Entrega Final: ' . $fechaActual->modify('+1 day')->format("d/m/Y") . '<br>¡El paquete ha sido entregado correctamente!<br>';
                } else {
                $mail->Body .= '<br>Entrega Final: ' . "En Espera" . '<br>El paquete aún no ha sido entregado.<br>';
                }

$mail->Body .= '<br>Comentarios: ' . $comentarios;

                // Enviar correo
                $mail->send();
            } catch (Exception $e) {
            }
        } 
    } 
}
?>
