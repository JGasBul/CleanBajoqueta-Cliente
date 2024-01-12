<?php
//---------------------------------------------------------------------------------------------------------
// Autor: Arnau Soler Tomás
// Fichero: eliminarUsuario.php
// Descripción: Fichero que nos sirve para eliminar un usuario mediante un email. Nos sirve como puente entre
// el fichero adminController.js y la API (y evitarnos así un error de CORS)
//---------------------------------------------------------------------------------------------------------
if (isset($_COOKIE["eliminar"])) {

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://localhost:8080/user/deleteByEmail",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "DELETE"
  )
  );
  $headers = [
    'accept: applicaction/json',
    'email: ' . $_COOKIE["eliminar"] . ''
  ];
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  $res = curl_exec($curl);
  $res = json_decode($res, true); //because of true, it's in an array
  $err = curl_error($curl);
  curl_close($curl);

  $_COOKIE["eliminar"]=null;

  header("Refresh:0",true); //Resetea la página para actualizar
}
?>

<script>
//---------------------------------------------------------------------------------------------------------
// datos:tr --> eliminar()
// Descripción: Esta función recibe el tr del que fué seleccionado. Mediante eso, recogemos
// el indice de la fila con el proposito de recoger el email correcto.
// Una vez lo recogemos, enseñamos un mensaje de alerta. Si se acepta, se elimina el usuario de la BBDD.
// Luego llamamos a actualizarTabla() para actualizar la tabla
//---------------------------------------------------------------------------------------------------------
  function eliminar(datos) {
    let index = datos.rowIndex;
    console.log("Row Index: " + index)

    let tr = document.getElementById("table-container").getElementsByTagName("tr")
    let td = tr[index].getElementsByTagName("td");
    let email = td[2].textContent;

    popUp('Eliminar Usuario', '¿Desea eliminar este usuario?', async () => {
      console.log(email)

      /*
      await fetch('http://localhost:8080/user/deleteByEmail',{
        method: 'DELETE',
        body: email
      }).then(response => console.log(response.status))
      */

      createCookie("eliminar", email, 0.000104167) //("nametag","valor","9 segundos en escala de dias")

      console.log("eliminado");
    })
  }
//---------------------------------------------------------------------------------------------------------
// name:string ,value:(string || R), days: R --> createCookie() --> cookie
// Descripción: Esta función crea una cookie en el navegador.
// Lo usamos para crear una cookie de eliminar usuario con el email como valor y un período de caducidad de 9 segundos
//---------------------------------------------------------------------------------------------------------
  function createCookie(name, value, days) {
    let expires;

    if (days) {
      let date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
    }
    else {
      expires = "";
    }

    document.cookie = escape(name) + "=" +
      escape(value) + expires + "; path=/";
  }

</script>