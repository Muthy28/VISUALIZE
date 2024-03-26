<?php
session_start();
include 'connect.php'; // Include database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $requirement = $_POST['requirement'];
    
    // You can perform further validation here
    
    // Now you can process the data, for example, store it in a database or send it via email
    
    // Example of storing data in a database
    $query = "INSERT INTO appointment (username, mobile, email, country, requirement) VALUES ('$username', '$mobile', '$email', '$country', '$requirement')";
    $result = mysqli_query($connect, $query);
    
    if ($result) {
        // Data inserted successfully
        header("Location: designs.html");
        exit;
    } else {
        // Error occurred while inserting data
        echo "Error: " . mysqli_error($connect);
    }
} else {
    // If the form is not submitted, redirect back to the appointment page
    header("Location: appointment.php");
    exit;
}
?>
