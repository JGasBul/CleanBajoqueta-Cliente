<?php
//----------------------------------------------------------------
// Zaida Pastor González
//cerrar.php
//Cierra la sesión del usuario
//----------------------------------------------------------------

session_start();
session_destroy();
header('Location:../index.php');

?>