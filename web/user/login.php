<?php
include("../bd/bd.php");

if(isset($_SESSION['usuario'])){    //Si existe, redirecciono
    header('refresh:0; url=../user/inicio.php');
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
</head>
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
<!-- Inicio Header -->
<header>
    <?php include("../template/cabecera.php"); ?>
</header>
<!-- Fin Header -->
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
<!-- Inicio Body -->

<body>
    <br><br><br><br>

    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm">
                <img src="../assets/login.jpg" class="img-fluid" alt="loginphoto">
            </div>

            <div class="col-sm ">
                <div class="card shadow border-light">
                    <div class="card-header text-md-center text-dark border-0 fs-3">
                        Inicie sesión con su cuenta
                    </div>

                    <div class="card-body ">
                        <form method="POST">
                            <div class="text-center">
                                <span
                                    class=" text-left badge rounded-pill text-bg-light shadow-lg  p-3 mb-3 w-75 align-items-center fs-5">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Usuario: </label>
                                                </span>
                                            </div>
                                            <div class="col  align-middle">
                                                <input type="email" class="form-control  border-0 " name="usuariologin"
                                                    placeholder="Escribe tu email de usuario">
                                                <small id="emailHelp" class="form-text text-muted"> </small>
                                            </div>
                                            <div class="col-lg-1  align-middle">
                                            </div>
                                        </div>
                                    </div>
                                </span>

                            </div>

                            <div class="text-center">
                                <span
                                    class=" text-left badge rounded-pill text-bg-light shadow-lg  p-3 mb-3 w-75 align-items-center fs-5">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-3 align-middle">
                                                <span class="align-middle">
                                                    <label for="exampleInputEmail1"> Contraseña: </label>
                                                </span>
                                            </div>

                                            <div class="col  align-middle">
                                                <input type="password" class="form-control  border-0"
                                                    name="contrasenialogin" placeholder="Escribe tu contraseña">
                                            </div>

                                            <div class="col-lg-1  align-middle">
                                                <img src="../assets/esconder.png" width="30" height="30"
                                                    alt="loginphoto">
                                            </div>
                                        </div>
                                    </div>
                                </span>

                            </div>

                            <div class="row align-items-center justify-content-center">
                                <div class="col-2"></div>

                                <div class="col-5 justify-content-center ">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input " id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Recuérdame</label>
                                    </div>
                                </div>

                                <div class="col-5 align-baseline">
                                    <label class="form-check-label">< <a href="#" onclick="redirectToForgotPassword()"> ¿Has olvidado tu contraseña?</a></label>
                                </div>
                            </div>

                            <br>

                            <div class="text-center">
                                <input name="ingresar" type="submit" class="btn btn-success fs-5 rounded-pill"
                                    value="  Enviar  ">
                            </div>

                        </form>
                    </div>

                    <div class="card-footer bg-info border-info">
                        <div class="row align-items-center justify-content-center ">
                            <div class="col-lg-1  justify-content-center">
                                <img src="../assets/manzana.png" class="align-right " width="40" height="40"
                                    alt="iconotelefono">
                            </div>
                            <div class="col-lg-1 align-middle align-items-center">
                                <img src="../assets/google.png" width="40" height="40" alt="iconogoogle">
                            </div>
                            <div class="col-lg-1">
                                <img src="../assets/facebook.png" width="40" height="40" alt="iconofacebook">
                            </div>
                        </div>
                    </div>

                </div>

                <div class=" text-md-center">
                    <a> ¿No tienes una cuenta?</a> <a class="text-success" href="../user/registroPage.php">
                        Regístrate</a>
                </div>



            </div>
        </div>
    </div>
    </div>

    <!-- redireccion contraseña olvidada -->
    <script>
    function redirectToForgotPassword() {
        var email = document.getElementsByName("usuariologin")[0].value;
        
        if (!email) {
            alert("Por favor, ingresa tu correo electrónico en el campo de Usuario para recuperar la contraseña.");
            return;
        }

        var codigoAleatorio = generateRandomCode(20);
        window.location.href = "../user/recCon.php?correo=" + encodeURIComponent(email) + "&codigo=" + codigoAleatorio;
    }

    function generateRandomCode(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        
        return result;
    }
</script>




</body>
<!-- Fin Body -->
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>
<!-- Inicio Footer -->
<footer>
    <?php include("../template/pie.php"); ?>
</footer>
<!-- Fin Footer -->

</html>