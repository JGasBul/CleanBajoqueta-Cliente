<?php

//Clases
include("../clases/CifrarDescifrarAES.php");

//Variables
$segundos_espera = 3;

//Iniciar conexión con la db
$conexionbd = new mysqli("localhost", "root", "", "bbdd_cleanbajoqueta");
$conexionbd->set_charset("utf8");

//Se consulta el contenido del PUT
if (!empty($_POST["cambiarContrasenya"])) {
   
    //Comprobamos si sus campos estan vacios
    if (
        empty($_POST["emailRec"]) && empty($_POST["contraseniaRec"])
        
    ) {
        echo '<div class="alert alert-danger">Los campos están vacíos</div>';
        
    } else {

        $email = isset($_GET['correo']) ? $_GET['correo'] : 'No se proporcionó correo';
        $contraseniaNueva = $_POST["contraseniaRec"];
        $contraseniaNuevaR = $_POST["contraseniaRec2"];


        $sqlEmail = $conexionbd->query("SELECT * FROM usuario WHERE email = '$email'");

        if (!$datos = $sqlEmail->fetch_object()) {
            echo '<div class="alert alert-danger">No existe este correo</div>';
            
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
            //Se espera 30 segundos para obetener la verificacion
            //sleep(30);
            if (!$permiso) {
                echo '<div class="alert alert-danger">No esta verificado </div>';
            } else {

                if($contraseniaNueva == $contraseniaNuevaR){

                $cifrado = new CifrarDescifrarAES($contraseniaNueva);
                $encryptedPassword = $cifrado->encriptar();

                $sqlCambiar = "UPDATE usuario SET contraseña = '$encryptedPassword' WHERE email = '$email'";
                $cambiarContrasenya = mysqli_query($conexionbd, $sqlCambiar);

                if ($cambiarContrasenya) {
                    echo '<div class="alert alert-success">Contraseña Cambiada</div>';
                    //header('refresh:' . $segundos_espera . '; url=../user/login.php');
                    
                } else {
                    echo '<div class="alert alert-danger">Hubo problemas al cambiar la contraseña</div>';
                    
                }
            }else{
                echo '<div class="alert alert-danger">Las contraseñas no coinciden</div>';
            }

            }
        }

    }
}

?>