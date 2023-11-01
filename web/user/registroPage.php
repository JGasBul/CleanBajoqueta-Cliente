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
                                <input type="text" class="form-control" name="nombreregistro"
                                    placeholder="Escribe tu nombre" required>
                            </div>
                            <!--Fin Campo Nombre -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Apellidos -->
                            <div class="form-group">
                                <label> Apellidos </label>
                                <input type="text" class="form-control" name="apellidosregistro"
                                    placeholder="Escribe tus apellidos" required>
                            </div>
                            <!--Fin Campo Apellidos -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Contraseña -->
                            <div class="form-group">
                                <label>Contraseña </label>
                                <input type="password" class="form-control" name="contraseniaregistro"
                                    placeholder="Escribe tu contraseña" required>
                            </div>
                            <!--Fin Campo Contraseña -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Confirmar Contraseña -->
                            <div class="form-group">
                                <label>Confirmar Contraseña </label>
                                <input type="password" class="form-control" name="confirmarcontraseniaregistro"
                                    placeholder="Vuelve a escribir tu contraseña" required>
                            </div>
                            <!--Fin Campo Confirmar Contraseña -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Email -->
                            <div class="form-group">
                                <label> Email</label>
                                <input type="email" class="form-control" name="emailregistro"
                                    placeholder="email@gmail.com" required>
                            </div>
                            <!--Fin Campo Email -->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!------------------------------------------------------------------------------------------------------------------->
                            <!--Inicio Campo Telefono de Contacto -->
                            <div class="form-group">
                                <label> Telefono de Contacto </label>
                                <input type="tel" class="form-control" name="telefonoregistro"
                                placeholder="###-##-##-##" pattern="[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}" required>
                                <small>Formato: 900-45-67-81</small><br><br>
                            </div>
                            <!--Fin Campo Telefono de Contacto -->

                            <?php
                            include("../bd/registro.php");
                            ?>

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

</html>