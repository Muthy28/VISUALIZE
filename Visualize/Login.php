<?php
$success = 0;
$unsuccess = 0;
// Start a user session
session_start();
include 'connect.php'; // Include database connection file
$unsuccessful = false;
$usernameError = "";
$passwordError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from the database
    $sql = "SELECT * FROM form WHERE username='$username'";
    $result = mysqli_query($connect, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to profile page
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $row['id'];
            header("Location: home.html");
            exit();
        } else {
            $passwordError = "Incorrect password";
            $unsuccessful = true;
        }
    } else {
        // Set the username error only if the form was submitted and the username was not found
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usernameError = "User not found";
            $unsuccessful = true;
}
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            text-align: center;
            background-color: #f1f1f1;
        }

        .image-container img {
            width: 100%;
            height: auto;
        }

        .form-container {
            flex: 1;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container label {
            display: block;
            margin-bottom: 25px;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: calc(100% - 22px); /* Adjusted width to account for padding and border */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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

        .form-container .mt-3 {
            text-align:center;
            margin-top: 20px;
        }

        .form-container .mt-3 a {
            color: #007bff;
        }

        .form-container .mt-3 a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="image-container">
            <!-- Preload images -->
            <img src="image 1.jpg" alt="" style="display: none;">
            <img src="image 2.jpg" alt="" style="display: none;">
            <img src="image 3.jpg" alt="" style="display: none;">
            
            <img id="image" src="image 1.jpg" alt="Original Image">
        </div>

        <div class="form-container">
            <h1>Login</h1>
            <form method="post">
                <label>Username:</label>
                <input type="text" name="username" placeholder="Enter Username" required>
                <div class="error"><?php echo $usernameError; ?></div>
                <label>Password:</label>
                <input type="password" name="password" placeholder="Password" required>
                <div class="error"><?php echo $passwordError; ?></div>
                <div style="text-align: center;">
                    <button type="submit">Login</button>
                </div>
                <div class="mt-3">Don't have an account? <a href="Register.php">Register</a></div>
            </form>
        </div>
    </div>

    <script>
        // Change images periodically
        var images = ['image 1.jpg', 'image 2.jpg', 'image 3.jpg']; // Add your image paths here
        var currentIndex = 0;
        var imageElement = document.getElementById('image');

        setInterval(function() {
            currentIndex = (currentIndex + 1) % images.length;
            imageElement.src = images[currentIndex];
        }, 5000); // Change image every 5 seconds (adjust as needed)
    </script>
</body>

</html>