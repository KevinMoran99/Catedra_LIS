$(document).ready( function () {
    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        indicators: true
      });
});

$('#nextButton').find('i').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $('.carousel').carousel('next');
});

$('#prevButton').find('i').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $('.carousel').carousel('prev');
});
