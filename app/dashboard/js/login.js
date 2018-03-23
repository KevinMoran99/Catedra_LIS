$('#frmSignIn').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("method","login");
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
            else
                swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});