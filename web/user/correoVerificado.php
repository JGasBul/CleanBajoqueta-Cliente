<?php
// Comprobar si los parámetros 'correo' y 'codigo' están presentes en la URL
$correoUsuario = isset($_GET['correo']) ? $_GET['correo'] : 'No se proporcionó correo';
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : 'No se proporcionó código';


//Obtener datos del usuario en la bd
$curl = curl_init();
curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => "http://localhost:8080/user/getUserByEmail",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
    )
);
$headers = [
    'accept: applicaction/json',
    'email: ' . $correoUsuario . ''
];
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($curl);
$res = json_decode($res, true); //because of true, it's in an array
$err = curl_error($curl);
curl_close($curl);
$resString = print_r($res, true);

$tokenValue = '';
if (!$err && isset($res[0]) && isset($res[0]['token'])) {
    $tokenValue = $res[0]['token']; // Acceder al valor del token
} else {
    $tokenValue = 'Token no disponible o error en la solicitud';
}

if ($tokenValue == $codigo) {
    //Hacer update del estado de verificacion:
$curl = curl_init();
curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => "http://localhost:8080/user/updateUserByEmail",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT"
    )
);

// Agregar el email del usuario en el header
$headers = [
    'accept: application/json',
    'Content-Type: application/json',
    'email: ' . $correoUsuario // Asegúrate de que $correoUsuario contenga el email correcto
];

// Body con los cambios a realizar, en este caso, actualizar el token
$fields = [
    'token' => "0", // Asegúrate de que $codigoAleatorio contenga el token correcto
    'verificado' => 1
];

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
$res = curl_exec($curl);
$res = json_decode($res, true); // Decodificar la respuesta
$err = curl_error($curl);
curl_close($curl);

$verified = true;
} else {
    $verified=false;
}





// HTML para mostrar el correo y el código
?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Verificado de correo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/letra.css">

    <!-- Inicio Header -->
    <header>
        <?php include("../template/cabecera.php"); ?>
    </header>
    <!-- Fin Header -->
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="row">
            <div class="col-md-10 offset-md-0 shadow border-0 rounded-3">
                <div class="card border-0">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Verificación de correo</h2>


                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>
                                <strong>
                                    <?php if ($verified) {
                                        echo '<p>Correo verificado correctamente</p>';
                                    } else {
                                        echo '<p>Error al verificar el correo</p>';
                                    }
                                    ?>
                                </strong>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>