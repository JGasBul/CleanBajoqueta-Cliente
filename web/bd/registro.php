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

    if
    (
        empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || empty($contrasenia) || empty($confirmarcontrasenia)
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
                    CURLOPT_URL => "http://localhost:8080/login/getUserByEmail",
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
            if (in_array($email, $res)) {
                echo '<div class="alert alert-danger">Actualmente registrado. Intentelo con otro email</div>';
            } else {
                //Encriptamos datos

                $cifrado = new CifrarDescifrarAES($contrasenia);
                $encryptedPassword = $cifrado->encriptar();

                //Registramos Usuario
                $curl = curl_init();
                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL => "http://localhost:8080/login/insertUser",
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
                    echo '<div class="alert alert-success">Registro Completado</div>';

                    $temp = new TempData($tempDataFile, null);
                    $temp->eraseTempData();

                    header('refresh:' . $segundos_espera . '; url=../user/login.php');
                } else {
                    echo '<div class="alert alert-danger">Hubo problemas al registrar el usuario</div>';
                }
            }
        } else {
            //$Formdata = ("Nombre: ".$nombre.", Apellidos: ".$apellidos.", Email: ".$email.", Telefono: ".$telefono);
            $Formdata = array(0 => $nombre, 1 => $apellidos, 2 => $email, 3 => $telefono);
            ;

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
if ($pageWasRefreshed) {
    $temp = new TempData($tempDataFile, null);
    $Formdata = json_decode($temp->getTempData(), true);

    if ($Formdata == null) {
        echo '<div class="alert alert-danger">Hubo problemas al redireccionar. Vaya manualmente al Login y pruebe
        si está registrado</div>';
    } 
    else {
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
?>