<?php
$conn = mysqli_connect("localhost", "root", "", "bbdd_cleanbajoqueta");

//Si la petición es de metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Cojo los datos que me ha enviado
    $data = json_decode(file_get_contents("php://input"), true);

    //Compruebo que existe datos en dentro y lo guardo en las variables
    if (isset($data['email'])) {

        $email = $data['email'];

        //Asignar el id a la sonda
        $sqlSonda = "INSERT INTO sonda (`idSonda`) VALUES ('')";
        if (mysqli_query($conn, $sqlSonda)) {

            //Coge la ultima sonda que ha sido emparejado
            $sqlIdSonda = "SELECT MAX(idSonda) AS idSonda_maxima FROM sonda";
            $res = mysqli_query($conn, $sqlIdSonda);

            //Si obtiene el ultimo id_sonda registrada
            if ($res) {
                $fila = mysqli_fetch_assoc($res);
                $idSonda = $fila['idSonda_maxima'];

                //Asignar esa id_sonda para el usuario que esta logeado ahora mismo
                $sqlUsuarioSonda = "INSERT INTO usuariosonda (`email`, `idSonda`) VALUES ('$email','$idSonda')";
                if (mysqli_query($conn, $sqlUsuarioSonda)) {

                    $result = ["success" => "1", "message" => "success"];

                } else {
                    $result = ["success" => "0", "message" => "error de asignar id_sonda al usuario logeado"];

                }

            } else {
                $result = ["success" => "0", "message" => "fallo de encontrar el ultimo id_sonda"];
            }

        } else {
            $result = ["success" => "0", "message" => "error insertar id_sonda"];

        }

        header('Content-Type: application/json');
        echo json_encode($result);
        mysqli_close($conn);

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