<?php
//Conexion a la base de datos
$conn = mysqli_connect("localhost", "root", "", "bbdd_cleanbajoqueta");

//Si la petición es de metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Cojo los datos que me ha enviado
    $data = json_decode(file_get_contents("php://input"), true);

    //Compruebo que existe datos en dentro y lo guardo en las variables
    if (isset($data['nombreApellido']) && isset($data['email']) && isset($data['telefono']) && isset($data['contraseña'])) {
        $nombreApellido = $data['nombreApellido'];
        $email = $data['email'];
        $telefono = $data['telefono'];
        $contraseña = $data['contraseña'];

        //Query para comprobar si tiene correo o telefono registrado dos veces
        $sqlEmail = "SELECT * FROM usuario WHERE email = '$email'";
        $comprobacionEmail = mysqli_query($conn, $sqlEmail);
        $sqlTelefono = "SELECT * FROM telefono WHERE telefono = '$telefono'";
        $comprobacionTelefono = mysqli_query($conn, $sqlTelefono);

        if ($comprobacionEmail && $comprobacionTelefono) {

            //Si existe resultado en la comprobación
            $numRowsEmail = mysqli_num_rows($comprobacionEmail);
            $numRowsTelefono = mysqli_num_rows($comprobacionTelefono);

            //Si repite, un mensaje alerta de cuenta ya existe
            if ($numRowsEmail > 0 || $numRowsTelefono > 0) {

                switch (true) {
                    //Caso de ya tiene un email registrado
                    case $numRowsEmail > 0:
                        $result = ["success" => "0", "message" => "Ya tiene un email registrado"];
                        break;
                    //Caso de ya tiene un telefono registrado
                    case $numRowsTelefono > 0:
                        $result = ["success" => "0", "message" => "Ya tiene un telefono registrado"];
                        break;
                }
                header('Content-Type: application/json');
                echo json_encode($result);
                mysqli_close($conn);

            } else {
                //Si este correo o telefono no esta registrado, lo inserto
                $sqlInsertUsuario = "INSERT INTO usuario (`email`, `contraseña`, `nombreApellido`) VALUES ('$email','$contraseña','$nombreApellido')";
                $sqlInsertTelefono = "INSERT INTO telefono (`email`, `telefono`) VALUES ('$email','$telefono')";
                if (mysqli_query($conn, $sqlInsertUsuario) && mysqli_query($conn, $sqlInsertTelefono)) {

                    //Insertacion exito, devuelvo el resultado
                    $result = ["success" => "1", "message" => "success"];

                } else {
                    $result = ["success" => "0", "message" => "error"];

                }
                header('Content-Type: application/json');
                echo json_encode($result);
                mysqli_close($conn);
            }
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