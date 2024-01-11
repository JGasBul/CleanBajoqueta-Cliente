<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('refresh:0; url=../user/login.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>PaginaUsuario</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
</head>

<body onload="getArchivo()">
    <?php $url = "http://" . $_SERVER['HTTP_HOST'] ?>
    <?php $url = "http://" . $_SERVER['HTTP_HOST'] ?>
    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#"> Bienvenido, <?php echo $_SESSION['usuario'];?> </a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/user/inicio.php">Inicio</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/user/editarUserPage.php">Editar Usuario</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/user/cerrar.php">Cerrar sesión</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>">Ver sitio web</a>
        </div>
    </nav>

    <script src="../clases/imagen.js"></script>

    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="POST">
                    <!--Inicio Campo Foto -->
                    <div class="text-center">
                        <span
                            class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3 input-container">
                                        Imagen de Perfil
                                        <input type="file" id="archivo" name="archivo" accept=".jpg, .jpeg, .png" value=""> 
                                    </div>
                                    <div class="preview-container">
                                        <img src="#" id="preview" class="rounded editField" height="100">
                                    </div>
                                </div>
                            </div>
                        </span>

                    </div>
                    <!--Inicio Campo Nombre -->
                    <div class="text-center">
                        <span
                            class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <span class="align-middle">
                                            <label for="exampleInputEmail1"> Nombre: </label>
                                        </span>
                                    </div>
                                    <div class="col  align-middle">
                                        <input type="text" class="form-control border-0 editField"
                                            name="nombreedit" placeholder="Escriba su nombre">
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
                        <span
                            class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3 align-middle">
                                        <span class="align-middle">
                                            <label for="exampleInputEmail1"> Apellidos: </label>
                                        </span>
                                    </div>

                                    <div class="col  align-middle">
                                        <input type="text" class="form-control border-0 editField"
                                            name="apellidosedit" placeholder="Escriba sus apellidos">
                                    </div>

                                </div>
                            </div>
                        </span>

                    </div>
                    <!--Fin Campo Apellidos -->
                    <!------------------------------------------------------------------------------------------------------------------->
                    <!------------------------------------------------------------------------------------------------------------------->
                    <!--Inicio Campo Email -->
                    <div class="text-center">
                        <span
                            class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3 align-middle">
                                        <span class="align-middle">
                                            <label for="exampleInputEmail1"> Email: </label>
                                        </span>
                                    </div>

                                    <div class="col  align-middle">
                                        <input type="email" class="form-control border-0 editField"
                                            name="emailedit" placeholder="Escriba su email">
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
                            class=" text-left badge rounded-pill text-bg-light shadow-lg  p-2 mb-2 w-75 align-items-center fs-6">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3 align-middle">
                                        <span class="align-middle">
                                            <label for="exampleInputEmail1"> Contraseña: </label>
                                        </span>
                                    </div>

                                    <div class="col  align-middle">
                                        <input type="text" class="form-control border-0 editField" name="contraseniaedit"
                                            placeholder="Escriba su contraseña">
                                    </div>

                                </div>
                            </div>
                        </span>
                    </div>
                    <!--Fin Campo Contraseña -->
                    <!------------------------------------------------------------------------------------------------------------------->
                    <?php include("../bd/editUser.php"); ?>
                    <div class="text-center mt-3">
                        <input name="editar" type="submit" class="btn btn-success fs-5 rounded-pill"
                            value=" Confirmar ">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>