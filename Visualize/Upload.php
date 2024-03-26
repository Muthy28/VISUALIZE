<?php
session_start();
include 'connect.php'; // Include database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file was uploaded without errors
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        // Retrieve file details
        $file_name = $_FILES['profile_picture']['name'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_type = $_FILES['profile_picture']['type'];
        $file_size = $_FILES['profile_picture']['size'];

        // Specify upload directory
        $upload_dir = 'uploads/';
        // Generate unique filename to avoid overwriting existing files
        $file_path = $upload_dir . uniqid() . '_' . $file_name;

        // Move uploaded file to the desired directory
        if (move_uploaded_file($file_tmp, $file_path)) {
            // File upload successful, store file path in database
            $username = $_SESSION['username'];
            $update_sql = "UPDATE form SET profile_picture='$file_path' WHERE username='$username'";
            $update_result = mysqli_query($connect, $update_sql);

            if ($update_result) {
                // Redirect back to profile page after updating
                header("Location: profile.php");
                exit();
            } else {
                $update_error = "Failed to update profile picture. Please try again.";
            }
        } else {
            $update_error = "Error uploading file. Please try again.";
        }
    } else {
        $update_error = "No file uploaded or an error occurred during upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Profile Picture</title>
    <style>
        /* Add your CSS styles here */
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
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        h2 {
            color:navy;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
        }

        button[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 5px;
            text-align: center;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
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
        <h1 style="color:navy; font-size:18px">VISUALIZE.......</h1>
         <nav class="navbar">
         <a href="Home.html">Home</a>
         <a href="Profile.php">Profile</a>
            <a href="updateprofile.php">Update Profile</a>
            <a href="upload.php">Upload Profile Picture</a>
            <a href="delete.php">Delete Account</a>
            <a href="logout.php">Logout</a>
        </nav>
        </header>
<div class="container">
        <h2>Upload Profile Picture</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="profile_picture" required>
            <button type="submit">Upload</button>
            <?php if (isset($update_error)) echo "<div class='error'>$update_error</div>"; ?>
        </form>
    </div>
</body>
</html>
