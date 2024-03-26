<?php
session_start();
include 'connect.php'; // Include database connection file

$delete_error = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the username from the session
    $username = $_SESSION['username'];

    // Delete the user's account from the database
    $delete_sql = "DELETE FROM form WHERE username='$username'";
    $delete_result = mysqli_query($connect, $delete_sql);

    if ($delete_result) {
        // Account deletion successful, redirect to registration page with success message
        $success_message = "Your account has been successfully deleted.";
        header("Location: register.php?success_message=" . urlencode($success_message));
        header("Location: appointment.php?success_message=" . urlencode($success_message));
        exit();
    } else {
        // Handle deletion error
        $delete_error = "Failed to delete account. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 20px;
        }

        form {
            text-align: center;
        }

        button[type="submit"] {
            background-color: #f44336;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #d32f2f;
        }

        .success-message {
            text-align: center;
            color: green;
        }

        .error-message {
            text-align: center;
            color: red;
        }
        .header
        {
    position:fixed;
    top:0; left:0; right:0;
    z-index:1000;
    display: flex;
    justify-content:space-between;
    align-items:center;
    padding:2px ;
    background:white;
    box-shadow:var(--box-shadow);
                 }
.header .navbar a
{
    font-size:16px;
    color:var(--black);
    margin-left: 4rem;
    text-decoration: none;
            color: black;
            font-weight: bold;
            transition: all 0.3s ease;
            margin:10px;
            margin-right:30px;
            white-space:nowrap;
}
.header .navbar a:hover
{
    color:red;
    text-decoration: underline;
}

    </style>
</head>
<body>
    <header class="header">
        <h1 style="color:green; font-size:18px">ALL THINGS MUSIC.......</h1>
         <nav class="navbar">
         <a href="Home.html">HOME</a>
        <a href="Designs.html">DESIGNS</a>
        <a href="Login.php">LOGIN/REGISTER</a>
        <a href="Profile.php">PROFILE</a>
        </nav>
        </header>
    <div class="container">
        <h2>Delete Account</h2>
        <p>Are you sure you want to delete your account?</p>
        <p>When you delete you will be forced to register!!!</p>    
        <?php if (!empty($delete_error)) echo "<p class='error-message'>$delete_error</p>"; ?>
        <?php if (!empty($success_message)) echo "<p class='success-message'>$success_message</p>"; ?>
        <form method="post">
            <button type="submit">Delete</button>
        </form>
    </div>
</body>
</html>
