$(document).ready(function() {
    var image =  $("#banner");
    image.css('visibility','hidden');
    $(".gameBackground").css("background-image", "url('"+image.text()+"')");
});