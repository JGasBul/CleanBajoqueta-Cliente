//----------------------------------------------------------------------------------------------------------
// Autor: Arnau Soler Tomás
// Fichero: mapa.js
// Descripción: Fichero JS en el que irán todas las funciones relacionadas con el mapa.
// Nota: Se hace en JS con tal de aprovechar el archivo para la App
//----------------------------------------------------------------------------------------------------------

// Variable Global
var map = null;
var miLocalizacion = null;

var GlobalListaPuntos = null;

//----------------------------------------------------------------------------------------------------------
// String nombreMapa --> map()
// Descripción: Tiene 2 pasos:
// 1 paso: Crear un <div> con la id del mapa en el HTML
// 2 paso: Llamar a esta función pasandole la id del mapa
//----------------------------------------------------------------------------------------------------------
function mapa(nombre, tipo) {

    map = L.map(nombre);
    map.setView([0, 0], 1); //Valores: [centro], zoom;
    L.tileLayer('https://api.maptiler.com/maps/openstreetmap/{z}/{x}/{y}.jpg?key=kIRP9eC6t8HxGCalVgc5', {
        attribution:
            '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
    }).addTo(map);

    console.log("mapa creado");
    var locateController = L.control.locate().addTo(map);
    locateController.start();

    getCurrentLocation(tipo);

    console.log("mapa Locate creado");
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
// getCurrentLocation() --> Punto: punto
// Descripción: Recoge tu localización en base al navegador
//----------------------------------------------------------------------------------------------------------
function getCurrentLocation(tipoMapa) {

    const success = (position) => {
        console.log(position);
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        const geoApiUrl = 'https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=XXXXXXXXXXXX&longitude=XXXXXXXXXXXX&localityLanguage=es'

        fetch(geoApiUrl)
            .then(res => res.json())
            .then(async data => {
                miLocalizacion = [data.longitude, data.latitude];
                //console.log("Mi localización: " + miLocalizacion);
                //console.log("Mi ciudad: " + data.locality);

                console.log("Inicio añadir Contaminantes");
                var res = await añadirContaminantes();

                if (tipoMapa == "heatmap") {
                    var heatlayers = getheatLayers(GlobalListaPuntos);
                    console.log("heatLayers:")
                    console.log(heatlayers);
                    if (res && heatlayers) {
                        //var layerControl = L.control.layers({}, { "Seguro": heatlayers[0][0], "Regular": heatlayers[0][1], "Peligro": heatlayers[0][2] }).addTo(map);
                        //var layerControl = L.control.layers({}, {"Ozono":heatlayers[0], "CO":heatlayers[1]}).addTo(map);
                        L.layerGroup(heatlayers).addTo(map)
                    }
                }
                else {
                    if (res) {
                        var layerControl = L.control.layers({}, { "Ozono": res[0], "CO": res[1] }).addTo(map);
                    }
                }





            })
    }

    const error = () => {
        miLocalizacion = 'Unable to retrieve your location'
    }

    navigator.geolocation.getCurrentPosition(success, error);
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
        fillOpacity: 0.5,
        radius: 20
    });

    return circle
}
async function añadirContaminantes() {
    console.log("añadirContaminante inicia");

    var promesa = getListaPuntos();

    console.log("Después del getListaPuntos")
    console.log(promesa);

    await promesa.then(function (result) {
        GlobalListaPuntos = result;
        //console.log(GlobalListaPuntos);
        console.log("GlobalListaPuntos dentro de promesa: ")
        console.log(GlobalListaPuntos);

        return GlobalListaPuntos;
    })

    console.log("GlobalListaPuntos sacado de promesa: ")
    console.log(GlobalListaPuntos);

    //var listaContam = await getListaContaminantes(GlobalListaPuntos);

    var listaContam = getListaContaminantes(GlobalListaPuntos);

    listaOzono = [];
    listaCO = [];

    var layerOzono;
    var layerCO;

    for (var i = 0; i < listaContam.length; i++) {
        estadoColor = estadocolor(listaContam[i]);

        contam = crearCirculo([listaContam[i].punto[0], listaContam[i].punto[1]], estadoColor[1]);

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

        //layerOzono.addTo(map);
        //layerCO.addTo(map);
    }

    return [layerOzono, layerCO];

}

