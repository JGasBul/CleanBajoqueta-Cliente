# Sprint_0_Android de Ruiyu Chen

El objectivo del proyecto es que detecte y calcule el valor de temperatura y co2 que hay en el medio mediante y que estos valores los envia a la aplicación del móvil android mediante un emisor BLE de CO2, de cierta manera se interactua con la base de datos del servidor. Por otro lado, la página web del cliente también se puede visualizar estos valores e interactuar con ellos 

## Tabla de Contenidos

- [Descripción](#descripción)
- [Instalación](#instalación)
- [Uso](#uso)



## Descripción

Principalmente el objectivo de la parte de android para este sprint es que pueda detectar el Ibeacon enviado por el emisor de beacons con el código de arduino, y posteriormente se puede enviar una petición HTTP de método POST al servidor para guardar los valores a la base de datos, Finalmente también se puede hacer con el método GET para comprobar si los valores se han enviado correctamente.


## Instalación

- Clonar el repositorio, abre el proyecto, comprueba que la API es mayor que 31
- Para buscar datos del emisor de beacons deseado, tienes que cambiar en esta linea: this.buscarEsteDispositivoBTLE( "nombre de tu dispositivo" );
- La IP donde se envia la petición HTTP tiene que ser el tuyo
- Asegura que la aplicación tiene todos los permisos activados

## Uso

- Iniciar la aplicación
- Pulsar botón buscartodosdispositivo o buscarestedispositivo para detectar beacon
- Los datos completos se mostrarán en logcat, solo el minor y el major se muestran en Text View
- Introduce valores de co2, temperatura y pulsa el botón enviar medición para guardarlos en la base de datos
- Pulsa el botón prueba para verificar si los ha enviado correctamente