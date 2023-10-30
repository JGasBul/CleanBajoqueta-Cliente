<?php
//----------------------------------------------------------------
// Arnau Soler Tomás
//registro.php
//Gestiona la página del registro
//----------------------------------------------------------------

//Variables
$segundos_espera = 3; //tiempo de espera antes de redirigir al Login

//Iniciar conexión con la db
$conexionbd = new mysqli("localhost", "root", "", "bbdd_cleanbajoqueta");
$conexionbd->set_charset("utf8");

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

            $sql = $conexionbd->query("SELECT * FROM usuario WHERE email = '$email'");

            if ($datos = $sql->fetch_object()) {
                echo '<div class="alert alert-danger">Actualmente registrado. Intentelo con otro email</div>';

            } else {
                //Registramos Usuario
                $registrarUsuario = $conexionbd->query("INSERT INTO usuario (email, contraseña, nombreApellido)
                VALUES ('$email', '$contrasenia', '$nombreApellidos')");

                $registrarTelefono = $conexionbd->query("INSERT INTO telefono (email, telefono)
                VALUES ('$email', '$telefono')");

                //Si se pudo registrar, lo llevamos a la página de Login
                if ($registrarUsuario AND $registrarTelefono) {
                    echo '<div class="alert alert-success">Registro Completado</div>';
                    
                    //header("location:../user/login.php");
                    header('refresh:'.$segundos_espera.'; url=../user/login.php');
                } else {
                    echo '<div class="alert alert-danger">Hubo problemas al registrar el usuario</div>';
                }
            }
        } else {
            echo '<div class="alert alert-danger">Contraseña incorrecta</div>';
        }
    }
}

?>