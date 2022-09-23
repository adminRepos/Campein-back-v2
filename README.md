# Como Desplegar el proyecto en ambiente Dev 
## Versiones y Apps 
-PHP => V 8.1
-Composer en su ultima version 
-MySql 
## Pasos para el despliegue en Local 
Clonar repositorio  

-Asegurese de  copiar el .env.example con el nombre .env

-En el nuevo archivo configure su conexion a su servidor de BD local

-La variable **DB_DATABASE** cambie su valor por **campein**

-Luego dirijase a su servidor de BD y cree una BD vacia con ese mismo nombre (**campein**)

------------------------------------------------------------------------------------------
-Abra una terminal en el Directorio raiz del proyecto 
-Ejecute el comando **composer install** (El comando debe instalar todas las dependencias de PHP recordar en su version 8.1 o superior) 
-Luego de esto verifique que la instalacion fue correcta con el comando **php artisan serve** esto iniciara el servidor local 
 -.1 La primera vez siempre te pedira ejecutar el comando **php artisan key:generate**
-Una vez el proyecto corra correctamente cierra su ejecucion con **CTRL + C**
-Ejecuta el comando para llenar nuestra base de datos con sus tablas relaciones y algunos datos primordiales con **php artisan migrate**
-Por ultimo ejecute el comando **php artisan jwt:secret** este nos configura el JWT el cual es nuestro middleware para la autenticacion
## **TODO LISTO !**
-Para conocer las rutas de las APIS dirijase al directorio desde la raiz **routes/api.php**
-Todas las Apis se ejecutan desde la direccion **(direccion local)/api/(Api que desea ejecutar)**
### Recuerde que existen apis que requienren del envio de Token de autorizacion mediante los headers con BearerToken 
