<?php
//----------------------------------------------------------------
// Zaida Pastor González
//recibir_json.php
//Api que gestiona los datos recibidos de android y los inserta en la tabla correspondiente, en este caso minor y major.
//----------------------------------------------------------------

$json_data = file_get_contents('php://input');
$data = json_decode($json_data);

// Procesa los datos JSON
$clave1 = $data->clave1;
$clave2 = $data->clave2;

// Establece la conexión con la base de datos
$servername = "localhost"; // Cambia esto por la dirección de tu servidor MySQL
$username = "root";
$password = "";
$dbname = "proyecto3a";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Prepara la consulta SQL para insertar los datos en la tabla
$sql = "INSERT INTO medicion (Temperatura, Contaminacion) VALUES ('$clave1', '$clave2')";

if ($conn->query($sql) === TRUE) {
    // Los datos se insertaron correctamente en la base de datos
    $respuesta = array('mensaje' => 'Datos recibidos y guardados correctamente en la base de datos');
    echo json_encode($respuesta);
} else {
    // Hubo un error al insertar los datos
    $respuesta = array('mensaje' => 'Error al guardar los datos en la base de datos: ' . $conn->error);
    echo json_encode($respuesta);
}

// Cierra la conexión a la base de datos
$conn->close();
?>
