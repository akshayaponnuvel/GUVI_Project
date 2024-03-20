$(document).ready(function() {
    $('#registerForm').submit(function(e) {
        e.preventDefault(); 

        var formData = {
            fullname: $("#fullname").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            mobileno: $("#mobileno").val(),
        };

        console.log(formData);
        $.ajax({
            type: 'POST',
            url: './php/register.php',
            data: formData,
            success: function(response) {
                alert(response);
                window.location.href="login.html"
                // Handle success response here
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
                // Handle error response here
            }
        });
    });
});