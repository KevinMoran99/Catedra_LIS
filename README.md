# Catedra_LIS
* Imagenes banner/screenshots = 1280×720 
* Imagenes cover = 256x320

## Colores ##
* Headers: purple darken-2 (#7b1fa2)
* Cosas extra: purple (#9c27b0)
* Botones e input: blue (#2196f3)

## Para llamar los archvos desde sidenav
En el evento onclick agregar el metodo attach("nombre-vista-sinextension")

## Modularidad en frontend
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

## Métodos comunes de los modelos

Para usar cualquier método de un modelo, lo primero será hacer una instancia sin parámetros del modelo (ej. new Action()). Todos los atributos de los modelos tienen sus respectivos getters y setters.
- getAll: Devuelve un array que contiene todos los registros de la tabla a la que corresponda el modelo
- init: Es equivalente a un constructor que toma como parámetros todos los atributos del modelo. Sirve para setear todos los atributos del modelo de una vez. Ej.:
  ```php
  $action = new Action(); 
  $action->init(1, "Guardar catálogo", 1);
  ```
- getById: Requiere que previamente se le halla seteado un id con setId(). Una vez llamado, el objeto se convertirá en un objeto correspondiente al id que se le seteó previamente. Ej.:
  ```php
  $action = new Action(); 
  $action->setId(1);
  $action->getById(); //Ahora $action contiene los datos del registro con el id 1
  ```
- insert: Requiere que previamente se le halla seteado todos los atributos al objeto (menos el id, no se tomará en cuenta). Hace el insert en la base de datos con los atributos que tenga el objeto. Ej.:
  ```php
  $action = new Action(); 
  $action->init(1, "Guardar catálogo", 1); //El id no influye
  $action->insert(); //Registro guardado
  ```
- update: Requiere que previamente se le halla seteado todos los atributos al objeto. Hace el update en la base de datos con los atributos que tenga el objeto, sobre el id especificado. Ej.:
  ```php
  $action = new Action(); 
  $action->init(1, "Modificar catálogo", 0); 
  $action->update(); //Registro modificado
  ```
- search: Devuelve un array que contiene todos los registros de la tabla a la que corresponda el modelo, filtrados por el valor especificado, el cual se pasa como parámetro y es evaluado por todos los campos de la tabla a los que se les pueda aplicar filtros.
  ```php
  $action = new Action(); 
  $array = $action->search("catálogo"); //Devolvería un array con todos los registros en los que se encuentre la palabra 'catálogo'
  ```
## Variable de sesión
Al iniciar sesión, un objeto User correspondiente al usuario logeado es guardado en $_SESSION["user"]. Se puede acceder a sus atributos como con cualquier otro objeto User. Solo hay que tener en cuenta que para usarlo, siempre hay que llamar al método session_start() en la clase en la que se usará, para reanudar la sesión hecha. Si no se hace eso, al intentar interactuar con las cosas relativas a la sesión, el servidor se comportará como si no hubiera sesión iniciada.
 
