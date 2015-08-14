// Shortcut to $(document).ready()
$(function () {

    // cities ajax inflater
    $('#sel1').change(function () {
        var id_country = $("#sel1 :selected").val();
        $.post('controllers/citiesInflater.php', "country=" + id_country, function (data) {

                // get formatted data
                var parsed = JSON.parse(data);

                // clear previous data
                $('#sel2 option').remove();
                var cities = $('#sel2');
                cities.append("<option value=\"default\" selected>" + "Город" + "</option>>");

                //inflate selector with correspond cities
                for (var i = 0, length = parsed.length; i < length; i++) {
                    cities.append("<option value=\"" + parsed[i].id_city + "\">" + parsed[i].city_name + "</option>>");
                }
            }
        );
    });

    //send form
    $('#send').click(function () {

        // get data from form
        var data = $('form').serialize();

        $.post('controllers/controller.php', data, function (result) {

            // show success message
            if (result === "success") {
                $("#success").fadeIn(300, function () {
                    setTimeout(function () {
                        $("#success").fadeOut(300);
                    }, 1500);
                });

                //clear form data and errors
                clearErrorFields();
                clearFormFields();

                //show errors
            } else {
                var res = JSON.parse(result);
                showHideErrorMessage($("#loginError"), res.login);
                showHideErrorMessage($("#passError"), res.password);
                showHideErrorMessage($("#phoneError"), res.phone);
                showHideErrorMessage($("#inviteError"), res.invite);
            }

        });
    });

    //clear button handler
    $("#clear").click(function () {
        clearFormFields();
        clearErrorFields();
    });

    // error messages toggle
    function showHideErrorMessage(field, message) {
        if (message !== "") {
            field.text(message);
            field.show();
        } else {
            field.hide();
        }
    }

    // clear all error fields
    function clearErrorFields() {
        $("#loginError").hide();
        $("#passError").hide();
        $("#phoneError").hide();
        $("#inviteError").hide();
    }

    //clear form fields
    function clearFormFields() {
        $("#login").val("");
        $("#pass").val("");
        $("#confirm").val("");
        $("#phone").val("");
        $("#invite").val("");
        $("#sel2").val("default");
        $("#sel1").val("default");
    }


});
