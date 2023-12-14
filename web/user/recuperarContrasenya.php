<?php
// Comprobar si los parámetros 'correo' y 'codigo' están presentes en la URL
$correo = isset($_GET['correo']) ? $_GET['correo'] : 'No se proporcionó correo';
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : 'No se proporcionó código';


//MIRAR SI ESTA EL MISMO TOKEN
    
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://localhost:8080/user/getUserByEmail",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET"
));
$headers = [
    'accept: applicaction/json',
    'email: ' . $correo . ''
];
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($curl);
$res = json_decode($res, true); //because of true, it's in an array
$err = curl_error($curl);
curl_close($curl);

$tokenValue = $res[0]["token"];


$correcto=false;

if ($tokenValue == $codigo){
    $correcto = true;   
}




// HTML para mostrar el correo y el código
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Proyecto 3A - Cambiar Contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/letra.css">
</head>
<!-- Inicio Header -->
<header>
    <?php include("../template/cabecera.php"); ?>
</header>
<!-- Fin Header -->
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
<!-- Inicio Body -->

<body>
        
    <br><br><br>
    <div class="container-fluid">
        <div class="row align-items-center">

            <div class="col-sm mx-5">
                <!-- Inicio Card -->
                <div class="card  shadow border-info">
                    <!-- Inicio Card-Header -->
                    <div class="card-header text-md-center text-dark border-0 fs-1">
                        Restablecer la contraseña
                    </div>
                    <!-- Fin Card-Header -->

                    <!------------------------------------------------------------------------------------------------------------------->
                    <!------------------------------------------------------------------------------------------------------------------->
                    <!-- Inicio Card-Body -->
                    <div class="card-body ">
                        <!--Inicio Formulario de Registro -->
                        <form method="POST">      
                            
                             <!--Inicio Campo Email -->
                             <div class="text-center">
                                <span
                                    class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-50 align-items-center fs-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 d-flex align-items-center justify-content-center">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail"> Email: </label>
                                                </span>
                                            </div>

                                            <div class="col d-flex align-items-center justify-content-center">
                                            <p name="emailRec" class="align-middle"><?php echo htmlspecialchars($correo); ?></p>
                                            </div>

                                        </div>
                                    </div>
                                </span>
                            </div>
                            <!--Fin Campo Email -->

                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                          
                            <!--Inicio Campo Contraseña -->
                            <div class="text-center">
                                <span
                                    class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-50 align-items-center fs-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 d-flex align-items-center justify-content-center">
                                                <span class="align-items-center ">
                                                    <label for="exampleInputEmail1"> Nueva Contraseña: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="password" class="form-control  border-0"
                                                    name="contraseniaRec" placeholder="Escriba su nueva contraseña"
                                                    required>
                                            </div>
                                            
                                            <!-- <p>Código debug: <?php //echo htmlspecialchars($codigo); ?></p> -->
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <!--Fin Campo Contraseña -->
                            
                           
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                           
                            <?php ; 
                            
                            if ($correcto){
                                include("../bd/recContrasenya.php");
                            }else{
                                echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    Parece que el token es incorrecto
                                </div>
                              </div>';
                            }
                            ?>
                            <div class="text-center mt-3">
                                <input name="cambiarContrasenya" type="submit" class="btn btn-success fs-5 rounded-pill"
                                    value="  Cambiar Contraseña ">
                            </div>
                        </form>
                        <!--Fin Formulario de Registro -->
                    </div>
                    <!-- Fin Card-Body -->
                    <br><br>
                </div>
            </div> 
        </div>
    </div>


</body>
<!-- Fin Body -->
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
<!-- Inicio Footer -->
<footer>
    <?php include("../template/pie.php"); ?>
</footer>
<!-- Fin Footer -->

</html>