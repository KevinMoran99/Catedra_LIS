$(document).ready(function() {
    var elem = document.querySelector('select');
    var instance = M.FormSelect.init(elem);
    $('.datepicker').datepicker();
    $('.tooltipped').tooltip();
});