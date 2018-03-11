$(document).ready( function () {
    $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav();
    $('.modal').modal();
    attach("main");
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

function attach(id,page){
    $( "#container" ).empty();
    console.log(page);
    $.ajax({
        method: "POST",
        url: "../routing/DashboardRouting.php",
        data: "control="+id+"&current="+page,
        success: function(html) {
           $("#container").append(html);
           //window.history.pushState("Stoam", "Stoam", window.location.pathname+url);
        }
     });
}