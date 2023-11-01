<?php
//----------------------------------------------------------------
// Zaida Pastor González y Arnau Soler Tomás
//bd.php
//Gestiona el acceso del login y guarda el nombre del usuario
//----------------------------------------------------------------

//Clases
include("../clases/CifrarDescifrarAES.php");

//Guardamos el nomnre del usuario logeado en una vvble global
session_start();

//Iniciar conexión con la db
$conexionbd = new mysqli("localhost", "root", "", "bbdd_cleanbajoqueta");
$conexionbd->set_charset("utf8");

//Se consulta si el usuario pertenece a la bd y se obtiene su nombre
if (!empty($_POST["ingresar"])) {
    if (empty($_POST["usuariologin"]) and empty($_POST["passwordlogin"])) {
        echo '<div class="alert alert-danger">Los campos están vacíos</div>';
    } else {
        //Datos recogidos del Login
        $usuario = $_POST["usuariologin"];
        $contraseniaLogin = $_POST["contrasenialogin"];

        //Recogemos la contraseña del usuario
        $res = $conexionbd->query("SELECT contraseña FROM usuario WHERE email = '$usuario'");
        $contraseniaCifrada = $res->fetch_object()->contraseña;

        //Si existe...
        if ($contraseniaCifrada) {

            //Desciframos la contraseña
            $cifrado = new CifrarDescifrarAES($contraseniaCifrada);
            $contraseniaDesCifrada = $cifrado->desencriptar();

            //Si ambas contraseñas son iguales, consultamos los datos del usuario de la BBDD
            if ($contraseniaLogin == $contraseniaDesCifrada) {
                $sql = $conexionbd->query("SELECT * FROM usuario WHERE email = '$usuario' AND contraseña = '$contraseniaCifrada'");
                $nombreApellido = $conexionbd->query("SELECT nombreApellido FROM usuario");

                //Si está registrado...
                if ($datos = $sql->fetch_object()) {
                    // Almacenamos el nombre del usuario en una variable de sesión
                    $_SESSION['usuario'] = $datos->nombreApellido;

                    //Si existe el usuario, se ridirige a su pagina
                    header("location:../user/inicio.php");

                } else {
                    echo '<div class="alert alert-danger">No estás registrado en el servidor</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Contraseña incorrecta</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Hubo un problema con la contraseña o el usuario no existe</div>';
        }
    }
}

?>