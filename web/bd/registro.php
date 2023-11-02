<?php
//----------------------------------------------------------------
//CleanBajoqueta
//registro.php
//Gestiona la página del registro
//----------------------------------------------------------------

//Clases
include("../clases/CifrarDescifrarAES.php");

//Variables
$segundos_espera = 3; //tiempo de espera antes de redirigir al Login

//Iniciar conexión con la db

//Se consulta el contenido del POST
if (!empty($_POST["registrar"])) {
    //Comprobamos si sus campos estan vacios
    if (
        empty($_POST["nombreregistro"]) and
        empty($_POST["apellidosregistro"]) and
        empty($_POST["contraseniaregistro"]) and
        empty($_POST["confirmarcontraseniaregistro"]) and
        empty($_POST["emailregistro"]) and
        empty($_POST["telefonoregistro"])
    ) {
        echo '<div class="alert alert-danger">Los campos están vacíos</div>';
    } else {
        /*Comprobamos si la contraseña es la misma en los campos 'contraseña' y 'confirmar contraseña'.
        Esto es un método de seguridad anti-Bot
        Si son iguales, procedemos a comprobar si existe actualmente el usuario en la BBDD
        */
        if ($_POST["contraseniaregistro"] == $_POST["confirmarcontraseniaregistro"]) {
            $nombre = $_POST["nombreregistro"];
            $apellidos = $_POST["apellidosregistro"];
            $contrasenia = $_POST["contraseniaregistro"];
            $email = $_POST["emailregistro"];
            $telefono = $_POST["telefonoregistro"];

            $nombreApellidos = $nombre . " " . $apellidos;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://localhost:8080/login/getUserByEmail",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET"
            ));
            $headers = [
                'accept: applicaction/json',
                'email: '. $email .''
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $res = curl_exec($curl);
            $res = json_decode($res, true); //because of true, it's in an array
            $err = curl_error($curl);
            curl_close($curl);
            //$sql = $conexionbd->query("SELECT * FROM usuario WHERE email = '$email'");
            if (in_array( $email, $res)) {
                echo '<div class="alert alert-danger">Actualmente registrado. Intentelo con otro email</div>';
            } else {
                //Encriptamos datos

                $cifrado = new CifrarDescifrarAES($contrasenia);
                $encryptedPassword = $cifrado->encriptar();

                //Registramos Usuario
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://localhost:8080/login/insertUser",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST"
                ));
                $headers = [
                    'accept: applicaction/json',
                    'Content-Type: application/json'
                ];
                $fields = [
                    'email'      => $email,
                    'contraseña' => $encryptedPassword,
                    'nombreApellido'         => $nombreApellidos,
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
                    echo '<div class="alert alert-success">Registro Completado</div>';
                    //header("location:../user/login.php");
                    header('refresh:' . $segundos_espera . '; url=../user/login.php');
                } else {
                    echo '<div class="alert alert-danger">Hubo problemas al registrar el usuario</div>';
                }
            }
        } else {
            echo '<div class="alert alert-danger">Contraseña incorrecta</div>';
        }
    }
}
