$(document).ready( function () {
    $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').select();
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    attach("main");
});

//Cambia el color del item seleccionado del sidenav
$(".menu-item").click(function (event) {
    var triggerer = $(event.target)

    //Si se hace click sobre un li que redirige a games, debe color solamente el li padre
    if (triggerer.parents("li").hasClass("menu-trigger")) {
        if(triggerer.parents("li").hasClass("item-game")) {
            $(".menu-item").removeClass("selected-item");
            $(".menu-item").find("li").removeClass("selected-item");
            $("#menu-games").addClass("selected-item");
        }
    }
    //Si se hace click en cualquier otro li, ocurre el comportamiento normal
    else {
        $(".menu-item").removeClass("selected-item");
        $(".menu-item").find("li").removeClass("selected-item");
        triggerer.parents("li").addClass("selected-item");
    }
    
});

function attach(id){
    $( "#container" ).empty();
    
    $.ajax({
        method: "POST",
        url: "backend/AjaxControl.php",
        data: "control="+id,
        success: function(html) {
           $("#container").append(html);
           startCarousel();
           //window.history.pushState("Stoam", "Stoam", window.location.pathname+url);
        }
     });
    
}