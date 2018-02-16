$(document).ready( function () {
    $('.dropdown-trigger').dropdown({
        hover: true
    });
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').select();
    $('.button-collapse').sidenav();
    $('.userLogged').toggle();
    attach("main");
});

/*  $('.dropdown-content').on('click', function(event) {
    event.stopPropagation();
});*/

//Código de login provisional
$('form').submit( function (e) {
    e.preventDefault();
    //Reemplazamos link de Iniciar Sesion por el de Cuenta y el Carrito de compras
    $('.noLogin').toggle();
    $('.userLogged').toggle();
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
    switch (id){
        case "main":
            url = id;
        break;
        case "games":
            url=id;
        break;
        case "about":
            url=id;
        break;
        case "gameDetail":
            url=id;
        break;
        case "support":
            url=id;
        break;
        case "userDetail":
            url=id;
        break;
    }
    
    $.ajax({
        method: "POST",
        url: "backend/AjaxControl.php",
        data: "control="+url,
        success: function(html) {
           $("#container").append(html);
           startCarousel();
           //window.history.pushState("Stoam", "Stoam", window.location.pathname+url);
        }
     });
    
}