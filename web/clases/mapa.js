//----------------------------------------------------------------------------------------------------------
// Autor: Arnau Soler Tomás
// Fichero: mapa.js
// Descripción: Fichero JS en el que irán todas las funciones relacionadas con el mapa.
// Nota: Se hace en JS con tal de aprovechar el archivo para la App
//----------------------------------------------------------------------------------------------------------

// Variable Global
var map = null;

//----------------------------------------------------------------------------------------------------------
// String nombreMapa --> map()
// Descripción: Tiene 2 pasos:
// 1 paso: Crear un <div> con la id del mapa en el HTML
// 2 paso: Llamar a esta función pasandole la id del mapa
//----------------------------------------------------------------------------------------------------------
function mapa(nombre) {

    map = L.map(nombre);
    map.setView([0, 0], 1); //Valores: [centro], zoom;
    L.tileLayer('https://api.maptiler.com/maps/openstreetmap/{z}/{x}/{y}.jpg?key=kIRP9eC6t8HxGCalVgc5', {
        attribution:
            '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
    }).addTo(map);

    console.log("mapa creado");
    L.control.locate().addTo(map);
    console.log("mapa Locate creado");

    console.log("Inicio añadir Contaminantes");
    res = añadirContaminantes();

    heatlayer = getheatLayer()
    if(res){
        var layerControl = L.control.layers({},{"Ozono":res[0],"CO":res[1],"HeatMap":heatlayer}).addTo(map);
    }
}
//----------------------------------------------------------------------------------------------------------
// Punto: punto --> crearMarcador() --> Marker: marker
// Descripción: crea un Marcador en base a un punto
//----------------------------------------------------------------------------------------------------------
function crearMarker(punto) {
    if (punto == null) { punto = [0, 0]; }
    var marker = L.marker(punto).addTo(map);
    return marker;
}
//----------------------------------------------------------------------------------------------------------
// Punto: punto --> crearCirculo()
// Descripción: crea un area circular en base a un punto
//----------------------------------------------------------------------------------------------------------
function crearCirculo(punto, color) {
    if (punto == null) {
        punto = [0, 0];

    }

    var circle = L.circleMarker(punto, {
        color: color,
        fillColor: color,
        fillOpacity: 1,
        radius: 25
    });

    return circle
}
function añadirContaminantes() {
    console.log("añadirContaminante inicia");
    listaContam = [];
    //contaminante = consulta GET
    //#region Contaminantes de Prueba
    contaminante = new Contaminante("ozono", 244, [0, 0]);
    listaContam.push(contaminante);
    contaminante = new Contaminante("ozono", 332, [20, 20]);
    listaContam.push(contaminante);
    contaminante = new Contaminante("ozono", 423, [0, 20]);
    listaContam.push(contaminante);
    contaminante = new Contaminante("ozono", 544, [20, 0]);
    listaContam.push(contaminante);

    contaminante = new Contaminante("co", 123, [60, 60]);
    listaContam.push(contaminante);
    contaminante = new Contaminante("co", 32, [80, 60]);
    listaContam.push(contaminante);
    contaminante = new Contaminante("co", 45, [60, 80]);
    listaContam.push(contaminante);


    listaOzono = [];
    listaCO = [];

    //console.log("Lista Ozono: "+listaOzono);
    //console.log("Lista CO: "+listaCO);
    //#endregion

    var layerOzono;
    var layerCO;

    for (var i = 0; i < listaContam.length; i++) {
        estadoColor = estadocolor(listaContam[i]);

        contam = crearCirculo([20, 20], estadoColor[1]);

        mensaje = "Tipo: " + listaContam[i].tipo + "<br>Valor: " + listaContam[i].valor + "<br>Estado: " + estadoColor[0];

        //console.log(listaContam);

        añadirPopup(contam, mensaje);


        if (listaContam[i].tipo == "ozono") { listaOzono.push(contam); }
        else if (listaContam[i].tipo == "co") { listaCO.push(contam); }
        else {
            console.error("Error al distribuir contaminantes");
            return false;
        }

        console.log("Posicion: " + i + ", Tipo: " + listaContam[i].tipo + ", Valor: " + listaContam[i].valor);

        layerOzono = L.layerGroup(listaOzono);
        layerCO = L.layerGroup(listaCO);

        layerOzono.addTo(map);
        layerCO.addTo(map);
    }

    return [layerOzono,layerCO];

}

