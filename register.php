<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = $_POST["password"];
    $query = "";

    if ($role === 'contractor') {
        $query = "INSERT INTO contractor (name, email, role, password) VALUES ('$name','$email','$role', '$password')";
    } elseif ($role === 'supervisor') {
        $query = "INSERT INTO supervisor (name, email, role, password) VALUES ('$name','$email','$role', '$password')";
    }elseif ($role === 'project_manager') {
        $query = "INSERT INTO users (name, email, role, password) VALUES ('$name','$email','$role', '$password')";
    }
    if (!empty($query)) { 
        if (mysqli_query($conn, $query)) {
            ?>
            <script>
                alert("Registration successful!");
            </script>
            <?php
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid role: $role";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link rel="stylesheet" href="./assets/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>
<body>
<div class="signup-form">
        <div class="container">
            <div class="header">
                <h1>Create an Account</h1>
                <p>Get started for free!</p>
            </div>
            <form id="registration-form" action="register.php" method="POST">
            <div class="input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="name" name="name" placeholder="Name" />
                </div>
                <div class="input">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Email" />
                </div>
                <div class="input">
                    <i class="fa-solid fa-user"></i>
                    <select id="role" name="role" style="
                    width: 100%;
                      border: none;
                      padding: 8px 40px;
                      border-radius: 4px;
                      background-color: #f3f4f6;
                      color: #1f2937;
                      font-size: 16px;">
                        <option value="project_manager">Project Manager</option>
                        <option value="contractor">Contractor</option>
                        <option value="supervisor">Supervisor</option>
                    </select>
                </div>
              
                <div class="input">
                <i class="fa-solid fa-eye" id="password-toggle"></i>
                    <input type="password" id="pass" name="password" placeholder="Password" />
                    
                </div>
                <div class="input">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="cnpass" name="cnpass" placeholder="Confirm Password" />
                </div>
                <input class="signup-btn" type="submit" name="register" value="SIGN UP" />
            </form>
            <p>Already have an account <a href="index.php">Login</a></p>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#password-toggle').click(function() {
            const passwordField = $('#pass');
            const passwordToggle = $(this);

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                passwordToggle.addClass('fa-eye-slash').removeClass('fa-eye');
            } else {
                passwordField.attr('type', 'password');
                passwordToggle.addClass('fa-eye').removeClass('fa-eye-slash');
            }
        });
    });

   
</script>
<script>
$(document).ready(function() {
    function validateForm() {
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#pass").val();
        var confirmPassword = $("#cnpass").val();

        
        $(".error-message").remove();
        var hasErrors = false;

        if (name === "") {
            $("#name").after('<span class="error-message">Name is required</span>');
            hasErrors = true;
        }

        if (email === "") {
            $("#email").after('<span class="error-message">Email is required</span>');
            hasErrors = true;
        } else if (!isValidEmail(email)) {
            $("#email").after('<span class="error-message">Invalid email format</span>');
            hasErrors = true;
        }

        if (password === "") {
            $("#pass").after('<span class="error-message">Password is required</span>');
            hasErrors = true;
        } else if (password.length < 8) {
            $("#pass").after('<span class="error-message">Password must be at least 8 characters long</span>');
            hasErrors = true;
        }

        if (confirmPassword !== password) {
            $("#cnpass").after('<span class="error-message">Passwords do not match</span>');
            hasErrors = true;
        }

        return !hasErrors;
    }

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    $("#registration-form").submit(function(event) {
        if (!validateForm()) {
            event.preventDefault(); 
        }
    });
});
</script>



</html>