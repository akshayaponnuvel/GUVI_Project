$(document).ready(function() {
    
    var objectId = localStorage.getItem("objectId");
    var isLoggedIn = checkLoginStatus();
    // If not logged in, display warning and redirect to login page
    if (!isLoggedIn) {
        alert("You need to log in to access your profile.");
        window.location.href = "login.html"; // Change to your login page URL
    }

    // Function to check login status (replace with your actual login check logic)
    function checkLoginStatus() {
        if(objectId){
            return true
        }else{
        return false;
        } 
    }


    // Check if the ObjectId is present
    if (objectId) {
        // Send a POST request to your PHP script
        $.post("./php/profile.php", { objectId: objectId }, function(response) {
            // Handle the response from the server
            console.log(response);
            // You can parse the response JSON if needed
            var redisData = JSON.parse(response);
            // Do something with the data
            // For example, display it on the webpage
            $("#fullname").val(redisData.FullName);
            $("#email").val(redisData.EmailId);
            $("#mobileno").val(redisData.MobileNo);
            
            
        }).fail(function(xhr, status, error) {
            // Handle any errors that occur during the AJAX request
            console.error("Error:", error);
        });
    } else {
        console.log("ObjectId is empty or not available in localStorage.");
    }
    function clearLocalStorage() {
        localStorage.clear();
    }
    
        // Function to clear Redis storage
        function clearRedisStorage() {
            // Send a POST request to clear Redis storage
            $.post("./assets/clear_redis.php", function(response) {
                console.log(response);
            }).fail(function(xhr, status, error) {
                console.error("Error:", error);
            });
        }
    
        // Function to handle logout
        function logout() {
            // Clear localStorage
            clearLocalStorage();
            // Clear Redis storage
            clearRedisStorage();
            // Redirect the user to the logout page or any other desired location
            window.location.href = "index.html";
        }
    
        // Event listener for logout button click
        $("#logout").click(function() {
            logout();
        });


        $("button[type='submit']").click(function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();
    
            // Get the form data
            var formData = {
                fullname: $("#fullname").val(),
                age: $("#age").val(),
                dob: $("#dob").val(),
                mobileno: $("#mobileno").val(),
                email: $("#email").val(),
                bio: $("#bio").val()
            };
    
            // Send an AJAX POST request to update the user's profile
            $.ajax({
                type: "POST",
                url: "./assets/update.php", // Replace with the URL of your server-side script
                data: formData,
                success: function(response) {
                    // Handle the success response (if needed)
                    console.log("Profile updated successfully:", response);
                    alert("Profile updated successfully!");
                },
                error: function(xhr, status, error) {
                    // Handle the error response (if needed)
                    console.error("Error updating profile:", error);
                    alert("Error updating profile. Please try again later.");
                }
            });
        });
    
       
});