<?php
//-----------------------------------
// rol, rolaccesible --> checkRol()
// Descripción: Le paso mi rol y el rol necesario en la página. Si no coincide, se redirecciona
//-----------------------------------
function checkRol($rol)
{
    if ($rol == 2) {
        redirect("../user/inicio.php");
    } else if ($rol == 1) {
        redirect("../user/admin.php");
    } else {
        redirect("../user/errorPage.php");
    }
}
//-------------------------------------------------------------------------------------------------------
// url:String --> redirect()
// Descripción: Mediante una url, redirecciona
//-------------------------------------------------------------------------------------------------------
function redirect($url)
{
    if($_SESSION['pageRefreshed']){
        $_SESSION['pageRefreshed']=false;
        header($url);
    }
    else{
        $_SESSION['pageRefreshed']=true;
        header("Refresh:0; url=".$url);
    }
}

?>