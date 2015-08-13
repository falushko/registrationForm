/**
* Just a simple function to enable / disable our submit button
* It lets the user know we're working on the request, and something is actually happening.
*/
(function() {
    $.fn.toggleButton = function() {
        var $this = $(this),
            disabled = $this.attr('disabled');

        ( ! disabled) ? $this.html('Submitting...').attr('disabled', 'disabled')
            : $this.html('Send!').attr('disabled', '');

        return this;
    }
    })();

// Shortcut to $(document).ready()
$(function() {

    // cities ajax inflater
    $('#sel1').change(function(){
        var id_country = $("#sel1 :selected").val();
        $.post('controllers/citiesInflater.php', "country="+id_country , function(data){
                // get formatted data
                var parsed = JSON.parse(data);

                // clear previous datas
                $('#sel2 option').remove();
                var cities = $('#sel2');
                cities.append("<option value=\"default\" selected>" + "Город" + "</option>>");

                //inflate selector with correspond cities
                for(var i = 0, length = parsed.length; i < length; i++){
                    cities.append("<option value=\"" + parsed[i].id_city + "\">" + parsed[i].city_name +"</option>>");
                }
            }
        );
    });

    //send form
    $('#send').click(function(){

        var data = $('form').serialize();

        $.post('controllers/controller.php', data, function(result){

            if(result === "success") {
                console.log(result);
                $("#success").fadeIn(300, function () {
                    setTimeout(function () {
                        $("#success").fadeOut(300);
                    }, 1500);

                });
                clearErrorFields();
                clearFormFields();
            }else{
                var res = JSON.parse(result);

                showHideErrorMessage($("#loginError"), res.login);
                showHideErrorMessage($("#passError"), res.password);
                showHideErrorMessage($("#phoneError"), res.phone);
                showHideErrorMessage($("#inviteError"), res.invite);
            }

        });
    });

    $("#clear").click(function(){
        clearFormFields();
        clearErrorFields();
    });

    // error messages toggle
    function showHideErrorMessage(field, message){
        if (message !== ""){
            field.text(message);
            field.show();
        } else{
            field.hide();
        }
    }

    // clear all error fields
    function clearErrorFields(){
        $("#loginError").hide();
        $("#passError").hide();
        $("#phoneError").hide();
        $("#inviteError").hide();
    }

    //clear form fields
    function clearFormFields(){
        $("#login").val("");
        $("#pass").val("");
        $("#confirm").val("");
        $("#phone").val("");
        $("#invite").val("");
        $("#sel2").val("default");
        $("#sel1").val("default");
    }






    // Attach function to the 'submit' event of the form
    $('#form').submit(function() {
        var self = $(this), 		 // Caches the $(this) object for speed improvements
            post = self.serialize(); // Amazing function that gathers all the form fields data
                                     // and makes it usable for the PHP

        // Disable the submit button
        self.find('#send').toggleButton();

        // Send our Ajax Request with the serialized form data
        $.post('controller.php', post, function(data) {
            // Since we returned a Json encoded string, we need to eval it to work correctly
            var data = eval('(' + data + ')');

            // If everything validated and went ok
            if (data.result == 'success') {
                // Fade out the form and add success message
                $('#contact').fadeOut(function() {
                    $(this).remove();
                    $('<div class="message success"><h4>Thanks for your email!</h4></div>')
                        .hide()
                        .appendTo($('#form'))
                        .fadeIn();
                });
            }
            else {
                // Hide any errors from previous submits
                $('span.error').remove();
                $(':input.error').removeClass('error');

                // Re-enable the submit button
                $('#contact').find('button').toggleButton();

                // Loop through the errors, and add class and message to each field
                $.each(data.errors, function(field, message) {
                    $('#' + field).addClass('error').after('<span class="error">' + message + '</span>');
                });
            }
        });

        // Don't let the form re-load the page as would normally happen
        return false;
    });

    });
