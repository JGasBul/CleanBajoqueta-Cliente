<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar el correo del usuario de la URL (si está disponible)
    $correoUsuario = isset($_GET['correo']) ? $_GET['correo'] : "carlesmartif@gmail.com";
    $codigoAleatorio = $_GET['codigo'];

    $titulo = "Verificación de cuenta BlueSky";

    // URL a la que quieres que el botón redirija
    $urlRedireccion = "http://localhost/user/cambiarCon.php?correo=" . urlencode($correoUsuario) . "&codigo=" . $codigoAleatorio;

    // Crear el mensaje en formato HTML
    $mensaje = '
    <html>
    <head>
      <title></title>
    </head>
    <body>
      
      <p>Haz click en el siguiente botón para cambiar la contraseña</p>
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
        echo "Correo enviado a: " . htmlspecialchars($correoUsuario);
    }
    else{
        echo "Error al enviar el correo, comprueba si has introducido el correo al iniciar sesión";
    }
} else {
    // Mostrar el formulario si no se ha enviado aún
?>
    <form method="post">
        <button type="submit">Enviar correo</button>
    </form>
<?php
}
?>
