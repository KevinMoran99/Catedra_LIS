$(document).ready( function () {
    $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').select();
    $('.userLogged').toggle();
});

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