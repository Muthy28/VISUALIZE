<?php
session_start();
include 'connect.php'; // Include database connection file

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION['username'];

// Fetch user data from the database
$sql = "SELECT * FROM form WHERE username='$username'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// Check if the user has uploaded a photo
$photo = $row['profile_picture'] ?? ''; // Check if photo exists, if not set to empty string
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 1vh;
        }

        .container {
            position: absolute;
            top: 20px;
            max-width: 400px;
            background-color: #fff;
            padding: 200px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            color:maroon;
            margin-bottom: 10px;
            text-align: center;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2px;
            background: white;
            box-shadow: var(--box-shadow);
        }
        .header .navbar a {
            font-size: 16px;
            color: var(--black);
            margin-left: 4rem;
            text-decoration: none;
            color: black;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 10px;
            margin-right: 30px;
            white-space: nowrap;
        }
        .header .navbar a:hover {
            color: red;
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
        <a href="Home.html">Home</a>
        <a href="Profile.php">Profile</a>
        <a href="updateprofile.php">Update Profile</a>
        <a href="upload.php">Upload Profile Picture</a>
        <a href="delete.php">Delete Account</a>
        <a href="logout.php">Logout</a>
        </nav>
    </header>

    <?php if (!empty($photo)) : ?>
        <img src="<?php echo $photo; ?>" alt="Profile Photo" class="profile-picture">
    <?php else : ?>
        <div class="profile-picture"></div> <!-- Empty placeholder if no photo -->
    <?php endif; ?>
    <h2>Welcome, <?php echo $row['username']; ?></h2>
    <p>Email: <?php echo $row['email']; ?></p>

       </div>
</body>
</html>
