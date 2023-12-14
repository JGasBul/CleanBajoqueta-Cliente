<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar el correo del usuario de la URL (si está disponible)
    $correoUsuario = isset($_GET['correo']) ? $_GET['correo'] : "Este correo no esta verificado, porfavor verificalo";
    $codigoAleatorio = $_GET['codigo'];
    $correcto = false;
    $verificado = null;

    //MIRAR SI ESTA SIN VERIFICAR

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost:8080/user/getUserByEmail",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
    ));
    $headers = [
        'accept: applicaction/json',
        'email: ' . $correoUsuario . ''
    ];
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $res = curl_exec($curl);
    $res = json_decode($res, true); //because of true, it's in an array
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($verificado!=null){
    $verificado = $res[0]["verificado"];
    }
    
    if ($verificado == 1) {
       
        //HACER UPDATE DEL TOKEN --------------------------------

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => "http://localhost:8080/user/updateUserByEmail",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT"
            )
        );

        // Agregar el email del usuario en el header
        $headers = [
            'accept: application/json',
            'Content-Type: application/json',
            'email: ' . $correoUsuario // Asegúrate de que $correoUsuario contenga el email correcto
        ];

        // Body con los cambios a realizar, en este caso, actualizar el token
        $fields = [
            'token' => $codigoAleatorio, // Asegúrate de que $codigoAleatorio contenga el token correcto

        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        $res = curl_exec($curl);
        $res = json_decode($res, true); // Decodificar la respuesta
        $err = curl_error($curl);
        curl_close($curl);
        $correcto = true;
    }
    if ($verificado == 0 & $verificado==null) {
        echo '<!DOCTYPE html> 
        <html lang="es">
    
        <head>
            <meta charset="UTF-8">
            <title>Recuperación de Contraseña</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/bootstrap.min.css" />
            <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
            <link rel="stylesheet" href="../css/letra.css">
    
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
                                    Tu correo no esta verificado o el usuario no existe, porfavor comprueba tu bandeja de entrada.
                                </div>
                                </div>
    
                                <a class="btn btn-primary" href="../user/login.php">Volver</a>

    
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    
        </html>';
      die();
    }
    





    $titulo = "Cambio de contraseña de tu cuenta BlueSky";

    // URL a la que quieres que el botón redirija
    $urlRedireccion = "http://localhost/user/recuperarContrasenya.php?correo=" . urlencode($correoUsuario) . "&codigo=" . $codigoAleatorio;

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



    if (mail($correoUsuario, $titulo, $mensaje, $cabeceras)) {
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
        <link rel="stylesheet" href="../css/letra.css">

        
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
        <link rel="stylesheet" href="../css/letra.css">

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
                                Tu correo no esta verificado, porfavor comprueba tu bandeja de entrada.
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
        <link rel="stylesheet" href="../css/letra.css">

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