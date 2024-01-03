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
                    <input type="text" class="form-control rounded-start-5 border-0  " placeholder="Nombre del usuario"
                        aria-label="Nombre del usuario">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success rounded-end-5  border-3" type="button" id="search">Buscar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="row card shadow z-1 m-5 mt-2 border-0">
            <div class="card-body">
                <table class="table align-middle table-striped">
                    <thead>
                        <tr  class="table-info">
                            <th scope="col">Nº</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Activo</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr >
                            <td class="align-middle">1</td>
                            <td class="align-middle">Carles</td>
                            <td class="align-middle">Email</td>
                            <td class="align-middle">Activo
                            <button type="button" class="btn btn-success p-2 ms-2"> </button>

                            </td>
                            <td class="align-middle"><button type="button" class="btn btn-danger">Eliminar</button></td>
                        </tr>
                        <tr>
                        <td class="align-middle">2</td>
                            <td class="align-middle">Zaida</td>
                            <td class="align-middle">Email</td>
                            <td class="align-middle">Activo
                            <button type="button" class="btn btn-success p-2 ms-2"> </button>

                            </td>
                            <td class="align-middle"><button type="button" class="btn btn-danger">Eliminar</button></td>
                        </tr>
                        <tr>
                        <td class="align-middle">3</td>
                            <td class="align-middle">Arnau</td>
                            <td class="align-middle">Email</td>
                            <td class="align-middle">Activo
                            <button type="button" class="btn btn-success p-2 ms-2"> </button>

                            </td>
                            <td class="align-middle"><button type="button" class="btn btn-danger">Eliminar</button></td>
                        </tr>
                        <td class="align-middle">4</td>
                            <td class="align-middle">Pepe</td>
                            <td class="align-middle">Email</td>
                            <td class="align-middle">Inactivo
                            <button type="button" class="btn btn-warning p-2 ms-2"> </button>

                            </td>
                            <td class="align-middle"><button type="button" class="btn btn-danger">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</body>


</html>