<?php
include("../clases/checkRol.php");
session_start();

checkRol($_SESSION['rol']);
//echo(var_dump($_SESSION))
?>

<!doctype html>
<html lang="es">

<head>
    <title>Pagina de Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/letra.css">

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>



</head>
<header>
    <?php include("../template/cabecera_admin.php"); ?>
</header>

<body>
    <div class="container text-center">
        <div class="row mt-5">
            <div class="col-8 fs-3">
                Lista de usuarios
            </div>
            <div class="col-3 fs-3 ">
                <div class="input-group mb-3 shadow rounded-5  align-items-center">
                    <input type="text" class="form-control rounded-start-5 border-0" id="adminInputSearch"
                        placeholder="Nombre" aria-label="Nombre del usuario">
                    <!-- Menú desplegable del filtrador -->
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filtrador
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <a class="dropdown-item" href="#!">Action</a>
                            <a class="dropdown-item" href="#!">Another action</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="row card shadow z-1 m-5 mt-2 border-0">
            <div class="card-body">
                <div id="table-container"></div>
            </div>
        </div>
    </div>
</body>

<?php include("../bd/eliminarUsuario.php"); ?>
<script src="../bd/adminController.js"></script>

<link rel="stylesheet" href="../css/admin.css">

</html>