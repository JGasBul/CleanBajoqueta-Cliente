<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Blue Sky</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../css/letra.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary shadow z-1  rounded-bottom" data-bs-theme="light">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php">
        <img src="../assets/BlueSky_LogoNofondo.png" width="40" height="40" class="d-inline-block align-text-top"
          alt="Logo BlueSky">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse container-fluid" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#"> Bienvenido,
              <?php echo $_SESSION['usuario']; ?>
            </a>
          </div>
          <li class="nav-item">
            <a class="nav-link" href="../user/inicio.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../user/cerrar.php">Cerrar Sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Mapa de contaminación</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Mediciones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Historial</a>
          </li>



        </ul>
        <div class="d-flex justify-content-end">
          <span class="navbar-text">
            <a href="../user/login.php">
              <button type="button" class="btn btn-sm btn-clear "><img src="../assets/perfil.png"
                  style="height: 40px;"></button>



            </a>
          </span>
        </div>
      </div>
    </div>
  </nav>