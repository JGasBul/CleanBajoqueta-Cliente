<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar el correo del usuario de la URL (si está disponible)
    $correoUsuario = isset($_GET['correo']) ? $_GET['correo'] : "carlesmartif@gmail.com";
    $codigoAleatorio = $_GET['codigo'];

    $titulo = "Cambio de contraseña de tu cuenta BlueSky";

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
      <p><a href="' . $urlRedireccion . '" style="background-color: blue; color: white; padding: 10px 20px; text-decoration: none; display: inline-block;">Cambiar Contraseña</a></p>
    </body>
    </html>

    ';

    // Cabeceras para enviar el correo en formato HTML
    $cabeceras = "MIME-Version: 1.0" . "\r\n";
    $cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Cabecera adicional
    $cabeceras .= 'From: bajoquetabluesky@gmail.com' . "\r\n";

    

    // Enviar el correo
    if(mail($correoUsuario, $titulo, $mensaje, $cabeceras)) {
        include("../template/cabecera.php");
        echo '
        <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Recuperación de Contraseña</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        
    </head>

    <body>
        <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
            <div class="row">
                <div class="col-md-6 offset-md-3 shadow border-0 rounded-3">
                    <div class="card border-0">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Recuperación de Contraseña</h2>
                            <p class="text-center">Si has olvidado tu contraseña, no te preocupes. Simplemente haz clic en
                                el botón de abajo para recibir el correo de recuperación.</p>
                            <form method="post" class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Volver a enviar correo</button>
                            </form>
                        </div>

                        <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>
                            Correo enviado exitosamente a: <strong>' . htmlspecialchars($correoUsuario) . '</strong>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>

        
        ';
    } else {
        include("../template/cabecera.php");
        echo '
        <!DOCTYPE html> 
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Recuperación de Contraseña</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        <!-- Inicio Header -->
        <header>
            
        </header>
        <!-- Fin Header -->
    </head>

    <body>
        <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
            <div class="row">
                <div class="col-md-6 offset-md-3 shadow border-0 rounded-3">
                    <div class="card border-0">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Recuperación de Contraseña</h2>
                            <p class="text-center">Si has olvidado tu contraseña, no te preocupes. Simplemente haz clic en
                                el botón de abajo para recibir el correo de recuperación.</p>
                            <form method="post" class="d-flex justify-content-center">
                                
                            </form>

                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                Error al enviar el correo. Por favor, comprueba si has introducido correctamente el correo en la pantalla de iniciar sesión y que el correo
                                introducido exista.
                            </div>
                          </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
        
        ';
    }
} else {
    // Mostrar el formulario si no se ha enviado aún
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Recuperación de Contraseña</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        <!-- Inicio Header -->
        <header>
            <?php include("../template/cabecera.php"); ?>
        </header>
        <!-- Fin Header -->
    </head>

    <body>
        <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
            <div class="row">
                <div class="col-md-6 offset-md-3 shadow border-0 rounded-3">
                    <div class="card border-0">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Recuperación de Contraseña</h2>
                            <p class="text-center">Si has olvidado tu contraseña, no te preocupes. Simplemente haz clic en
                                el botón de abajo para recibir el correo de recuperación.</p>
                            <form method="post" class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Enviar correo de recuperación</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>

    <?php
}
?>