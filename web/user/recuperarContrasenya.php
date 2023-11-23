<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Proyecto 3A - Cambiar Contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
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
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail"> Email: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="email" class="form-control  border-0" name="emailRec"
                                                    placeholder="Escriba su email" required>
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
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Nueva Contraseña: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="password" class="form-control  border-0"
                                                    name="contraseniaRec" placeholder="Escriba su nueva contraseña"
                                                    required>
                                            </div>

                                        </div>
                                    </div>
                                </span>
                            </div>
                            <!--Fin Campo Contraseña -->
                            
                           
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                           
                            <?php include("../bd/recContrasenya.php"); ?>
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