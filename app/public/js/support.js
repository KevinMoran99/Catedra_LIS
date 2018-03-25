$(document).ready(function() {
    /* se inicializan elementos*/
    $('.collapsible').collapsible();
});


/*METODO PARA BUSCAR*/
$("#faq-search").keypress( function (e) {
    //validacion para verificar si presiono enter
    if(e.which==13){

        var formData = new FormData();
        formData.append("param",$("#faq-search").val());
        formData.append("method","searchActiveFaq");
        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: formData,
            contentType: false,
            processData: false,
            url: "../http/controllers/FaqController.php",
            success: function(result) {
                //limpiando cuerpo de tabla
                $("#allFaqs").empty();
                //limpiando los links de paginacion
                $("#faqLinks").empty();
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);

                //generando un row por registro
                for(var i=0;i<$data.length;i++){

                    $("#allFaqs").append("<li>" +
                        "<div class=\"collapsible-header\"><i class=\"material-icons\">question_answer</i>"+$data[i].title+"</div>" +
                    "<div class=\"collapsible-body\"><span>"+$data[i].description+"</span></div>" +
                    "</li>");
                }
            }
        });
    }
});

$("#revert").click(function () {
    $("#allFaqs").empty();
    $("#faqLinks").empty();
    attach("support", 1);
});