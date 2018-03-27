$('table').on('change','.ban',function () {
    var visible = 0;
    var id = $(this).closest("tr").find(".id").text();
    if ($(this).is(':checked')) {
        visible = 1;
    }
    updateState(id, visible);
});

function updateState(id, visible) {
    var formData = new FormData();
    formData.append("id", id);
    formData.append("visible", visible);
    formData.append("method", "updateRatingVisible");
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/RatingController.php",
        success: function (result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#review-modal').modal('close');
            }
            console.log(result);
            swal({
                title: output[0],
                text: output[1],
                icon: output[2],
                button: 'Aceptar',
                closeOnClickOutside: false,
                closeOnEsc: false
            })
        }

    });
}

/*METODO PARA BUSCAR*/
$("#review-search").keypress(function (e) {
    //validacion para verificar si presiono enter
    if (e.which == 13) {
        var formData = new FormData();
        formData.append("param", $("#review-search").val());
        formData.append("method", "searchRating");
        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: formData,
            contentType: false,
            processData: false,
            url: "../http/controllers/RatingController.php",
            success: function (result) {
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);
                console.log($data[0]["billItem"]["storePage"]["game"]["name"]);
                $("#allReviews").empty();
                $("#reviewLinks").empty();
                //generando un row por registro
                for (var i = 0; i < $data.length; i++) {

                    var $checked = "";
                    if ($data[i].visible == 1) {
                        $checked = "checked";
                    }

                    $("#allReviews").append(" <tr>" +
                        "<td class='id' style='visibility: hidden; display:none;'>"+$data[i].id+"</td>" +
                        "<td>"+$data[i].billItem.storePage.game.name+"</td>" +
                        "<td>"+$data[i].description+"</td>" +
                        "<td>"+$data[i].reviewDate+"</td>" +
                        "<td>" +
                        "     <label>" +
                        "     <input class='ban' type='checkbox' "+$checked+" />" +
                        "     <span></span>" +
                        "     </label>" +
                        "</td>" +
                        "</tr>");
                }
            }
        });
    }
});

$("#revert").click(function () {
    $("#allReviews").empty();
    $("#reviewLinks").empty();
    attach("review", 1);
});