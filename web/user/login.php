<?php
/*Si no has iniciado sesión, no puedes entrar a la página de inicio del login
session_start();
if($_POST){
    if($_POST['usuariologin']== $_SESSION['nombre'] && $_POST['contrasenialogin']== $_SESSION['contraseña']){
        $_SESSION['usuario']=ok;
    }
}*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyecto 3A Zpasgon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>

<body>
    <br><br><br>
    <div class="container">
        <div class="row">
        <div class="col-md-4">

        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">

                    <form method="POST">

                        <div class = "form-group">
                            <label for="exampleInputEmail1"> Usuario </label>
                            <input type="text" class="form-control" name="usuariologin" placeholder="Escribe tu usuario">
                            <small id="emailHelp" class="form-text text-muted"> </small>
                        </div>

                        <div class="form-group">
                            <label>Contraseña: </label>
                            <input type="password" class="form-control" name="contrasenialogin" placeholder="Escribe tu contraseña">
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Recuérdame</label>
                        </div>
                        <?php
                        include("../bd/bd.php");
                        ?>
                        <input name="ingresar" type="submit" class="btn btn-primary">
                    </form>

                </div>
                <div class="card-footer text-muted">
                    Footer
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
</html>
