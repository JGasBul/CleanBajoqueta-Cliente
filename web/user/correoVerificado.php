<?php
// Comprobar si los parámetros 'correo' y 'codigo' están presentes en la URL
$correo = isset($_GET['correo']) ? $_GET['correo'] : 'No se proporcionó correo';
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : 'No se proporcionó código';

// HTML para mostrar el correo y el código
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verificacion de correo</title>
</head>
<body>
    <h1>Información del Correo</h1>
    <p>Correo del usuario: <?php echo htmlspecialchars($correo); ?></p>
    <p>Código: <?php echo htmlspecialchars($codigo); ?></p>
</body>
</html>
