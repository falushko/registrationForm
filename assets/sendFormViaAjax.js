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
        var country = $("#sel1 :selected").text();
        $.post('controllers/citiesInflater.php', "country="+country , function(data){
                // get formatted data
                var parsed = JSON.parse(data);

                // clear previous data
                $('#sel2 option').remove();
                var cities = $('#sel2');
                cities.append("<option value=\"\" disabled selected>" + "Город" + "</option>>");

                //inflate selector with correspond cities
                for(var i = 0, length = parsed.length; i < length; i++){
                    cities.append("<option>" + parsed[i] + "</option>>");
                }
            }
        );
    });


    $('#send').click(function(){

        var data = $('form').serialize();

        $.post('controllers/controller.php', data, function(result){
            var res = JSON.parse(result);
            console.log(res);

        });
    });




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
