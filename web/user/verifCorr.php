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
      <title>Recuperación de Contraseña</title>
      <meta charset="UTF-8">
      <style>
        body {
          font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
          background-color: #e8f4f8;
          color: #333;
          text-align: center;
          padding: 50px;
        }
        .boton {
          background-color: #004a7c; 
          color: #FFFFFF;
          padding: 10px 20px;
          text-decoration: none;
          display: inline-block;
          border-radius: 4px;
          font-weight: bold;
          transition: background-color 0.3s ease;
        }
        .boton:hover {
          background-color: #003354; 
        }
        .contenido {
          background-color: #FFFFFF;
          padding: 30px;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
          display: inline-block;
          max-width: 600px;
          margin: auto;
        }
        .footer {
          font-size: 12px;
          color: #666;
          margin-top: 20px;
        }
        .logo {
          margin-bottom: 20px;
        }
    
        .ii a[href] {
        color: #FFFFFF;
    }
    .im {
        color: #161616;
    }
      </style>
    </head>
    <body>
      <div class="contenido">
        <div class="logo">
          
          <img src="https://i.ibb.co/dQdYFGZ/Blue-Sky-Logo-Nofondo.png" alt="Company Logo" width="150" />
        </div>
        <h1>Verificación de tu Cuenta BlueSky</h1>
        <p>Para verificar tu cuenta, por favor haz click en el botón de abajo:</p>
        <a href="' . $urlRedireccion . '" class="boton">Verificar Cuenta</a>
        <div class="footer">
          <p>Si no solicitaste este cambio, ignora este mensaje o contáctanos.</p>
          <p>&copy; ' . date("Y") . ' BlueSky. Todos los derechos reservados.</p>
        </div>
      </div>
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
    

