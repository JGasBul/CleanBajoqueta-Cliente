<?php
//----------------------------------------------------------------
// Zaida Pastor González
//controlador.php
//Consulta los datos de la tabla testB, con sus ultimos valores de minor y major.
//----------------------------------------------------------------

// Establece la conexión con la base de datos (reemplaza los valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto3a";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Realiza la consulta SQL para obtener la última entrada de la tabla medicion
$sql = "SELECT * FROM medicion ORDER BY id DESC LIMIT 1"; // Ordena por ID de forma descendente y limita a 1 resultado

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Si se encontraron resultados, devuelve la última entrada como un array asociativo
    $row = $result->fetch_assoc();
} else {
    // Si no se encontraron entradas en la tabla testB, devuelve un array vacío
    $row = array();
}

// Cierra la conexión a la base de datos (puedes cerrarla en otro lugar si es necesario)
$conn->close();

// Devuelve el resultado como un JSON
//echo json_encode($row);
?>