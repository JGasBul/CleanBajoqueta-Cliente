<?php
$conn = mysqli_connect("localhost","root","","bbdd_cleanbajoqueta");

//Si la petición es de metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    //Cojo los datos que me ha enviado
    $data = json_decode(file_get_contents("php://input"), true);

    //Compruebo que existe datos en dentro y lo guardo en las variables
    if (isset($data['nombreApellido']) && isset($data['email']) && isset($data['telefono'])&& isset($data['contraseña'])) {
        $nombreApellido = $data['nombreApellido'];
        $email = $data['email'];
        $telefono = $data['telefono'];
        $contraseña = $data['contraseña'];
        
    
        //Hago que query y sugún el resultado lo respondo con el objecto success
        $sql1 ="INSERT INTO usuario (`email`, `contraseña`, `nombreApellido`) VALUES ('$email','$contraseña','$nombreApellido')";
        $sql2 ="INSERT INTO telefono (`email`, `telefono`) VALUES ('$email','$telefono')";
            if(mysqli_query($conn,$sql1)&&mysqli_query($conn,$sql2)){
                $result["success"] ="1";
                $result["message"] ="success";

                echo json_encode($result);
                mysqli_close($conn);
            }
            else{
                $result["success"] ="0";
                $result["message"] ="error";

                echo json_encode($result);
                mysqli_close($conn);
            }
       

        error_log("Received POST data: email=$email,contraseña=$contraseña, nombreApellido=$nombreApellido");

        $result = [
            "success" => "1",
            "message" => "Datos recibidos y procesados correctamente."
        ];
    }    else {
        //Si no existe datos en dentro, respondo con success=0
        $result = [
            "success" => "0",
            "message" => "Datos faltantes en la solicitud."
        ];
    }

    
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
   
    //Si el metodo no es POST, respondo tambien con success=0 y un mensaje de error
    $result = [
        "success" => "0",
        "message" => "Metodo de solicitud no valido."
    ];

    header('Content-Type: application/json');
    echo json_encode($result);
}
?>