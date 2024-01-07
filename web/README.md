# Servidor CleanBajoqueta.

## Base de la web para el proyecto, escrita con php, html y css.

Esta web es mi apuesta para la base de nuestro proyecto de biometría. 
El uso de boostrap hace que sea responsive, a la vez que práctico y útil. 
En su versión inicial, he construido un login simple para poder visualizar las mediciones con el minor y major.

## Como instalar el servidor y hacer funcionar la web

Mi opción ha sido usar xampp, así que comenzaremos con una instalación limpia de este en C:.

1. Clonar el repositorio de este proyecto.
2. Colocar los archivos del repositorio en la siguiente ruta C:\xampp\htdocs
3. Arrancar xampp con permisos de administrador.
4. En el panel de xampp, empezar los servicios de Apache y MYSQL.
5. En MYSQL, pulsar en admin para abrir phpmyadmin.
6. Importar la base de datos SQL incluida en este proyecto. 
7. Comprobar que tanto arduino como android funcionan correctamente y envían datos.
8. Acceder desde cualquier navegador a localhost.
9. Las credenciales para iniciar sesión son usuario: Admin y contraseña: 1234.
10. El ID, minor y major de la última medición aparecerán en la pantalla.

## Como ejecutar los tests
### Test de inserción y borrado en la base de datos, tabla de medicion y usuarios
Con el servidor operativo, acceder desde cualquier navegador a esta url: http://localhost/tests/test_bd.php. O bien pulsar
en la pantalla de incio el botón tests. También se puede desde consola ejecutando el comando php test_bd.php, por ejemplo:  C:\xampp\htdocs\Web3AZpasgon\tests php test_bd.php Una vez dentro, se obrevarán los datos introducidos y si han pasado con éxito las pruebas o no.También hay un botón salir para volver a la página de inicio.

## Como instalar el servidor de correo necesario para la verificación y restablecimiento de contraseñas
###*Al modificar los archivos abrirlos con el visualCode u otro programa similar, tener mucho cuidado con los caracteres invisibles*

1. Entrar a la carpeta del XAMPP y comprobar que existe una carpeta llamada sendmail, si no es así, hay que desinstalar el 
XAMPP y volverlo a instalar teniendo marcada la casilla de Fake Sendmail
2. Abrir el archivo php.ini dentro de la carpeta php y buscar con ctl+b el apartado de mail funcion
3.Modificar los siguientes apartados:
SMTP=smtp.gmail.com
smtp_port=587
sendmail_path="C:\xampp\sendmail\sendmail.exe -t" *(quitar el punto y coma iniciales, esta es la ruta donde esta instalado el archivo sendmail.exe en la carpeta sendmail en la ruta del xamp, el -t tiene que estar al final)*

4. Modificar el archivo sendmail.ini de la carpeta sendmail con estos valores:
smtp_server=smtp.gmail.com
smtp_port=587
auth_username=bajoquetabluesky@gmail.com
auth_password=sfubwqfoijhjfpta

## Bugs conocidos
### Bugs con la base de datos
Si al tener todo funcionando, solo aparece una medida con id 0 en la página web, comprobar que en la base de datos, la tabla medicion 
tenga el id autoincremental. Ya que para mostrar la última medida, ordeno de forma descendiente el id. El bug me ocurrió cuando traté de 
probar en un ordenador diferente empezando todo de cero, y todavía no se si se debe a un error en la exportación o importación de la 
base de datos.

## Error "Not found" al pulsar botones
Actualmente en la web solo funciona el login, recibir mediciones y cerrar la sesión. 
Los botones aún no tienen ninguna utilidad ya que no se pedía en este sprint.
