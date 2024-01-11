

function mostrarImagen(event){
    var imagenSource = event.target.result;
    var previewImage = document.getElementById('preview');

    previewImage.src = imagenSource;
}

function procesarArchivo(event){
    var imagen = event.target.files[0];
    var lector = new FileReader();
    
    lector.addEventListener('load', mostrarImagen, false);

    lector.readAsDataURL(imagen);
}

function getArchivo(){
    document.getElementById('archivo').addEventListener('change', procesarArchivo, false);
}