<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_sanctuary";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the POST data
$full_name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';

if (!empty($full_name) && !empty($email) && !empty($password)) {
    // Split full name into first and last name
    $name_parts = explode(' ', $full_name, 2);
    $first_name = $name_parts[0];
    $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
    
    // Check if email already exists
    $check_sql = "SELECT * FROM users WHERE Email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        // Email already exists
        header("Location: register.php?error=1");
        exit();
    }
    $check_stmt->close();
    
    // Insert new user using your existing table structure
    $insert_sql = "INSERT INTO users (First_name, Last_Name, Email, Phone, Address, Password, Join_Date) VALUES (?, ?, ?, ?, ?, ?, CURDATE())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $address, $password);
    
    if ($insert_stmt->execute()) {
        // Registration successful
        header("Location: login.php?success=1");
        exit();
    } else {
        // Registration failed
        header("Location: register.php?error=2");
        exit();
    }
    
    $insert_stmt->close();
} else {
    // Missing required fields
    header("Location: register.php?error=2");
    exit();
}

$conn->close();
?>