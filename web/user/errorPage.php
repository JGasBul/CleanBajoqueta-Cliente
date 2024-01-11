<?php include("../template/cabecera.php");
session_start(); 
session_destroy();
?>
<!doctype html>
<html lang="es">
<head>
    <title>Error 404</title>
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
<body>
    <div class="container text-center">
        <!-- CARD PRINCIPAL -->
        <br>
        <br>
        <div class="row card shadow z-1 m-5 mt-2 border-0">
            <div class="card-body">
                <h1>Ups... Hubo un error</h1>
                <h2>Página no encontrada</h2>
                <br>
                <img src="../assets/contaminacion.png" alt="Contaminación">
            </div>
        </div>
    </div>
</body>


</html>