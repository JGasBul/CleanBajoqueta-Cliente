<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Proyecto 3A - Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
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
    <br><br><br>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-4">
                <!-- Inicio Card -->
                <div class="card">
                    <!-- Inicio Card-Header -->
                    <header class="card-header text-md-center">Registro</header>
                    <!-- Fin Card-Header -->
                    <!------------------------------------------------------------------------------------------------------------------->
                    <!------------------------------------------------------------------------------------------------------------------->
                    <!-- Inicio Card-Body -->
                    <div class="card-body">
                        <!--Inicio Formulario de Registro -->
                        <form method="POST">
                            <!--Inicio Campo Nombre -->
                            <div class="form-group">
                                <label> Nombre </label>
                                <input type="text" class="form-control" name="usuariologin"
                                    placeholder="Escribe tu nombre">
                            </div>
                            <!--Fin Campo Nombre -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Apellidos -->
                            <div class="form-group">
                                <label> Apellidos </label>
                                <input type="text" class="form-control" name="usuariologin"
                                    placeholder="Escribe tus apellidos">
                            </div>
                            <!--Fin Campo Apellidos -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Contraseña -->
                            <div class="form-group">
                                <label>Contraseña </label>
                                <input type="password" class="form-control" name="contrasenialogin"
                                    placeholder="Escribe tu contraseña">
                            </div>
                            <!--Fin Campo Contraseña -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Confirmar Contraseña -->
                            <div class="form-group">
                                <label>Confirmar Contraseña </label>
                                <input type="password" class="form-control" name="confirmarcontrasenialogin"
                                    placeholder="Vuelve a escribir tu contraseña">
                            </div>
                            <!--Fin Campo Confirmar Contraseña -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Email -->
                            <div class="form-group">
                                <label> Email</label>
                                <input type="text" class="form-control" name="usuariologin"
                                    placeholder="email@gmail.com">
                            </div>
                            <!--Fin Campo Email -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Telefono de Contacto -->
                            <div class="form-group">
                                <label> Telefono de Contacto </label>
                                <input type="tel" class="form-control" name="usuariologin" placeholder="###-##-##-##">
                            </div>
                            <!--Fin Campo Telefono de Contacto -->
                            <input name="registrar" type="submit" class="btn btn-primary" value="Registrarse">
                        </form>
                        <!--Fin Formulario de Registro -->
                    </div>
                    <!-- Fin Card-Body -->
                    <!------------------------------------------------------------------------------------------------------------------->
                    <!------------------------------------------------------------------------------------------------------------------->
                </div>
                <!-- Fin Card -->
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
    function ComprobarContrasena(){
        let listaInputPasswords = [];
        listaInputPasswords.push(document.getElementsByName("contrasenialogin"))
        listaInputPasswords.push(document.getElementsByName("confirmarcontrasenialogin"))
        if(listaInputPasswords[0]==listaInputPasswords[1]){
            // registrar en BBDD
        }
        else{
            alert()
        }
    }
</script>
</html>