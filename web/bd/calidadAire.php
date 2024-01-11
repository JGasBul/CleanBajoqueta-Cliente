<?php
//-----------------------------------------------------------------------------------------------------------------------
//Autor: Arnau Soler Tomás
//Fichero: calidadAire.php
//Descripción:
//-----------------------------------------------------------------------------------------------------------------------

//Variables Globales
$calidadAireGlobal="Error";
//-----------------------------------------------------------------------------------------------------------------------
//
//-----------------------------------------------------------------------------------------------------------------------
function getDatosUser(){
    $email = $_SESSION["email"];
    $fechaHoy = date('Y/m/d');
    $fechaMañana = date('Y/m/d', (time() + (7 * 24 * 60 * 60)));

    return [$email, $fechaHoy, $fechaMañana];
}
function getMedicionesHoy()
{
    $datos = getDatosUser();

    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => "http://localhost:8080/mediciones/mediciones_rango_fecha",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        )
    );
    $headers = [
        'accept: applicaction/json',
        'email: '.$datos[0],
        'first_date: '.$datos[1],
        'last_date: '.$datos[2]
    ];
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $res = curl_exec($curl);
    $res = json_decode($res, true); //because of true, it's in an array
    $err = curl_error($curl);
    curl_close($curl);

    if($res){
        return $res;
    }
}

function media($mediciones)
{
    $res = null;
    $acumulador = 0;
    $i = 0;
    for ($i; $i < count($mediciones); $i++) {
        $acumulador += $mediciones[$i]["valor"];
    }

    $media = round(($acumulador / $i),2);

    return $media;
}

function calidadAire($media, $rango)
{
    $rango = [0, 50, 75];

    $calidad = "Saludable";
    $color = "#77DD77";
    if ($media >= $rango[1] && $media <= $rango[2]) {
        $calidad = "Mala";
        $color="#ffe180";
    } else if ($media >= $rango[2]) {
        $calidad = "Muy Mala";
        $color="#f9a59a";
    }
    echo(
        '<script>
    var divCalidadAire = document.getElementById("calidadAire");
        divCalidadAire.style.backgroundColor = "'.$color.'";
</script>');

    return $calidad;
}

function mostrarCalidadAire($calidadAire){
    echo($calidadAire);
}

function main()
{
    //Recogemos las mediciones de hoy
    $mediciones = getMedicionesHoy();

    //Sacamos la media de las mediciones
    $media = media($mediciones);

    //Comprobamos la calidad del Aire
    $calidadAireGlobal = calidadAire($media, [0, 75, 100]);

    //Mostramos la calidad del Aire en el HTML
    mostrarCalidadAire($calidadAireGlobal);
}
main()
?>