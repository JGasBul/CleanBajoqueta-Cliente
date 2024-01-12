//----------------------------------------------------------------------------------------------------------
// Autor: Arnau Soler Tomás
// Fichero: mapa.js
// Descripción: Fichero JS en el que irán todas las funciones relacionadas con el mapa.
// Nota: Se hace en JS con tal de aprovechar el archivo para la App
//----------------------------------------------------------------------------------------------------------

// Variable Global
var map = null;
var miLocalizacion = null;
var estacionesCargadas = false;
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
    buscarEstaciones(38.994537, -0.168094, 80);
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

                    heatlayers = null;

                    console.log("heatLayers:")
                    console.log(heatlayers);
                    if (res && heatlayers) {
                        //var layerControl = L.control.layers({}, { "Seguro": heatlayers[0][0], "Regular": heatlayers[0][1], "Peligro": heatlayers[0][2] }).addTo(map);
                        //var layerControl = L.control.layers({}, {"Ozono":heatlayers[0], "CO":heatlayers[1]}).addTo(map);
                        L.layerGroup(heatlayers).addTo(map)
                    }
                    interpolar();
                    addlegend();
                }
                else {
                    if (res) {
                        var layerControl = L.control.layers({}, { "Ozono": res[0], "CO": res[1] }).addTo(map);
                    }
                }



                //Se buscan las estaciones de españa y alrededores
                buscarEstaciones(miLocalizacion, 99);
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

    for (var i = 0; i < listaozono.length; i++) {
        console.log(listaozono[i][1])
        var puntos = getPuntos((listaozono[i][1]))
        listaPuntosOzono.push(puntos);
    }
    for (var i = 0; i < listaco.length; i++) {
        console.log(listaco[i][1])
        var puntos = getPuntos((listaco[i][1]))
        listaPuntosCO.push(puntos);
    }

    //console.log("Debugueame esta")
    //console.log(listaPuntosOzono)

    for (var i = 0; i < listaPuntosOzono.length; i++) {
        console.log("Debug Posicion: " + i);
        console.log("listaPuntosOzono[" + i + "]: ");
        console.log(listaPuntosOzono[i])
        console.log("listaozono[" + i + "][0]: ");
        console.log(listaozono[i][0])
        listaHeatOzonoLayers.push(L.heatLayer(listaPuntosOzono[i], listaozono[i][0]));
    }
    for (var i = 0; i < listaPuntosCO.length; i++) {
        console.log("Debug Posicion: " + i);
        console.log("listaPuntosCO[" + i + "]: ");
        console.log(listaPuntosCO[i])
        console.log("listaco[" + i + "][0]: ");
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
//----------------------------------------------------------------------------------------------------------
// listamedicion: [Medicion] --> interpolar()
// Descripción: dibuja en el mapa la interpolación resultante de una lista de mediciones
//----------------------------------------------------------------------------------------------------------
function interpolar() {
    console.log("--------------------------------")
    console.log("--------------------------------")
    console.log("Empieza la interpolación")
    console.log("--------------------------------")
    console.log("--------------------------------")

    listalat = []; listalong = []; listaint = []; listares = [];
    for (var i = 0; i < GlobalListaPuntos.length; i++) {
        listalat.push(GlobalListaPuntos[i].latitud);
        listalong.push(GlobalListaPuntos[i].longitud);
        listaint.push(GlobalListaPuntos[i].valor);

        listares.push([listalat[i], listalong[i], listaint[i] * 2.5]);
    }

    console.log(listares)

    var grad = {
        0.0: 'green',
        0.2: 'lime',
        0.4: 'yellow',
        0.5: 'orange',
        0.6: 'red',
        1.0: 'white'
    };

    config = { opacity: 0.3, cellSize: 10, exp: 20, max: 90, gradient: grad };
    //config = { opacity: 0.3, cellSize: 10, exp: 20, max: 75, gradient: {0.1: 'green', 0.5: 'yellow', 1: 'red'} };
    //config = {opacity: 0.3, cellSize: 10, exp: 2, max: 1200};

    var idw = L.idwLayer(listares, config);
    /*
    test =[];
    num=[];
    for(var i=0;i<10; i++){
        num.push((listares[i][2]));
    }
    console.log("num[]")
    console.log(num)
    for(var i=0; i<10; i++){
        test.push([listares[i][0],listares[i][1],num[i]])
    }
    console.log(test);
    var idw = L.idwLayer(test, config);
    */
    idw.addTo(map);

    //centrarEn([39.0042, -0.15977],16);
}
//----------------------------------------------------------------------------------------------------------
// addlegend()
// Descripción: representa una leyenda en el mapa
//----------------------------------------------------------------------------------------------------------
function addlegend() {
    var legend = L.control({ position: 'bottomright' });
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'legend');
        var labels = ["Seguro", "Regular",
            "Peligroso"];
        var grades = [0, 50, 75];
        div.innerHTML = '<div><b>Leyenda</b></div';
        for (var i = 0; i < grades.length; i++) {
            div.innerHTML += '<i style="background:' + getCountyColor(grades[i]) + ' ">&nbsp;&nbsp;' + labels[i] + '<br/>';
        }
        return div;
    }
    legend.addTo(map);
}
function getCountyColor(popEst) {
    if (popEst >= 75) {
        return 'red';
    } else if (popEst >= 50) {
        return 'yellow';
    } else {
        return 'lime';
    }
};

// Función para buscar estaciones y agregarlas al mapa
function buscarEstaciones(local, radioKm) {
    if(estacionesCargadas!=true){
    console.log("BUSCANDO ESTACIONES");
    var lat = local[1]; // Latitud
    var lng = local[0]; // Longitud
   
    lat= 38.988576;
    lng = -0.174931;
    console.log("lat:" + lat + " lng:" + lng);
    // Calcular grados de latitud y longitud para el radio
    var latitudGrados = radioKm / 111; // Aproximación
    var longitudGrados = radioKm / (111 * Math.cos(lat * Math.PI / 180)); // Ajuste por coseno de la latitud
    console.log("longitudGrados:" + longitudGrados + " latitudGrados:" + latitudGrados)
    // Calcular los límites
    var latMin = lat - latitudGrados;
    var latMax = lat + latitudGrados;
    var lngMin = lng - longitudGrados;
    var lngMax = lng + longitudGrados;

    // Construir la URL de la API
    var token = "a6e94931d9ab07c950fbdce95db0c38d4ccb13b8"; // Tu token API
    var latlngBounds = latMin + "," + lngMin + "," + latMax + "," + lngMax;
    console.log(latlngBounds);
    var url = "https://api.waqi.info/map/bounds/?token=" + token + "&latlng=" + latlngBounds;

    
    $.getJSON(url, function (response) {
        if (response.status === "ok" & estacionesCargadas == false) {
            //console.log(response)
            response.data.forEach(function (estacion) {
                var fechaHoraISO = estacion.station.time; // Fecha y hora en formato ISO 8601
                var opciones = { year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                var fechaHoraLocal = new Date(fechaHoraISO).toLocaleString(undefined, opciones); // Convertir a fecha y hora local sin segundos
    
                var marcador = L.marker([estacion.lat, estacion.lon]).addTo(map);
                marcador.bindPopup("Estación: " + estacion.station.name + "<br>Nivel AQI: " + estacion.aqi + "<br>Instante de la lectura: " + fechaHoraLocal);
                console.log("Estaciones añadidas");
                estacionesCargadas=true;
            });
        } else {
            console.log("No se pudo obtener la información de la API");
        }
        estacionesCargadas=true;
    });
    
}}
