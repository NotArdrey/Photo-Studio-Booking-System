

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoStudio</title>
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha384-0u1+Ko2A3WSXU8B8v7uYF6WfhMTzAC5ZfZx5ddtKkM4KaNmi5a68F40Vz5Dui1Li" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
        .static-alert-container {
            position: absolute; 

        }
    </style>
</head>
<body>
    <div class="container">
                    <div class="left">
                    <form class="forms" action="../function/login.php" method="POST">
                <div class="title">
                    <h1>Welcome Admin!</h1>
                </div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your Username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <div class="show-pass">
                    <input type="checkbox" id="show-pass" name="show-pass" value="show-pass" onclick="togglePassword()">
                    <label for="show-pass">Show Password</label>
                </div>
                <div class="btn">
                    <button type="submit" class="styled-button">Login</button>
                </div>
            </form>
        </div>
        <div class="right">
            <div class="right-photo">
                <i class="fa-solid fa-user-tie"></i> 
            </div>
        </div>
    </div>
</body>
</html>
<?php
    session_start();
    if (isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
     ?>


<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
</script>
