<?php

    // Recuperar el correo del usuario de la URL (si está disponible)
    $correoUsuario = isset($_GET['correo']) ? $_GET['correo'] : "carlesmartif@gmail.com";
    $codigoAleatorio = $_GET['codigo'];

    $titulo = "Verificación de cuenta BlueSky";

    // URL a la que quieres que el botón redirija
    $urlRedireccion = "http://localhost/user/correoVerificado.php?correo=" . urlencode($correoUsuario) . "&codigo=" . $codigoAleatorio;

    // Crear el mensaje en formato HTML
    $mensaje = '
    <html>
    <head>
      <title></title>
    </head>
    <body>
      
      <p>Haz click en el siguiente botón para verificar tu cuenta</p>
      <p><a href="' . $urlRedireccion . '" style="background-color: blue; color: white; padding: 10px 20px; text-decoration: none; display: inline-block;">Verificar Cuenta</a></p>
    </body>
    </html>
    ';

    // Cabeceras para enviar el correo en formato HTML
    $cabeceras = "MIME-Version: 1.0" . "\r\n";
    $cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Cabecera adicional
    $cabeceras .= 'From: bajoquetabluesky@gmail.com' . "\r\n";

    // Enviar el correo
    if(mail($correoUsuario, $titulo, $mensaje, $cabeceras)){
        include("../template/cabecera.php");
        echo '<div class="alert alert-success d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>
            Correo enviado exitosamente a: <strong>' . htmlspecialchars($correoUsuario) . '</strong>
        </div>';
    }
    else{
        include("../template/cabecera.php");
        echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div>
            Error al enviar el correo. Por favor, comprueba si has introducido correctamente el correo en la pantalla de registro.
        </div>
      </div>';
    }

?>
    

