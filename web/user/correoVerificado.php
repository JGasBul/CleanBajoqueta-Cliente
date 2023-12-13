<?php
// Comprobar si los parámetros 'correo' y 'codigo' están presentes en la URL
$correoUsuario = isset($_GET['correo']) ? $_GET['correo'] : 'No se proporcionó correo';
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : 'No se proporcionó código';

// HTML para mostrar el correo y el código
?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Verificado de correo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/letra.css">

    <!-- Inicio Header -->
    <header>
        <?php include("../template/cabecera.php"); ?>
    </header>
    <!-- Fin Header -->
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="row">
            <div class="col-md-10 offset-md-0 shadow border-0 rounded-3">
                <div class="card border-0">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Veridicación de correo</h2>


                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>
                                Correo verificado:  <strong>
                                    <?php echo $correoUsuario; ?>
                                </strong>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>