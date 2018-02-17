$(document).ready( function () {
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('select').select();
    attach("main");
});

//Cambia el color del item seleccionado del sidenav
$(".menu-item").click(function (event) {
    $(".menu-item").removeClass("selected-item");

    var triggerer = $(event.target)

    triggerer.parents("li").addClass("selected-item");
    
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