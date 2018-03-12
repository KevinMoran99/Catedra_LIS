$('#frmSignIn').submit(function (e) {
    e.preventDefault();

    $.ajax({
        method: 'POST',
        data: {
            "input" : $(this).serialize(),
            "method" : "login"
        },
        url: "../http/controllers/UserController.php",
        success: function (result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                if (output[1] == "admin")
                    window.location.replace("index.php");
                else
                    window.location.replace("../public/index.php");
            }
            else
                swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});