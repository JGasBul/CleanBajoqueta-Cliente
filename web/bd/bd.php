
<?php
//----------------------------------------------------------------
// Zaida Pastor González
//bd.php
//Gestiona el acceso del login y guarda el nombre del usuario
//----------------------------------------------------------------

//Guardamos el nomnre del usuario logeado en una vvble global
session_start();

//Iniciar conexión con la db
$conexionbd = new mysqli("localhost", "root", "", "proyecto3a");
$conexionbd->set_charset("utf8");

//Se consulta si el usuario pertenece a la bd y se obtiene su nombre
if (!empty($_POST["ingresar"])) {
    if (empty($_POST["usuariologin"]) and empty($_POST["passwordlogin"])) {
        echo '<div class="alert alert-danger">Los campos están vacíos</div>';
    } else {
        $usuario = $_POST["usuariologin"];
        $contrasenia = $_POST["contrasenialogin"];
        $sql = $conexionbd->query("select * from usuarios where usuario = '$usuario' and contraseña = '$contrasenia'");
        $nombre = $conexionbd->query("select nombre FROM usuarios");

        if ($datos = $sql->fetch_object()) {
            // Almacenamos el nombre del usuario en una variable de sesión
            $_SESSION['usuario'] = $datos->nombre;

            //Si existe el usuario, se ridirige a su pagina
            header("location:../user/inicio.php");

        } else {
            echo '<div class="alert alert-danger">No estás registrado en el servidor</div>';
        }
    }
}

?>