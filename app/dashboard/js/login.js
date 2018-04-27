$(document).ready(function() {
    $('.modal').modal();
});

//Ajax de login paso 1
$('#frmSignIn').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("method","loginStep1");
    $.ajax({
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserController.php",
        success: function (result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                $('#modalConfirmLogin').modal({
                    dismissible: false
                });
                $('#modalConfirmLogin').modal('open');
            }
            else {
                grecaptcha.reset();
                swal({
                    title: output[0],
                    text: output[1],
                    icon: output[2],
                    button: 'Aceptar',
                    closeOnClickOutside: false,
                    closeOnEsc: false
                })
            }
        }
    });
});

//Ajax de login paso 2
$('#frmConfirmLogin').submit(function (e) {
    e.preventDefault();

    var formData = new FormData();
    formData.append("method","loginStep2");
    formData.append("alias",$("#signInUser").val());
    formData.append("hash",$("#confirmHash").val());
    $.ajax({
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserController.php",
        success: function (result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                if (output[1] == "admin")
                    window.location.replace("index.php");
                else
                    window.location.replace("../public/index.php");
            }
            else {
                swal({
                    title: output[0],
                    text: output[1],
                    icon: output[2],
                    button: 'Aceptar',
                    closeOnClickOutside: false,
                    closeOnEsc: false
                })
            }
        }
    });
});

//Ajax de recuperación de contraseña
$("#frmPassLost").submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append('email',$("#passLostEmail").val());
    formData.append("method",'resetPass');
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        //url (?
        url: "../http/controllers/UserController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $("#passLostEmail").val('');
                $('#modalPassLost').modal('close');
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});