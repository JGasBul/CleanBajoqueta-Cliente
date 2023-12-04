//---------------------------------------------------------------------------------------------------------
// Autor: Arnau Soler Tomás
// Fichero: polPriv.js
// Descripción: Fichero de JS que nos sirve para guardar información entre el registro y la política de 
//              Privacidad
//---------------------------------------------------------------------------------------------------------

//Variable Global
let nombre="formdata";

//---------------------------------------------------------------------------------------------------------
// 
// Descripción: recoge información de un fichero en base a un nombre.txt
//---------------------------------------------------------------------------------------------------------
function getLocalStorage(identificador){
    return localStorage.getItem(identificador);
}
//---------------------------------------------------------------------------------------------------------
// 
// Descripción: escribe información en un fichero en base a un nombre.txt y un contenido
//---------------------------------------------------------------------------------------------------------
function setLocalStorage(identificador, contenido){
    localStorage.setItem(identificador, contenido);
}
//----------------------------------------------------------------------------------------------------------
function toPolitica() {
    let formFields = document.getElementsByClassName("recoverField");
    //guardar
    for(let i=0; i<formFields.length; i++){
        console.log("Campo "+i+": "+formFields[i].value);
        if(i==5){
            setLocalStorage(i,formFields[i].checked);
        }else{
           setLocalStorage(i,formFields[i].value); 
        }
    }
    //redirect
    document.location.href = "politicaPrivacidadPage.php";
}
//----------------------------------------------------------------------------------------------------------
function comprobarCampos(){
    let formFields = document.getElementsByClassName("recoverField");

    for(let i=0; i<3; i++){
        formFields[i].value = getLocalStorage(i);
    }
    formFields[4].checked = getLocalStorage(4);
}
//----------------------------------------------------------------------------------------------------------
function aceptar(){
    setLocalStorage(4,true);
    //redirect
    document.location.href = "registroPage.php";
}
//----------------------------------------------------------------------------------------------------------