function estadocolor(cont) {
    color = "green"; //Verde Hex
    estado = "Seguro";
    if (cont.valor >= 50) {
        color = "yellow";
        estado = "Regular"
    }
    if (cont.valor >= 75) {
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
function getheatLayers(mediciones) {

    var rango = [0, 50, 100];
    var listaClasificada = reclasificar(mediciones)

    var listaozono = getConfig(listaClasificada[0], rango);
    var listaco = getConfig(listaClasificada[1], rango);

    listaHeatOzonoLayers = [];
    listaHeatCOLayers = [];

    var listaPuntosOzono = [];
    var listaPuntosCO = [];

    for (var i = 0; i<listaozono.length; i++) {
        console.log(listaozono[i][1])
        var puntos = getPuntos((listaozono[i][1]))
        listaPuntosOzono.push(puntos);
    }
    for (var i = 0; i<listaco.length; i++) {
        console.log(listaco[i][1])
        var puntos = getPuntos((listaco[i][1]))
        listaPuntosCO.push(puntos);
    }

    //console.log("Debugueame esta")
    //console.log(listaPuntosOzono)

    for (var i = 0; i < listaPuntosOzono.length; i++) {
        console.log("Debug Posicion: "+i);
        console.log("listaPuntosOzono["+i+"]: ");
        console.log(listaPuntosOzono[i])
        console.log("listaozono["+i+"][0]: ");
        console.log(listaozono[i][0])
        listaHeatOzonoLayers.push(L.heatLayer(listaPuntosOzono[i], listaozono[i][0]));
    }
    for (var i = 0; i < listaPuntosCO.length; i++) {
        console.log("Debug Posicion: "+i);
        console.log("listaPuntosCO["+i+"]: ");
        console.log(listaPuntosCO[i])
        console.log("listaco["+i+"][0]: ");
        console.log(listaco[i][0])
        listaHeatCOLayers.push(L.heatLayer(listaPuntosCO[i], listaco[i][0]));
    }

    HeatLayerOzono = L.layerGroup(listaHeatOzonoLayers);
    HeatLayerCO = L.layerGroup(listaHeatCOLayers);

    return [HeatLayerOzono, HeatLayerCO];
}
//----------------------------------------------------------------------------------------------------------
// {mediciones, rango}: Objeto --> getConfig() --> {listaSeguro,listaRegular,listaPeligro}: Objeto
// Descripción: devuelve un objeto con las mediciones que son Seguras, Regulares y Peligrosas con
// su configuración para pintarlos en el mapa de calor
//----------------------------------------------------------------------------------------------------------
function getConfig(mediciones, rango) {
    listaSeguro = [];
    listaRegular = [];
    listaPeligro = [];

    var configSeguro = {
        radius: 25,
        minOpacity: 100,
        gradient: {
            '0.5': 'DarkGreen',
            '1': 'LightGreen'
        }
    }
    var configRegular = {
        radius: 25,
        minOpacity: 50,
        gradient: {
            '0.5': 'Orange',
            '1': 'Yellow'
        }
    }
    var configPeligro = {
        radius: 25,
        minOpacity: 25,
        gradient: {
            '0.5': 'DarkRed',
            '1': 'Red'
        }
    }

    for (var i = 0; i < mediciones.length; i++) {
        if (mediciones[i].valor <= rango[1]) {
            listaSeguro.push(mediciones[i]);
        }
        else if (mediciones[i].valor <= rango[2]) {
            listaRegular.push(mediciones[i]);
        }
        else {
            listaPeligro.push(mediciones[i]);
        }
    }

    var seguro = [configSeguro, listaSeguro];
    var regular = [configRegular, listaRegular];
    var peligro = [configPeligro, listaPeligro];

    return [seguro, regular, peligro];
}


function reclasificar(lista) {
    listaOzono = [];
    listaCO = [];
    for (var i = 0; i < lista.length; i++) {
        if (lista[i].idContaminante == 4) {
            listaOzono.push(lista[i]);
        }
        else if (lista[i].idContaminante == 5) {
            listaCO.push(lista[i]);
        }
    }
    return [listaOzono, listaCO];
}

function getPuntos(lista) {
    var listares = [];

    for (var i = 0; i < lista.length; i++) {
        listares.push([lista[i].latitud, lista[i].longitud, lista[i].valor]);
    }
    return listares;
}
//----------------------------------------------------------------------------------------------------------
// getListaPuntos() --> promesa:Promise
// Descripción: devuelve un objeto Promise (una promesa) que contiene una
// lista de Puntos de las mediciones de la BBDD
//----------------------------------------------------------------------------------------------------------
function getListaPuntos() {
    var promesa = new Promise((resolve, reject) => {
        var peticionGet = CORSSolve(miLocalizacion);
        //console.log("Dentro de promesa: "+peticionGet);
        resolve(peticionGet);
    });

    return promesa;
}
//----------------------------------------------------------------------------------------------------------
// getListaContaminantes() --> listaContaminantes:<Contaminante>
// Descripción: devuelve una lista de Contaminantes de la BBDD
//----------------------------------------------------------------------------------------------------------
function getListaContaminantes(listaPuntos) {
    listaContaminantes = [];

    for (var i = 0; i < listaPuntos.length; i++) {
        var tipo = getTipo(listaPuntos[i]);
        var contam = new Contaminante(tipo, listaPuntos[i].valor, [listaPuntos[i].latitud, listaPuntos[i].longitud]);
        listaContaminantes.push(contam);
    }

    return listaContaminantes;
}
//----------------------------------------------------------------------------------------------------------
// medicion: Medicion --> getTipo() --> tipo:String
// Descripción: devuelve una lista de Contaminantes de la BBDD
//----------------------------------------------------------------------------------------------------------
function getTipo(medicion) {
    if (medicion.idContaminante == 4) { return "ozono" }
    else if (medicion.idContaminante == 5) { return "co" }
    else { return "Error" }
}