function estadocolor(cont) {
    color = "green"; //Verde Hex
    estado = "Seguro";
    if (cont.valor >= 250) {
        color = "yellow";
        estado = "Regular"
    }
    if (cont.valor >= 500) {
        color = "red";
        estado = "Peligroso"
    }
    return [estado, color];
}
//----------------------------------------------------------------------------------------------------------
// [Punto]: puntos --> crearPoligono()
// Descripción: crea un Poligono en base a una lista de puntos
//----------------------------------------------------------------------------------------------------------
function crearPoligono(puntos) {
    if (puntos == null) { puntos = [[0, 0], [20, 20], [60, 60]]; }
    var polygon;
    polygon = L.polygon(puntos).addTo(map);

}
//----------------------------------------------------------------------------------------------------------
// (marker || circle || polygon):item, String:mensaje --> añadirPopup()
// Descripción: añade un Popup con un mensaje a un item en concreto
//----------------------------------------------------------------------------------------------------------
function añadirPopup(item, mensaje) {
    item.bindPopup(mensaje);
}
//----------------------------------------------------------------------------------------------------------
// Punto:punto, N:zoom --> centrarEn()
// Descripción: centra el mapa en un punto en concreto con un zoom determinado
//----------------------------------------------------------------------------------------------------------
function centrarEn(punto, zoom) {
    if (punto == null) {
        //punto = [40.737, -73.923];
        punto = [0, 0];
    }
    if (zoom == null) {
        zoom = 16;
    }
    map.flyTo(punto, zoom); //([Latitud, Longitud], Zoom)
}
//----------------------------------------------------------------------------------------------------------
// Punto:punto, N:zoom --> centrarEn()
// Descripción: centra el mapa en un punto en concreto con un zoom determinado
//----------------------------------------------------------------------------------------------------------
function tuLocalizacion(punto, zoom) {
    if (punto == null) {
        punto = [40.737, -73.923];
    }
    if (zoom == null) {
        zoom = 16;
    }
    centrarEn(punto, zoom);
}
//----------------------------------------------------------------------------------------------------------
// Punto:punto, N:zoom --> centrarEn()
// Descripción: centra el mapa en un punto en concreto con un zoom determinado
//----------------------------------------------------------------------------------------------------------
function getheatLayer(puntos){
    //Punto =  [lat, lng, intensity]
    if(puntos==null){
        //Puntos de testeo
        puntos = [
            [50.4, 30.4, 100],
            [50.45, 30.45, 100],
            [50.4, 30.45, 100],
            [50.45, 30.4, 100],

            [50.475, 30.475, 800],
            [50.47, 30.475, 100],
            [50.47, 30.47, 100],
            [50.475, 30.47, 800],

            [50.4, 30.5, 100],
            [50.45, 30.55, 400],
            [50.4, 30.55, 400],
            [50.45, 30.5, 400],

            [50.475, 30.75, 800],
            [50.475, 30.575, 800],
            [50.75, 30.575, 400],
            [50.75, 30.545, 400],

            [50.5, 30.5, 500],
            [50.5, 30.6, 500],
            [50.6, 30.5, 500],

            [50.55, 30.55, 500],
            [50.55, 30.65, 500],
            [50.65, 30.55, 500],

            [50.6, 30.6, 600],
            [50.6, 30.7, 600],
            [50.7, 30.6, 600],

            [50.65, 30.65, 700],
            [50.65, 30.75, 700],
            [50.75, 30.65, 700],

            [50.7, 30.7, 700]
        ]
    }
    
    // var heatLayer = L.heatLayer([
    //     puntos
    // ], {radius: 25}).addTo(map);

    var heatLayer = L.heatLayer(puntos,{radius: 27});
    heatLayer.addTo(map);

    centrarEn([50.5, 30.5, 1],9); //Esto lo hago para la visualización a modo de testeo. Luego se quita

    return heatLayer;
}