<?php
session_start();
include('conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM users WHERE email = ?";
    
   
    $stmt = $conn->prepare($sql);
    
  
    $stmt->bind_param("s", $email);
    
    
    $stmt->execute();
    
    
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        
        if ($password == $row["password"]) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"]; 
            $_SESSION["user_role"] = $row["role"]; 
            header("Location: project_mng.php"); 
        } else {
            echo "Incorrect password. <a href='index.php'>Try again</a>";
        }
    } else {
        echo "User not found. <a href='index.php'>Try again</a>";
    }

    $stmt->close();
    $conn->close();
}

include('conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM supervisor WHERE email = ?";
    
   
    $stmt = $conn->prepare($sql);
    
  
    $stmt->bind_param("s", $email);
    
    
    $stmt->execute();
    
    
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        
        if ($password == $row["password"]) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"]; 
            $_SESSION["user_role"] = $row["role"]; 
            header("Location: supervisor.php"); 
        } else {
            echo "Incorrect password. <a href='index.php'>Try again</a>";
        }
    } else {
        echo "User not found. <a href='index.php'>Try again</a>";
    }

    $stmt->close();
    $conn->close();
}

include('conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM contractor WHERE email = ?";
    
   
    $stmt = $conn->prepare($sql);
    
  
    $stmt->bind_param("s", $email);
    
    
    $stmt->execute();
    
    
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        
        if ($password == $row["password"]) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"]; 
            $_SESSION["user_role"] = $row["role"]; 
            header("Location: contractor.php"); 
        } else {
            echo "Incorrect password. <a href='index.php'>Try again</a>";
        }
    } else {
        echo "User not found. <a href='index.php'>Try again</a>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
            <form id="registration-form" action="index.php" method="POST">
           
                <div class="input">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Email" />
                </div>
              
              
                <div class="input">
                <i class="fa-solid fa-eye" id="password-toggle"></i>
                    <input type="password" id="pass" name="password" placeholder="Password" />
                    
                </div>
               
                <input class="signup-btn" type="submit" name="login" value="SIGN IN" />
            </form>
            <div id="error-container"></div>
            <p>Already have an account <a href="register.php">Register</a></p>
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




</html>