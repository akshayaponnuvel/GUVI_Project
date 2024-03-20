$(document).ready(function(){
    $('#loginForm').submit(function(e){
        e.preventDefault(); // Prevent form submission

        // Get form data
        var email = $('#email').val();
        var password = $('#password').val();

        
        $.ajax({
            type: 'POST',
            url: './php/login.php', 
            data: {
                email: email,
                password: password
            },
            success: function(response){
                console.log(response);
                // Handle successful login response
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status && jsonResponse.status.trim() === "success") {
                    // Redirect to profile.html if login is successful
                    var objectId = jsonResponse.objectId;
                    localStorage.setItem('objectId', objectId);
                    window.location.href = "profile.html";
                    // console.log("hii");
                } else {
                    // Handle unsuccessful login
                    alert("Invalid email or password!");
                }
            },
            error: function(xhr, status, error){
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });
});