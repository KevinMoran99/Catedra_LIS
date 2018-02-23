$(document).ready(function() {
    /*inicializamos todos los elementos a ser utilizados en l view*/
    var elem = document.querySelector('#select-rating');
    var instance = M.FormSelect.init(elem);
    $('.datepicker').datepicker();
    $('.tooltipped').tooltip();

    $('.modal').modal();
});