<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Proyecto 3A - Registro</title>
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
            <div class="col-sm">
                <img src="../assets/registro.jpg" class="img-fluid" alt="registrophoto">
            </div>

            <div class="col-sm ">
                <!-- Inicio Card -->
                <div class="card shadow border-light">
                    <!-- Inicio Card-Header -->
                    <div class="card-header text-md-center text-dark border-0 fs-3">
                        Inicie sesión con su cuenta
                    </div>
                    <!-- Fin Card-Header -->

                    <!------------------------------------------------------------------------------------------------------------------->
                    <!------------------------------------------------------------------------------------------------------------------->
                    <!-- Inicio Card-Body -->
                    <div class="card-body ">
                        <!--Inicio Formulario de Registro -->
                        <form method="POST">
                            <!--Inicio Campo Nombre -->
                            <div class="text-center">
                                <span class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Nombre: </label>
                                                </span>
                                            </div>
                                            <div class="col  align-middle">
                                                <input type="text" class="form-control  border-0 recoverField" name="nombreregistro" placeholder="Escriba su nombre">
                                                <small id="emailHelp" class="form-text text-muted"> </small>
                                            </div>
                                            <div class="col-lg-1  align-middle">
                                            </div>
                                        </div>
                                    </div>
                                </span>

                            </div>

                            <!--Fin Campo Nombre -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->

                            <!--Inicio Campo Apellidos -->
                            <div class="text-center">
                                <span class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Apellidos: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="text" class="form-control  border-0 recoverField" name="apellidosregistro" placeholder="Escriba sus apellidos">
                                            </div>

                                        </div>
                                    </div>
                                </span>

                            </div>
                            <!--Fin Campo Apellidos -->

                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Contraseña -->
                            <div class="text-center">
                                <span class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Contraseña: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="password" class="form-control  border-0" name="contraseniaregistro" placeholder="Escriba su contraseña">
                                            </div>

                                        </div>
                                    </div>
                                </span>
                            </div>
                            <!--Fin Campo Contraseña -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Confirmar Contraseña -->
                            <div class="text-center">
                                <span class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Contraseña: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="password" class="form-control  border-0" name="confirmarcontraseniaregistro" placeholder="Vuelva a escribir tu contraseña">
                                            </div>

                                        </div>
                                    </div>
                                </span>
                            </div>
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Email -->
                            <div class="text-center">
                                <span class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Email: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="email" class="form-control  border-0 recoverField" name="emailregistro" placeholder="Escriba su email">
                                            </div>

                                        </div>
                                    </div>
                                </span>
                            </div>
                            <!--Fin Campo Email -->

                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Telefono de Contacto -->
                            <div class="text-center">
                                <span class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Telefono: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="text" class="form-control recoverField" name="telefonoregistro" placeholder="#########" pattern="[0-9]{9}">
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                <p><small>Formato del Teléfono: 962876543</small></p>
                            </div>
                            <!--Fin Campo Telefono de Contacto -->
                            <?php include("../bd/registro.php"); ?>
                            <div class="text-center">
                                <input name="registrar" type="submit" class="btn btn-success fs-5 rounded-pill" value="  Registrarse  ">
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