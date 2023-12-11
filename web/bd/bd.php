<?php
//----------------------------------------------------------------
//CleanBajoqueta 
//bd.php
//Gestiona el acceso del login y guarda el nombre del usuario
//----------------------------------------------------------------

//Clases
include("../clases/CifrarDescifrarAES.php");

//Guardamos el nomnre del usuario logeado en una vvble global
session_start();

//Se consulta si el usuario pertenece a la bd y se obtiene su nombre
if (!empty($_POST["ingresar"])) {
    if (empty($_POST["usuariologin"]) and empty($_POST["passwordlogin"])) {
        echo '<div class="alert alert-danger">Los campos están vacíos</div>';
    } else {
        //Datos recogidos del Login
        $usuario = $_POST["usuariologin"];
        $contraseniaLogin = $_POST["contrasenialogin"];

        //Recogemos la contraseña del usuario
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
            'email: ' . $usuario . ''
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $res = curl_exec($curl);
        $res = json_decode($res, true); //because of true, it's in an array
        $err = curl_error($curl);
        curl_close($curl);
        //Si existe...
        if (!empty($res)) {
            $datos=$res[0];
            if (in_array($usuario, $res[0])) {
                $contraseniaCifrada = $res[0]["contraseña"];
                //Desciframos la contraseña
                $cifrado = new CifrarDescifrarAES($contraseniaCifrada);
                $contraseniaDesCifrada = $cifrado->desencriptar();

                //Si ambas contraseñas son iguales, consultamos los datos del usuario de la BBDD
                if ($contraseniaLogin == $contraseniaDesCifrada) {
                    $_SESSION['usuario'] = $datos["nombreApellido"];
                    $_SESSION['email'] = $datos["email"];
                    var_dump($datos["nombreApellido"]);
                    //Si existe el usuario, se ridirige a su pagina
                    header("location:../user/inicio.php");
                } else {
                    echo '<div class="alert alert-danger">Hubo un problema con la contraseña o el usuario no existe</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Hubo un problema con la contraseña o el usuario no existe</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Hubo un problema con la contraseña o el usuario no existe</div>';
        }
    }
}
