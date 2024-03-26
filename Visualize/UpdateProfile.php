<?php
session_start();
include 'connect.php'; // Include database connection file

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user data from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM form WHERE username='$username'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// Handle form submissions for updating profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    

    //creates the hash for user password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if the new username is different from the current one
    $newUsername = $_POST['username']; //Define and Declare new username
    if ($newUsername !== $username) {
        // Check if the new username is available
        $check_username_sql = "SELECT * FROM form WHERE username='$newUsername'";
        $check_username_result = mysqli_query($connect, $check_username_sql);
        if (mysqli_num_rows($check_username_result) > 0) {
            $update_error = "Username already exists. Please choose a different username.";
        } else {
            // Update the username in the database
            $update_username_sql = "UPDATE form SET username='$newUsername' WHERE username='$username'";
            mysqli_query($connect, $update_username_sql);
            $_SESSION['username'] = $newUsername; // Update username in session
            $username = $newUsername; // Update username variable
        }
    }

    // Update the user's profile information in the database
    $update_sql = "UPDATE form SET email='$email', mobile='$mobile', password='$password_hash', confirm='$confirm', WHERE username='$username'";
    $update_result = mysqli_query($connect, $update_sql);

    if ($update_result) {
         // Set success message if update is successful
         $update_success = "Profile updated successfully.";
    } else {
        // Handle update error
        $update_error = "Failed to update profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>


<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-container {
            flex: 1;
            padding: 20px;
        }

        .image-container {
            flex: 1;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color:navy;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            color:maroon;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        input[type="date"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: red;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: navy;
        }

        .error {
            text-align: center;
            color: red;
            margin-top: 5px;
            font-size: 14px;
        }

        .success {
            text-align: center;
            color: red;
            margin-top: 5px;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
.navbar-dropdown {
            position: relative;
            display: inline-block;
        }

        .navbar-dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            z-index: 1;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        .navbar-dropdown:hover .navbar-dropdown-content {
            display: block;
        }

        .navbar-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .navbar-dropdown-content a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<div class="container">
    <header class="header">
        <h1 style="color: green; font-size: 18px">VISUALIZE.......</h1>
        <nav class="navbar">
        <a href="Home.html">HOME</a>
        <a href="Designs.html">DESIGNS</a>
        <a href="Login.php">LOGIN/REGISTER</a>
        <a href="Profile.php">PROFILE</a>

        </nav>
    </header>
        <br> <br> <br> <br> <br> <br> <br>
        <div class="form-container">
            <h2>Update Profile</h2>
            <?php if (!empty($update_error)) : ?>
                <div class="error"><?php echo $update_error; ?></div>
            <?php endif; ?>
            <?php if (!empty($update_success)) : ?>
                <div class="success"><?php echo $update_success; ?></div>
            <?php endif; ?>
            <form method="post">
                <label>Username:</label>
                <input type="text" id="username" name="username" required>
                <label>Email:</label>
                <input type="email" id="email" name="email" required>
                <label>Mobile Number:</label>
                <input type="number" id="mobile" name="mobile"required>
                <label>Password:</label>
                <input type="password" id="password" name="password" placeholder="New Password">
                <label>Confirm Password:</label>
                <input type="password" id="confirm" name="confirm" placeholder="Confirm Password">


                <button type="submit">Update</button>
                <?php if (isset($update_error)) echo "<div class='error'>$update_error</div>"; ?>
            </form>
        </div>
        
    </script>
</body>
</html>
