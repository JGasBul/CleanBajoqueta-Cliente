<?php
//----------------------------------------------------------------
//CleanBajoqueta
//registro.php
//Gestiona la página del registro
//----------------------------------------------------------------

//Clases
include("../clases/CifrarDescifrarAES.php");
include("../clases/TempData.php");

//Variables
$segundos_espera = 3; //tiempo de espera antes de redirigir al Login
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
$tempDataFile = 'tempFormData.txt';

//Iniciar conexión con la db

//Se consulta el contenido del POST
if (!empty($_POST["registrar"])) {
    $nombre = $_POST["nombreregistro"];
    $apellidos = $_POST["apellidosregistro"];
    $email = $_POST["emailregistro"];
    $telefono = $_POST["telefonoregistro"];
    $contrasenia = $_POST["contraseniaregistro"];
    $confirmarcontrasenia = $_POST["confirmarcontraseniaregistro"];
    //Comprobamos si sus campos estan vacios
    if (
        empty($_POST["nombreregistro"]) and
        empty($_POST["apellidosregistro"]) and
        empty($_POST["contraseniaregistro"]) and
        empty($_POST["confirmarcontraseniaregistro"]) and
        empty($_POST["emailregistro"]) and
        empty($_POST["telefonoregistro"]) and
        empty($_POST["customer_privacy"]) and
        $_POST["customer_privacy"] = "on"
    ) {
        $Formdata = array(0 => $nombre, 1 => $apellidos, 2 => $email, 3 => $telefono);

        $temp = new TempData($tempDataFile, json_encode($Formdata));
        $temp->putTempData();
        echo '<div class="alert alert-danger">Hay campos vacíos</div>';
    } else {
        //print("" . $nombre . "" . $apellidos . "" . $email . "" . $contrasenia . "" . $confirmarcontrasenia . "" . $telefono);

        /*Comprobamos si la contraseña es la misma en los campos 'contraseña' y 'confirmar contraseña'.
        Esto es un método de seguridad anti-Bot
        Si son iguales, procedemos a comprobar si existe actualmente el usuario en la BBDD
        */
        if ($contrasenia == $confirmarcontrasenia) {

            $nombreApellidos = $nombre . " " . $apellidos;

            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => "http://localhost:8080/user/getUserByEmail",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET"
                )
            );
            $headers = [
                'accept: applicaction/json',
                'email: ' . $email . ''
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $res = curl_exec($curl);
            $res = json_decode($res, true); //because of true, it's in an array
            $err = curl_error($curl);
            curl_close($curl);
            //$sql = $conexionbd->query("SELECT * FROM usuario WHERE email = '$email'");
            if ($res) {
                $Formdata = array(0 => $nombre, 1 => $apellidos, 2 => null, 3 => $telefono);

                $temp = new TempData($tempDataFile, json_encode($Formdata));
                $temp->putTempData();
                echo '<div class="alert alert-danger">Actualmente registrado. Intentelo con otro email</div>';
            } else {

                //Aqui capto el permiso de haber verificado el correo
                /*
                $permiso
                 if(verifico correcto){
                    $permiso = true;
                 }else{
                      $permiso = false;
                 }            
                */

                $permiso = true;
                //Se espera 30 segundos para continuar
                //sleep(30);
                if (!$permiso) {
                    echo '<div class="alert alert-danger">No esta verificado </div>';
                } else {

                    //Encriptamos datos
                    $cifrado = new CifrarDescifrarAES($contrasenia);
                    $encryptedPassword = $cifrado->encriptar();

                    //Registramos Usuario
                    $curl = curl_init();
                    curl_setopt_array(
                        $curl,
                        array(
                            CURLOPT_URL => "http://localhost:8080/user/insertUser",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST"
                        )
                    );
                    $headers = [
                        'accept: applicaction/json',
                        'Content-Type: application/json'
                    ];
                    $fields = [
                        'email' => $email,
                        'contraseña' => $encryptedPassword,
                        'nombreApellido' => $nombreApellidos,
                        'telefono' => $telefono
                    ];
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
                    $res = curl_exec($curl);
                    $res = json_decode($res, true); //because of true, it's in an array
                    $err = curl_error($curl);
                    curl_close($curl);


                    //Si se pudo registrar, lo llevamos a la página de Login
                    if (!$err) {

                            
                        //Enviar correo verificación--------------------------------------------------------------------


                        // Recuperar el correo del usuario de la URL (si está disponible)
                        $correoUsuario = $email;
                        
                        //Generar codigo aleatorio
                        
                        $length = 20; //Longitud del codigo
                        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                            $charactersLength = strlen($characters);
                            $codigoAleatorio = '';
                            for ($i = 0; $i < $length; $i++) {
                                $codigoAleatorio .= $characters[rand(0, $charactersLength - 1)];
                            }



                        //Titulo del correo
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
                        if (mail($correoUsuario, $titulo, $mensaje, $cabeceras)) {
                            echo "Correo enviado a: " . htmlspecialchars($correoUsuario);
                        } else {
                            echo "Error al enviar el correo, comprueba si has introducido el correo al iniciar sesión";
                            
                        }

                        



                        //-------------------------------------------------------

                        echo '<div class="alert alert-success">Registro Completado, porfavor verifica tu cuenta haciendo click en el correo que te hemos enviado</div>';

                        $temp = new TempData($tempDataFile, null);
                        $temp->eraseTempData();

                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function(){ window.location.href = "../user/login.php"; }, 7000);';
                        echo '</script>';
                    } else {
                        echo '<div class="alert alert-danger">Hubo problemas al registrar el usuario</div>';
                    }

                }
            }
        } else {
            //$Formdata = ("Nombre: ".$nombre.", Apellidos: ".$apellidos.", Email: ".$email.", Telefono: ".$telefono);
            $Formdata = array(0 => $nombre, 1 => $apellidos, 2 => $email, 3 => $telefono);

            $temp = new TempData($tempDataFile, json_encode($Formdata));
            $temp->putTempData();

            echo '<div class="alert alert-danger">La contraseña no coincide</div>';
        }
    }
}
//---------------------------------------------------------------------------------------------------------------------
// Comprobamos si la página ha sido refrescada
// Si lo ha sido, entonces rellenamos el formulario con los campos que tuviésemos
//---------------------------------------------------------------------------------------------------------------------
/*
if ($pageWasRefreshed) {
    $temp = new TempData($tempDataFile, null);
    $Formdata = json_decode($temp->getTempData(), true);

    if ($Formdata == null) {
        echo '<div class="alert alert-danger">Hubo problemas al redireccionar. Vaya manualmente al Login y pruebe
        si está registrado</div>';
    } else {
        // Como el PHP se ejecuta antes que el browser, y el JS después, para completar los campos necesitamos
        // un trozo de código de JS cuyos campos son validados previamente en PHP
        echo
            '<script>
                const formFields = document.getElementsByClassName("recoverField");
                formFields[0].value = "' . $Formdata[0] . '";
                formFields[1].value = "' . $Formdata[1] . '";
                formFields[2].value = "' . $Formdata[2] . '";
                formFields[3].value = "' . $Formdata[3] . '";
            </script>';
    }
}
*/
?>