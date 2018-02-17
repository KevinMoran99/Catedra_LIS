$(document).ready( function () {
    $('.dropdown-trigger').dropdown({
        hover: true
    });
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').select();
    $('.button-collapse').sidenav();
    $('#menu-user').hide();
    attach("main");
});

/*  $('.dropdown-content').on('click', function(event) {
    event.stopPropagation();
});*/

//Cambia el color del item seleccionado del sidenav
$(".menu-item").click(function (event) {
    $(".menu-item").removeClass("selected-item");
    $(".menu-item").find("li").removeClass("selected-item");

    var triggerer = $(event.target)

    //Si se hace click sobre un li que redirige a games, debe color solamente el li padre
    if (triggerer.parents("li").hasClass("menu-trigger")) {
        if(triggerer.parents("li").hasClass("item-game")) {
            $("#menu-games").addClass("selected-item");
        }
    }
    //Si se hace click en cualquier otro li, ocurre el comportamiento normal
    else {
        triggerer.parents("li").addClass("selected-item");
    }
});

//Código de login provisional
$('form').submit( function (e) {
    e.preventDefault();
    //Reemplazamos link de Iniciar Sesion por el de Cuenta 
    $('#menu-login').toggle();
    $('#menu-user').toggle();
});

$('.logout').click( function () {
    location.reload();
});


function startCarousel(){
    $('.carousel.carousel-slider').carousel({ fullWidth: true });
    $('#game1-banner').css("background-image", "url('img/nierBanner.jpg')");
    $('#game2-banner').css("background-image", "url('img/bioshockBanner.jpg')");
    $('#game3-banner').css("background-image", "url('img/childoflightBanner.jpg')");
    $('#game4-banner').css("background-image", "url('img/darksidersBanner.jpg')");
    setInterval(function() {
        $('.carousel').carousel('next');
    }, 5000);
}
$('#nextButton').find('i').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('.carousel').carousel('next');
});

$('#prevButton').find('i').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('.carousel').carousel('prev');
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