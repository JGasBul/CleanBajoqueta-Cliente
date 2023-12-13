<?php
$conn = mysqli_connect("localhost", "root", "", "bbdd_cleanbajoqueta");

//Si la petición es de metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Cojo los datos que me ha enviado
    $data = json_decode(file_get_contents("php://input"), true);

    //Compruebo que existe datos en dentro y lo guardo en las variables
    if (isset($data['idContaminante']) && isset($data['nombre']) && isset($data['valor']) && isset($data['instante'])&& isset($data['email'])) {

        $idContaminante = $data['idContaminante'];
        $nombre = $data['nombre'];
        $valor = $data['valor'];
        $instante = $data['instante'];
        $email = $data['email'];

        //Buscar si existe id_contaminante en bd
        $sqlcontaminante ="SELECT * FROM contaminante WHERE idContaminante = $idContaminante";
        $res = mysqli_query($conn, $sqlcontaminante);
        if ($res) {

            //Si no hay ese contaminante en la bd, lo añado
            $numRowsIdContaminante = mysqli_num_rows($res);
            if ($numRowsIdContaminante == 0) {
                $sqlInsertContaminante = "INSERT INTO contaminante (`idContaminante`, `nombre`) VALUES ('$idContaminante','$nombre')";
                mysqli_query($conn, $sqlInsertContaminante);
                return;
            }
            
            //Si hay ese contaminante, inserto medicion
            $sqlMedicion = "INSERT INTO medicion (`idMedicion`,`idContaminante`,`instante`, `valor`) VALUES ('','$idContaminante','$instante','$valor')";
            if (mysqli_query($conn, $sqlMedicion)) {

                //Busco el id de la ultima medicion y sonda
                $sqlMaxIdMedicion = "SELECT MAX(idMedicion) AS idMedicion_maxima FROM medicion";
                $sqlMaxIdSonda = "SELECT MAX(idSonda) AS idSonda_maxima FROM sonda";                                
                $resMed = mysqli_query($conn, $sqlMaxIdMedicion);
                $resSon = mysqli_query($conn, $sqlMaxIdSonda);
                if ($resMed&&$resSon) {

                    $filaMed = mysqli_fetch_assoc($resMed);                    
                    $filaSon = mysqli_fetch_assoc($resSon);
                    $idMed = $filaMed['idMedicion_maxima'];
                    $idSon = $filaSon['idSonda_maxima'];

                    //Inserto la tabla sondamedicion
                    $sqlMedicionSonda = "INSERT INTO sondamedicion (`idSonda`, `idMedicion`) VALUES ('$idSon','$idMed')";
                    $resMedSon = mysqli_query($conn, $sqlMedicionSonda);
                    if ($resMedSon) {

                        //Inserto la tabla usuariomedicion
                        $sqlUsuarioMedicion="INSERT INTO usuariomedicion (`email`, `idMedicion`) VALUES ('$email','$idMed')";
                        if(mysqli_query($conn, $sqlUsuarioMedicion)) {
                            $result = ["success" => "1", "message" => "success"];
                        }
                        else {
                            $result = ["success"=> "0", "message"=> "error insertar tabla usuariomedicion"];
                        }
                    }else{
                        $result = ["success" => "0", "message" => "error insertar tabla sondamedicion"];  
                    }

                }else{
                    $result = ["success" => "0", "message" => "error query idSonda e idMedicion maxima"];
                }

            }else{

                $result = ["success" => "0", "message" => "error al insertar medicion"];
            }

        } else {
            $result = ["success" => "0", "message" => "error buscar id_contaminante"];
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