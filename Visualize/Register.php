<?php
include 'connect.php';
$success = 0;
$unsuccess = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    $username = $_POST['username'];
    if (!preg_match('/^[a-zA-Z]+$/', $username)) {
        $errors[] = "Please enter a valid username (only alphabetic characters allowed).";
    }

   

    // Validate email
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate mobile number
    $mobile = $_POST['mobile'];
    if (!preg_match('/^(?:254|\+254|0)?(7(?:(?:[12][0-9])|(?:0[0-8])|(?:9[0-2]))[0-9]{6})$/', $mobile)) {
        $errors[] = "Please enter a valid Kenyan phone number.";
    }

    // Validate password
    $password = $_POST['password'];
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
        $errors[] = "Please enter a strong password.";
    }

    // Confirm password
    $confirmPassword = $_POST['confirm'];
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Other validations...

    if (empty($errors)) {
        // Proceed with registration
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
   

    //creates the hash for user password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if email exists
    $mysql = "SELECT * FROM form WHERE username='$username'";
    $myresult = mysqli_query($connect, $mysql);
    if ($myresult) {
    if(mysqli_num_rows($myresult) > 0) {
        $unsuccess = 1; // username already exists
    } else {
        $sql = "INSERT INTO form(username,email,mobile,password,confirm) VALUES('$username','$email','$mobile','$password_hash','$confirm')";
        $result = mysqli_query($connect, $sql);
        if ($result) {
            $success = 1;
        } else {
            die(mysqli_error($connect));
        }
    }
}

}
?>
<!DOCTYPE html>
<html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
         body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .container {
            display: flex;
            height: 100%;
        }

        .image-container {
            flex: 1;
            padding: 20px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            width: 100%;
            max-height: 100%;
            
        }

        .form-container {
            flex: 1;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container label,
        .form-container input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        .form-container .error {
            color: red;
            margin-bottom: 10px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
        }

        .login-link a {
            color: #007bff;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="image-container">
            <!-- Preload images -->
            <img src="image 13.jpeg" alt="" style="display: none;">
            <img src="image 14.png" alt="" style="display: none;">
            <img src="image 11.jpeg" alt="" style="display: none;">
            
            <img id="myImage" src="image 13.jpeg" alt="Original Image">
        </div>

        <div class="form-container">
            <h2>Register</h2>
            <form method="post">
                <label>Username:</label>
                <input type="text" name="username" placeholder="Username" required>
                <label>Email:</label>
                <input type="email" name="email" placeholder="Email" required>
                <label>Mobile Number:</label>
                <input type="number" name="mobile" placeholder="Mobile Number" required>
                <label>Password:</label>
                <input type="password" name="password" placeholder="Password" required>
                <label>Confirm Password:</label>
                <input type="password" name="confirm" placeholder="Confirm Password" required>
                <?php
                if ($success) {
                    echo "<div class='error'>Registered Successfully! as $username </div>";
                }
                if ($unsuccess) {
                    echo "<div class='error'>Error</div>";
                }
                ?>
                <button type="submit">Register</button>
                <div class="login-link">
                    Already have an account? <a href="login.php">Login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Change images periodically
        var images = ['image 13.jpeg', 'image 14.png', 'image 11.jpeg']; // Add your image paths here
        var currentIndex = 0;
        var imageElement = document.getElementById('myImage');

        setInterval(function() {
            currentIndex = (currentIndex + 1) % images.length;
            imageElement.src = images[currentIndex];
        }, 5000); // Change image every 5 seconds (adjust as needed)
    </script>
</body>

</html>