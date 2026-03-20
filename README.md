# Prueba Técnica David Tapias

## Pregunta: 
¿Qué cambios harías si este servicio tuviera que soportar 1 millón de usuarios diarios? 
* Para reducir las peticiones hacia el servidor implementaría caché con REDIS, revisaría consultas SQL que estén lo más optimizadas, validar si es conveniente hacer algún proceso como procedimiento almacenado, si hay tareas en segundo plano, desbordarlas a traves de colas, verificar las capacidades del servidor. 

# Comencemos
Para este proyecto he seleccionado como producto para administrar, libros PDF como si se tratara de un administrador de e-books.

# Datos
* Este es un proyecto basado en laravel v12.
* La versión mínima de PHP debe ser la v8.2.0 (no hay que instalarlo)
* La versión mínima de mysql es la v8.0.30 (no hay que instalarlo)
* Se usará como herramienta de despliegue, laragon v6.0 ó v8.0.2 (el cual ya contienen las versiones y servicios mencionados anteriormente).

# Proyectos en github
1. Descargar (API) el proyecto eltiempo, https://github.com/DavidTapias/eltiempo
2. Descargar (Front-end) el proyecto app-eltiempo , https://github.com/DavidTapias/app-eltiempo

# Proceso de despliegue
## Activar servicio de Apache y Mysql
1. Descargar laragon https://laragon.org/download v6.0 ó v.8.6.1
2. Instalar, tenga en cuenta la ubicación donde lo instaló, dejar en check la opción de crear virtual hosts.
3. Al terminar la instalación, abrir la carpeta donde se instaló laragon y ubicarse en la carpeta www. 
4. Pegar los dos proyectos (eltiempo y app-eltiempo) allí y extraerlos, verificar que no queden dentro de subcarpetas y que los nombres sean , eltiempo y app-eltiempo
5. Suba un nivel de carpeta y ubíquese en esta ruta, laragon/etc/apache2/sites-enabled
6. Abra el archivo auto.eltiempo.test.conf con un editor o bloc de notas.
7. Seguramente en la linea de DocumentRoot y Directory la ruta termina en /eltiempo  añada la palabra public en las dos rutas para que termine así, ```eltiempo/public``` y guardar. De esta manera el virtualHost apuntará a la carpeta public de laravel y todas las rutas apuntarán donde deben. (Cuando se crean proyectos desde laragon ésta configuración la hace automática, en este caso no se está creando el proyecto sino que se están usando los servicios, por tal razón hay que añadir esa configuración un poco manual).
8. Abrir la aplicación Laragon.
9. Activar el servicio de Apache y mysql, si no ve los switches para activarlo, puede hacer click derecho y activarlos en el menú desplegado.

## Base de datos
1. En el menú inferior de laragon dar click en Bases de datos, se desplegará el cliente de HeidiSQL. Dejamos los datos como están.
    * Usuario = root
    * Password = 
2. Click en Abrir, se desplegará el cliente. 
3. En el lado izquierdo aparecerán los schemas.
4. Click derecho sobre Laragon.MySQL, elegir. crear nuevo > base de datos
5. Nombrar la DB como el_tiempo , collation: utf8mb4_spanish2_ci y aceptar.
6. Fin.

### Ejecutar migraciones
1. En el menú inferior de laragon, elegir la opcion. Terminal. se abrirá una terminal (esta es la que se debe usar siempre, no la nativa del PC) apuntando a la carpeta www.
2. Escribir el comando, ``` cd eltiempo ```, dar enter, para acceder al proyecto.
3. Escribir el comando ```composer install``` , dar enter.
4. Escribir el comando ```composer update``` , dar enter. Este proceso puede demorar algunos minutos, ya que las dependencias no se suben a github.
5. Intencionalmente se ha subido el archivo .env con los datos de configuración de la app y datos de conexión (No hay que modificar nada allí).
3. Escribir el comando,
    ```php artisan migrate --seed``` , dar enter , 
se crearán las tablas del proyecto automáticamente dentro de la DB el_tiempo y poblará dos tablas, un usuario con email y contraseña y una tabla de categorías.
* (opcional) , para rehacer las tablas y agregar de nuevo los datos, escribir en la terminal ```php artisan migrate:fresh --seed```, dar enter.

## Archivos
1. La aplicación almacenará imágenes y pdfs, para activar la carpeta storage, ejecute este comando ```php artisan storage:link```, dar enter.
2. En este punto ha terminado de configurar el despliegue de la API.

NOTA: Sé que Docker facilita estas configuraciones, pero tuve varias incompatibilidades en mi máquina y ya tenía configurado previamente Laragon. 

# IMPORTANTE:
* Si en algún punto no se reconoce alguna ruta, no dude en reiniciar el servicio de apache para que las configuraciones previas tengan efecto.

# Despliegue del front-end
1. Como previamente pegó el proyecto llamado app-eltiempo , solo debe abrir un navegador y escribir, http://app-eltiempo.test/login.html y se mostrará la siguiente imagen.
![Login](https://github.com/DavidTapias/eltiempo/blob/main/README_IMGS/login.JPG?raw=true)

2. Escribir las credenciales.
    * Usuario = pepe@eltiempo.com
    * Contraseña = eltiempo123
3. Al inicar sesión se mostrará el panel de administración sin libros.
![Tabla vacía](https://github.com/DavidTapias/eltiempo/blob/main/README_IMGS/tablaVacia.JPG?raw=true)

4. Ya puede agregar libros e interactuar con el CRUD.

# DEMO

* Agregando un nuevo libro.
![Agregando libro](https://github.com/DavidTapias/eltiempo/blob/main/README_IMGS/nuevoLibro.JPG?raw=true)
* Consultando todos los libros.
![Tabla llena](https://github.com/DavidTapias/eltiempo/blob/main/README_IMGS/tablaLlena.JPG?raw=true)

# Colección de API
En la carpeta API_DOCS  he adjuntado la colección de Postman con la que hice pruebas previamente. Importela a Postman.

* NOTA: Todos los endpoints están protegidos, por lo que debe ejecutar primero el endpoint, http://eltiempo.test/api/v1/login , el cuual generará el token para hacer uso de los demás endpoints, en la sección Authorization, Auth type > Bearer Token.