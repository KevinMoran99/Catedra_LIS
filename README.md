# Catedra_LIS
* Imagenes banner/screenshots = 1280×720 
* Imagenes cover = 256x320

## Colores ##
* Headers: purple darken-2 (#7b1fa2)
* Cosas extra: purple (#9c27b0)
* Botones e input: blue (#2196f3)

## Para llamar los archvos desde sidenav
En el evento onclick agregar el metodo attach("nombre-vista-sinextension")

# Modularidad en frontend
Tanto en el sitio público como en el privado, hay una carpeta llamada templates. Ahí deberan ir todas las porciones de frontend que serán reutilizadas. Los archivos que tienen esas carpetas hasta ahora son:
* sidenav.html: La maquetación del sidenav.
* styles.html: Todas las tags link y otras tags que pertenezcan al head, que serán comunes para todas las páginas (Como por ejemplo el link al archivo de materialize).
* scripts.html: Todas las tags script que serán comunes para todas las páginas.
  
Estos tres archivos deberan ser referenciados en todas las vistas por medio de \<?php include 'ruta del archivo';?>

Además, existen los archivos css/index.css y js/index.js, en los cuales deberán ser incluidos respectivamente todos los estilos y scripts que serán comunes para todas las páginas, como la inicialización de componentes de materialize. (Estos archivos ya van incluidos en las templates).


## Querys

La clase conexion se ubica bajo app/models/Connection.class.php
Los metodos que contienen son:
* select({query},{parametros de query})
* selectOne({query},{parametros de query})
* insertOrUpdate({query},{parametros})

Las query deben adimitir parametros, por ejemplo

"SELECT * FROM users WHERE id=?"

Y los parametros deben ser enviados en un array
$params = array($id)

## Classpaths
Ahora las cosas funcionan bajo namespaces de Composer para poder acceder a las clases
de una manera mas limpia y bonita, dichos namespace estan dentro del archivo Composer.JSON
al agregar una nueva ruta debera correrse el comando 
>composer dump-autoload

Eso recreara los namespace y los pondra disponibles para su uso, ademas en toda clase debe hacerse
referencia a el autoload.php (ver modelo de accion)
 
# Instanciar la clase autoload.php SOLO PARA TESTEO
La clase ya se encuentra instanciada por defecto en el Routing de cada vista