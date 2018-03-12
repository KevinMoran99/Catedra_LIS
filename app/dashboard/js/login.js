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
            //Unexpected caca '<'
            eval(result);
        }
    });
});