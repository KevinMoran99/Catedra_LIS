function startCarousel() {
    $('.carousel.carousel-slider').carousel({ fullWidth: true });
    $('#game1-banner').css("background-image", "url('../web/img/nierBanner.jpg')");
    $('#game2-banner').css("background-image", "url('../web/img/bioshockBanner.jpg')");
    $('#game3-banner').css("background-image", "url('../web/img/childoflightBanner.jpg')");
    $('#game4-banner').css("background-image", "url('../web/img/darksidersBanner.jpg')");
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