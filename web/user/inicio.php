<?php
include("../clases/checkRol.php");
session_start();

checkRol($_SESSION['rol']);
?>

<!doctype html>
<html lang="es">

<head>
    <title>PaginaUsuario</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- LeafLet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Plugin Leaflet: Leaflet.Locate -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.js"
        charset="utf-8"></script>
    <!-- Plugin Leaflet: Leaflet.heat -->
    <script src="../clases/leaflet-heat.js"></script>

    <!-- contaminante.js -->
    <script src="../clases/contaminante.js"></script>
    <!-- contaminante.js -->
    <script src="../clases/CORSSolve.js"></script>
    <!-- mapa.CSS y mapa.JS -->
    <link rel="stylesheet" href="../css/mapa.css" />

    <script src="../clases/mapa.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/letra.css" />
    <script src="../clases/contaminante.js"></script>
    <!-- contaminante.js -->
    <script src="../clases/CORSSolve.js"></script>
    <!-- mapa.CSS y mapa.JS -->
    <link rel="stylesheet" href="../css/mapa.css" />

    <script src="../clases/mapa.js"></script>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">









    <link rel="stylesheet" href="../css/letra.css">
    <link rel="stylesheet" href="../css/proground.css">



</head>
<header>
    <?php include("../template/cabecera_user.php"); ?>
</header>

<body>
    <?php $url = "http://" . $_SERVER['HTTP_HOST'] ?>

    <div class="container text-center">
        <div class="row ">
            <!--Tarjeta uno-->
            <div class="col card shadow z-1 m-5 border-0">
                <div class="card-body">
                    <h5 class="card-title bg-success-subtle rounded-2 p-2">
                        Contaminación actual
                    </h5>
                    <div class="row align-items-center rounded ">

                        <!--Progress bar circular-->
                        <div class="col">
                            <div class="progress2 green round">
                                <span class="progress2-left  ">
                                    <span class="progress2-bar"></span>
                                </span>
                                <span class="progress2-right">
                                    <span class="progress2-bar"></span>
                                </span>
                                <div class="progress2-value" id="progActual">
                                    <img src="../assets/contaminacion.png" style="width: 30%">

                                    90%
                                </div>
                            </div>

                        </div>

                        <!-- Barras de progreso -->
                        <div class="col">

                            <div class="d-flex align-items-center my-3">
                                <p class="mb-0 mr-2" id="hora1">12:00</p>
                                <div class="progress" style="flex-grow: 1;" role="progressbar"
                                    aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success" id="bar1" style="width: 25%"></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center my-3">
                                <p class="mb-0 mr-2" id="hora2">11:00</p>
                                <div class="progress" style="flex-grow: 1;" role="progressbar"
                                    aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-alert" id="bar1" style="width: 50%"></div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center my-3">
                                <p class="mb-0 mr-2" id="hora3">10:00</p>
                                <div class="progress" style="flex-grow: 1;" role="progressbar"
                                    aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-danger" id="bar1" style="width: 75%"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Temperatura -->
                    <div class="row justify-content-start">


                        <div class="col-2 ms-4 me-0">

                            <img src="../assets/termometro.png" style="width: 70%">

                        </div>
                        <div class="col-2 fs-3 pe-4 ms-0 ps-0">

                            <p id="temperaturaGrande">24º</p>

                        </div>


                        <div class="col"> </div>
                    </div>
                </div>






            </div>


           


            
            <div class="col-5 card shadow z-1 m-5 border-0">
                    <div class="card-body">

                        <h5 class="card-title bg-warning-subtle primary rounded-2 p-2">
                            Punto selecionado
                        </h5>

                        <div class="col-5 mt-4">
                            <div class="progress2 yellow round">
                                <span class="progress2-left  ">
                                    <span class="progress2-bar"></span>
                                </span>
                                <span class="progress2-right">
                                    <span class="progress2-bar"></span>
                                </span>
                                <div class="progress2-value" id="progPunto">
                                    <img src="../assets/contaminacion.png" style="width: 30%">

                                    45%
                                </div>
                            </div>

                        </div>
                        <div class="col-4 d-flex align-items-center mt-4 mt-5 me-0">
                            <img src="../assets/ozono.png" class="img-fluid" style="width: 50%;">
                            <p class="ms-4 mb-0 fs-4" id="ppmPunto">144 ppm</p>
                        </div>

                        <div class="col-4 d-flex align-items-center mt-4">
                            <img src="../assets/termometro.png" class="img-fluid" style="width: 50%;">
                            <p class="ms-4 mb-0 fs-4" id="temperaturaPunto">22º</p>
                        </div>




                    </div>
                </div>




        </div>
        <!-- Punto selecionado -->
        <div class="row">
            <!-- MAPA -->
            <div class="col card shadow z-1 my-2 border-0 ">
                <h5 class="card-title bg-info rounded-2 p-2 text-dark mt-2">
                    Mapa de contaminación
                </h5>
                <div class="row">
                    <div class="col mx-2 mb-2  rounded-2" id="map"></div>
                </div>

            </div>


        </div>

        <!-- DEBUG -->

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card shadow z-1 m-5 border-0">
                    <h1 class="display-3 --bs-font-oxygen">Menu de DEBUG</h1>
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

                </div>
            </div>
        </div>


    </div>

</body>

<script>
    //Inicializar mapa
    mapa('map');
</script>


</html>