<?php
//----------------------------------------------------------------
//CleanBajoqueta
//editUser.php
//Gestiona la página de edición del Usuario
//----------------------------------------------------------------

//Clases
include("../clases/CifrarDescifrarAES.php");
include("../clases/TempData.php");

//Variables
$segundos_espera = 3; //tiempo de espera antes de redirigir al Login
$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
$tempDataFile = 'tempFormData.txt';


function editar($datos){
    //var_dump($datos);
    
    $nombre = $datos["nombreedit"];
    $apellidos = $datos["apellidosedit"];

    $nombreApellidos = $nombre . " " . $apellidos;

    $email = $datos["emailedit"];
    $contrasenia = $datos["contraseniaedit"];
    
    $imagen = '../assets/'.$_FILES["archivo"]["name"];
    var_dump($datos);

    //Editamos Usuario
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => "http://localhost:8080/user/insertUser",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST"
        )
    );
    $headers = [
        'accept: applicaction/json',
        'Content-Type: application/json'
    ];
    $fields = [
        'email' => $email,
        'contraseña' => $contrasenia,
        'nombreApellido' => $nombreApellidos,
        'imagen' => $imagen
    ];
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
    $res = curl_exec($curl);
    $res = json_decode($res, true); //because of true, it's in an array
    $err = curl_error($curl);
    curl_close($curl);

    //Si se pudo registrar, lo llevamos a la página de Login
    if (!$err) {
        echo '<div class="alert alert-success">Información Actualizada</div>';

        header('refresh:' . $GLOBALS['segundos_espera'] . '; url=../user/inicio.php');
    } else {
        echo '<div class="alert alert-danger">Hubo problemas al acutalizar el usuario</div>';
    }
}
    

getData();
function getData()
{
    $email = $_SESSION['email'];
    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => "http://localhost:8080/user/getUserByEmail",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        )
    );
    $headers = [
        'accept: applicaction/json',
        'email: ' . $email . ''
    ];
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $res = curl_exec($curl);
    $res = json_decode($res, true); //because of true, it's in an array
    $err = curl_error($curl);
    curl_close($curl);
    //$sql = $conexionbd->query("SELECT * FROM usuario WHERE email = '$email'");
    if ($res) {
        //var_dump($res);
        setFormData($res[0]);
    }
}

function setFormData($datos){
    if (empty($datos)) {
        echo '<div class="alert alert-danger">Hubo problemas al conseguir los datos</div>';
    } else {
        $nombreApellidos = explode(" ",$datos['nombreApellido']);

        $nombre = $nombreApellidos[0];
        $apellidos = $nombreApellidos[1];
        if(sizeof($nombreApellidos)>2){
            for($i=2; $i<sizeof($nombreApellidos); ++$i){
                $apellidos = $apellidos .' '. $nombreApellidos[$i];
            }
        }

        //Desciframos la contraseña
        $cifrado = new CifrarDescifrarAES($datos['contraseña']);
        $contrasenia = $cifrado->desencriptar();

        //var_dump($_FILES);

        //$imagen = base64_encode($datos['imagen']);
        //$imagen = base64_encode(implode($datos['imagen']));
        //$imagen = base64_encode(implode($datos['imagen']['data']));
        $imagen = ($datos['imagen']);
        //var_dump($imagen);

        //var_dump($imagen);
        //$imagen = "../assets/defaultUserImage.jpg";

        echo
            '<script>
                const formFields = document.getElementsByClassName("editField");
                formFields[0].src="data:image/jpeg;base64,'.$imagen.'";
                formFields[1].value = "' . $nombre . '";
                formFields[2].value = "' . $apellidos . '";
                formFields[3].value = "' . $datos['email'] . '";
                formFields[4].value = "' . $contrasenia . '";
            </script>';
    }
}

//Se consulta el contenido del POST
if (!empty($_POST["editar"])){
    editar($_POST);
}


?>