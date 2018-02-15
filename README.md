# Catedra_LIS
* Imagenes banner/screenshots = 1280×720 
* Imagenes cover = 256x320

## Colores ##
* Headers: purple darken-2 (#7b1fa2)
* Cosas extra: purple (#9c27b0)
* Botones e input: blue (#2196f3)

# Modularidad en frontend
Tanto en el sitio público como en el privado, hay una carpeta llamada templates. Ahí deberan ir todas las porciones de frontend que serán reutilizadas. Los archivos que tienen esas carpetas hasta ahora son:
* sidenav.html: La maquetación del sidenav.
* styles.html: Todas las tags <link> y otras tags que pertenezcan al <head>, que serán comunes para todas las páginas (Como por ejemplo el link al archivo de materialize).
* scripts.html: Todas las tags <script> que serán comunes para todas las páginas.
  
Estos tres archivos deberan ser referenciados en todas las vistas por medio de <?php include 'ruta del archivo';?>

Además, existen los archivos css/main.css y js/main.js, en los cuales deberán ser incluidos respectivamente todos los estilos y scripts que serán comunes para todas las páginas, como la inicialización de componentes de materialize. (Estos archivos ya van incluidos en las templates).
