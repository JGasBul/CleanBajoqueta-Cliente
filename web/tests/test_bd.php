<link rel="stylesheet" href="../css/bootstrap.min.css" />
<?php

// Test: Insertar, leer y borrar datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto3a";
$testsTotales=3;
$tests=0;

//Hacer la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// 1. Insertar datos en la base de datos tabla usuarios
$test_data = "INSERT INTO usuarios (ID, nombre, usuario,contraseña) VALUES ('0','hola','holaUsuario','holaContraseña')";
if ($conn->query($test_data) === TRUE) {
    echo "✅ Dato usuario de prueba insertado con éxito". PHP_EOL;
    $tests++;
   /* $sql = "SELECT * FROM usuarios WHERE id = 0";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    foreach($row as $key => $value) {
        echo $key . " => " . $value . "<br>";
    }*/
    
} else {
    echo "❌ Error al insertar el dato de prueba: " . $conn->error . PHP_EOL;
}

// 2. Insertar datos en la base de datos tabla sonda
$test_data = "INSERT INTO sonda (`id sonda`,`id usuario`, bateria , estado) VALUES ('2','0','90','ok')";

if ($conn->query($test_data) === TRUE) {
    echo "✅ Dato sonda de prueba insertado con éxito tabla sonda". PHP_EOL;
    $tests++;
    /*$sql = "SELECT * FROM sonda WHERE `id usuario` = 0";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    foreach($row as $key => $value) {
        echo $key . " => " . $value . "<br>";
    }*/
    
} else {
    echo "❌ Error al insertar el dato de prueba: " . $conn->error . PHP_EOL;
}

// 3. Insertar datos en la base de datos tabla medicion
$test_data = "INSERT INTO medicion (`id sonda`, fecha, hora, Latitud, Longitud, Humedad, Temperatura, Contaminacion) VALUES ('2', '2022-01-01','00:33:00','33','33','31','31', '34')";
if ($conn->query($test_data) === TRUE) {
    echo "✅ Dato medicion de prueba insertado con éxito". PHP_EOL;
    $tests++;
    /*$sql = "SELECT * FROM sonda WHERE `id usuario` = 0";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    foreach($row as $key => $value) {
        echo $key . " => " . $value . "<br>";
    }*/
    
} else {
    echo "❌ Error al insertar el dato de prueba: " . $conn->error . PHP_EOL;
}

// 4. Borrar los datos insertados tabla medicion
$delete_test_data = "DELETE FROM medicion WHERE `id sonda`='2' ";
if ($conn->query($delete_test_data) === TRUE) {
    echo "✅ Dato de prueba medicion eliminado con éxito" . PHP_EOL;
} else {
    echo "❌ Error al eliminar el dato de prueba: " . $conn->error. PHP_EOL;
}

// 5.Borrar los datos insertados en tabla sonda
$delete_test_data = "DELETE FROM sonda WHERE `id sonda`='2'";
if ($conn->query($delete_test_data) === TRUE) {
    echo "✅ Dato de prueba sonda eliminado con éxito". PHP_EOL;
} else {
    echo "❌ Error al eliminar el dato de prueba: " . $conn->error . PHP_EOL;
}

// 3. Borrar los datos insertados tabla usuarios
$delete_test_data = "DELETE FROM usuarios WHERE id='0'";
if ($conn->query($delete_test_data) === TRUE) {
    echo "✅ Dato de prueba usuario eliminado con éxito". PHP_EOL;
} else {
    echo "❌ Error al eliminar el dato de prueba: " . $conn->error . PHP_EOL;
}

if($tests==$testsTotales){
    echo "TODOS LOS TESTS PASADOS EXITOSAMENTE ". PHP_EOL;
}else{
    echo "❌ ALGUNOS TESTS NO HAN PASADO". PHP_EOL;
}
?>
