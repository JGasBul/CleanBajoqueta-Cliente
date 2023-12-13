<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('refresh:0; url=../user/login.php');
}
?>

<!doctype html>
<html lang="es">

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
    <link rel="stylesheet" href="../css/letra.css">
</head>
<header>
    <?php include("../template/cabecera_user.php"); ?>
</header>

<body>


    <?php $url = "http://" . $_SERVER['HTTP_HOST'] ?>
   

    <br>
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="display-3 --bs-font-oxygen">Mediciones</h1>
                    <p class="lead">La medición de su sonda es: </p>
                    <hr class="my-2">
                    <?php
                    // Incluye la conexión y datos desde el archivo db_connection.php
                    include '../bd/controlador.php';

                    //Muestra los datos de la conexión
                    if (!empty($row) && !empty($row2)) {
                        echo "<p>ID: " . $row["idMedicion"] . "</p>";
                        echo "<p>Contaminante: " . $row2["nombre"] . "</p>";
                        echo "<p>Valor: " . $row["valor"] . "</p>";
                        echo "<p>Instante: " . $row["instante"] . "</p>";

                    } else {
                        echo "<p>No se encontraron entradas en la tabla testB.</p>";
                    }
                    ?>
                    <p>More info</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>