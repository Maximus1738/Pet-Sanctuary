[file name]: authenticate.php
[file content begin]
<?php
session_start();

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
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($email) && !empty($password)) {
    // Prepare and execute query - using your actual database column names
    $sql = "SELECT Customer_id, First_name, Last_Name, Password FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password (plain text comparison based on your table data)
        if ($password === $user['Password']) {
            // Set session variables
            $_SESSION['user_id'] = $user['Customer_id'];
            $_SESSION['first_name'] = $user['First_name'];
            $_SESSION['last_name'] = $user['Last_Name'];
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;
            
            // Redirect to homepage
            header("Location: homepage.php");
            exit();
        } else {
            // Invalid password
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // User not found
        header("Location: login.php?error=1");
        exit();
    }
    
    $stmt->close();
} else {
    // Missing fields
    header("Location: login.php?error=1");
    exit();
}

$conn->close();
?>
[file content end]