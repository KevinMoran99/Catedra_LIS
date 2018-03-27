$('.ban').change(function(){
    var visible = 0;
    var id = $(this).closest("tr").find(".id").text();
    if ($(this).is(':checked')) {
        visible = 1;
    }
    updateState(id,visible);
});

function updateState(id,visible) {
    var formData = new FormData();
    formData.append("id",id);
    formData.append("visible",visible);
    formData.append("method","updateRatingVisible");
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/RatingController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#review-modal').modal('close');
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }

    });
}