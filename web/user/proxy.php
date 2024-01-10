<?php
// proxy.php

// Asegúrate de reemplazar esto con la URL real y tu clave de API
$apiUrl = 'https://opendata.aemet.es/opendata/api/valores/climatologicos/inventarioestaciones/todasestaciones/';
$apiKey = 'eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJjYXJsZXNtYXJ0aWZAZ21haWwuY29tIiwianRpIjoiODBhZjcwZGMtN2ViMi00ZGI1LWE5NjAtYTgxODgxZGI5NWY3IiwiaXNzIjoiQUVNRVQiLCJpYXQiOjE3MDQ3MjM1MzgsInVzZXJJZCI6IjgwYWY3MGRjLTdlYjItNGRiNS1hOTYwLWE4MTg4MWRiOTVmNyIsInJvbGUiOiIifQ.XnbAN7c2cIPdryGDY0o1GnfwrojV9YaGGU_ozLnNLtkeyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJjYXJsZXNtYXJ0aWZAZ21haWwuY29tIiwianRpIjoiODBhZjcwZGMtN2ViMi00ZGI1LWE5NjAtYTgxODgxZGI5NWY3IiwiaXNzIjoiQUVNRVQiLCJpYXQiOjE3MDQ3MjM1MzgsInVzZXJJZCI6IjgwYWY3MGRjLTdlYjItNGRiNS1hOTYwLWE4MTg4MWRiOTVmNyIsInJvbGUiOiIifQ.XnbAN7c2cIPdryGDY0o1GnfwrojV9YaGGU_ozLnNLtk';

// Construir la URL completa
$url = "https://opendata.aemet.es/opendata/api/valores/climatologicos/inventarioestaciones/todasestaciones/?api_key=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJjYXJsZXNtYXJ0aWZAZ21haWwuY29tIiwianRpIjoiODBhZjcwZGMtN2ViMi00ZGI1LWE5NjAtYTgxODgxZGI5NWY3IiwiaXNzIjoiQUVNRVQiLCJpYXQiOjE3MDQ3MjM1MzgsInVzZXJJZCI6IjgwYWY3MGRjLTdlYjItNGRiNS1hOTYwLWE4MTg4MWRiOTVmNyIsInJvbGUiOiIifQ.XnbAN7c2cIPdryGDY0o1GnfwrojV9YaGGU_ozLnNLtkeyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJjYXJsZXNtYXJ0aWZAZ21haWwuY29tIiwianRpIjoiODBhZjcwZGMtN2ViMi00ZGI1LWE5NjAtYTgxODgxZGI5NWY3IiwiaXNzIjoiQUVNRVQiLCJpYXQiOjE3MDQ3MjM1MzgsInVzZXJJZCI6IjgwYWY3MGRjLTdlYjItNGRiNS1hOTYwLWE4MTg4MWRiOTVmNyIsInJvbGUiOiIifQ.XnbAN7c2cIPdryGDY0o1GnfwrojV9YaGGU_ozLnNLtk"

// Inicializar cURL
$ch = curl_init();

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'cache-control: no-cache'
));

// Ejecutar la solicitud cURL
$response = curl_exec($ch);
$err = curl_error($ch);

// Cerrar cURL
curl_close($ch);

// Comprobar si hay errores en la solicitud
if ($err) {
    echo 'cURL Error: ' . $err;
} else {
    // Enviar la respuesta al cliente
    header('Content-Type: application/json');
    echo $response;
}
?>
