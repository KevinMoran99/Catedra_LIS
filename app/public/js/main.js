/*inicializa el carousel de la pagina principal*/
startCarousel();

function startCarousel() {
    $('.carousel.carousel-slider').carousel({ fullWidth: true });
    var carrouselItems = $(".carousel div.carousel-item");
    carrouselItems.each(function (index) {
        var image = $(this).find('#carousel-image').text();
        $(this).css("background-image", "url('"+image+"')");
    });
    if(carrouselItems.length>1){
        setInterval(function() {
            $('.carousel').carousel('next');
        }, 5000);
    }
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