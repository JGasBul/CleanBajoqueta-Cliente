<?php
//Conexion con la base de datos
$conn = mysqli_connect("localhost", "root", "", "bbdd_cleanbajoqueta");

//Incluir la libreria para encryptacion y dencryptacion de la contraseña
include("../clases/CifrarDescifrarAES.php");

//Si me llega el metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    //Si contiene datos en la variable que me llega
    if (isset($data['emailTelefono']) && isset($data['contrasenia'])) {
        $emailTelefono = $data['emailTelefono'];
        $contrasenia = $data['contrasenia'];

        $sqlpassword = "SELECT usuario.contraseña
        FROM usuario
        INNER JOIN telefono ON usuario.email = telefono.email
        WHERE usuario.email = '$emailTelefono' OR telefono.telefono = '$emailTelefono'";

        //Consulto si existe contraseña de tal correo
        $res = mysqli_query($conn, $sqlpassword);        

        if ($res && $row = mysqli_fetch_assoc($res)) {
            
            //Si existe, decifro la contraseña
            $contraseniaCifrada = $row['contraseña'];
            $cifrado = new CifrarDescifrarAES($contraseniaCifrada);
            $contraseniaDesCifrada = $cifrado->desencriptar();

            //Comparo la contraseña descifrada con la que se introduce el usuario
            if ($contrasenia == $contraseniaDesCifrada) {            

                //Si son iguales, hago query de tal correo con tal contraseña
                $sqlUsuario = "SELECT * FROM usuario WHERE email = '$emailTelefono' AND contraseña = '$contraseniaCifrada'";
                $resUsuario = mysqli_query($conn, $sqlUsuario);
                
                if ($resUsuario && $row2 = mysqli_fetch_assoc($resUsuario)) {
                    
                    //Cojo el nombre de usuario para la pagina principal
                    $nombreApellido = $row2['nombreApellido'];

                    //Devuelvo el mensaje de login correcto
                    $result = ["success" => "1", "message" => "Login Success","nombreUsuario"=>"$nombreApellido"];
                    header('Content-Type: application/json');
                    echo json_encode($result);

                } else {
                    
                    //Si no encuentra tal correo con tal contraseña
                    $result = ["success" => "0", "message" => "No encuentra contraseña con tal usuario"];
                    header('Content-Type: application/json');
                    echo json_encode($result);
                }
            } else {
                //Si la contraseña no son iguales
                $result = ["success" => "0", "message" => "Contraseña incorrecto"];
                header('Content-Type: application/json');
                echo json_encode($result);
            }


        } else {
            //Si no existe el usuarios 
            $result = ["success" => "0", "message" => "No existe este usuario"];
            header('Content-Type: application/json');
            echo json_encode($result);
        }


    } else {
        //Si no existe datos en dentro, respondo con success=0
        $result = ["success" => "0", "message" => "Datos faltantes en la solicitud."];
        header('Content-Type: application/json');
        echo json_encode($result);
    }


} else {

    //Si el metodo no es POST, respondo tambien con success=0 y un mensaje de error
    $result = ["success" => "0", "message" => "Metodo de solicitud no valido."];
    header('Content-Type: application/json');
    echo json_encode($result);
}

?>