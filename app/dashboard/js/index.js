$(document).ready( function () {
    $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav();
    $('.modal').modal();
    //attach("main");

    //Verificando si la contraseña del usuario no ha expirado
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: {'method' : 'checkPasswordDate'},
        url: "../http/controllers/UserController.php",
        success: function(result) {
            if(result == 1) {
                $('#modalPassExpired').modal({
                    dismissible: false
                });
                $("#modalPassExpired").modal('open');
            }
        }
    });
});

//Cambia el color del item seleccionado del sidenav
$(".menu-item").click(function (event) {
    var triggerer = $(event.target)
    var parent = triggerer.parents("li");
    //Si se hace click sobre un li que redirige a games, debe color solamente el li padre
    if (parent.hasClass("menu-trigger")) {
        if(parent.hasClass("item-game")) {
            $(".menu-item").removeClass("selected-item");
            $(".menu-item").find("li").removeClass("selected-item");
            $("#menu-games").addClass("selected-item");
        }
    }
    //Si se hace click en cualquier otro li, ocurre el comportamiento normal
    else {
        $(".menu-item").removeClass("selected-item");
        $(".menu-item").find("li").removeClass("selected-item");
        parent.addClass("selected-item");
    }

    //Se usa un timeout para darle tiempo para cargar a la vista hija
    setTimeout(function () {
        //Actualizando navbar según el item seleccionado
        if (parent.is("#game-all")) 
            $("#nav-title").html("Todos los juegos:");
        else if (parent.is("#game-offer")) 
            $("#nav-title").html("Ofertas:");
        else if (parent.is("#game-platform")) 
            $("#nav-title").html("Buscar por plataforma:");
        else if (parent.is("#game-publisher")) 
            $("#nav-title").html("Buscar por publicador:");
        else if (parent.is("#game-genre")) 
            $("#nav-title").html("Buscar por género:");
        else if (parent.is("#game-rating")) 
            $("#nav-title").html("Buscar por ratings:");
        else if (parent.is("#game-esrb")) 
            $("#nav-title").html("Buscar por clasificación:");
        else if (parent.is("#game-date")) 
            $("#nav-title").html("Buscar por fecha de lanzamiento:");
    }, 20)
    
});

$("#logout").click(function (e) {
    var formData = new FormData();
    formData.append("method","logout");
   $.ajax({
       method: 'POST',
       data: formData,
       contentType: false,
       processData: false,
       url: "../http/controllers/UserController.php",
       success: function (result) {
           console.log(result);
           window.location.replace("login.php");
       }
   });
});

function attach(id,page){
    $( "#container" ).empty();
    console.log(page);
    $.ajax({
        method: "POST",
        url: "../routing/DashboardRouting.php",
        data: "control="+id+"&current="+page,
        success: function(html) {
            if(html==""){
                window.location.replace("login.php");
            }else{
                $("#container").append(html);
            }

           //window.history.pushState("Stoam", "Stoam", window.location.pathname+url);
        }
     });
}

//Ajax de cambiar contraseña expirada
$("#frmExpired").submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append('pass',$("#expiredPass").val());
    formData.append('passConfirm',$("#expiredConfirm").val());
    formData.append("method",'updatePassword');
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        //url (?
        url: "../http/controllers/UserController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#modalPassExpired').modal('close');
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});