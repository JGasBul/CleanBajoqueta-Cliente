<?php
$conn = mysqli_connect("localhost", "root", "", "bbdd_cleanbajoqueta");

include("../clases/CifrarDescifrarAES.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['emailTelefono']) && isset($data['contrasenia'])) {
        $emailTelefono = $data['emailTelefono'];
        $contrasenia = $data['contrasenia'];

        $sqlpassword = "SELECT usuario.contraseña
        FROM usuario
        INNER JOIN telefono ON usuario.email = telefono.email
        WHERE usuario.email = '$emailTelefono' OR telefono.telefono = '$emailTelefono'";


        $res = mysqli_query($conn, $sqlpassword);
        

        if ($res && $row = mysqli_fetch_assoc($res)) {
            
            $contraseniaCifrada = $row['contraseña'];
            $cifrado = new CifrarDescifrarAES($contraseniaCifrada);
            $contraseniaDesCifrada = $cifrado->desencriptar();

            if ($contrasenia == $contraseniaDesCifrada) {            

                $sqlUsuario = "SELECT * FROM usuario WHERE email = '$emailTelefono' AND contraseña = '$contraseniaCifrada'";

                $resUsuario = mysqli_query($conn, $sqlUsuario);
                
                if ($resUsuario && $row2 = mysqli_fetch_assoc($resUsuario)) {

                    $result = ["success" => "1", "message" => "Login Success"];
                    header('Content-Type: application/json');
                    echo json_encode($result);

                } else {
                
                    $result = ["success" => "0", "message" => "No encuentra contraseña con tal usuario"];
                    header('Content-Type: application/json');
                    echo json_encode($result);
                }
            } else {
                $result = ["success" => "0", "message" => "Contraseña incorrecto"];
                header('Content-Type: application/json');
                echo json_encode($result);
            }


        } else {
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