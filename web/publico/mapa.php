

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de contaminación</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />

    <!-- LeafLet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Plugin Leaflet: Leaflet.idw -->
    <script src="../clases/leaflet-idw.js"></script>
    <script src="../clases/leaflet-idw-directdraw.js"></script>
    <!-- Plugin Leaflet: Leaflet.Locate -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>
    <!-- Plugin Leaflet: Leaflet.heat -->
    <script src="../clases/leaflet-heat.js"></script>
    

    <!-- contaminante.js -->
    <script src="../clases/contaminante.js"></script>
    <!-- contaminante.js -->
    <script src="../clases/CORSSolve.js"></script>
    <!-- mapa.CSS y mapa.JS -->
    <link rel="stylesheet" href="../css/mapa.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
    <script src="../clases/mapa.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/letra.css"/>
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
    <div class="container-fluid">
        <div class="row align-items-center">

            <div class="col-sm ">
                <!-- Inicio Card -->
                <div class="card shadow border-light m-5 ">
                    <!-- Inicio Card-Header -->
                    <div class="card-header d-flex align-items-center justify-content-center bg-info">
                    <h5 class="card-title fs-2 align-self-center mt-3 text-white">Mapa de Contaminación</h5>
                    
                    
                        </div>
                    <!---------------------------------------------------------------------------------------------------------->
                    <!------------------------------------------------------------------------------------------------------------------->
                    
                    
                    <!-- Inicio Card-Body -->

                    <div class="card-body ">
                        <div class="row">
                        <div class="col mx-2  rounded-2" id="map"></div>
                        </div>
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

<script>
    //Inicializar mapa
    mapa('map','heatmap');
</script>

</html>