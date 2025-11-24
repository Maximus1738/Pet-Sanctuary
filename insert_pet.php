[file name]: insert_pet.php
[file content begin]
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_sanctuary";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$Pet_ID = $_POST['Pet_ID'] ?? '';
$Pet_type = $_POST['Pet_type'] ?? '';
$Pet_Name = $_POST['Pet_Name'] ?? '';
$Age_Years = $_POST['Age_Years'] ?? '';
$Vaccinations = $_POST['Vaccinations'] ?? '';
$Environment_condition = $_POST['Environment_condition'] ?? '';
$Adoption_requirements = $_POST['Adoption_requirements'] ?? '';
$Booking_requirements = $_POST['Booking_requirements'] ?? '';
$Sex = $_POST['Sex'] ?? '';
$Food_requirements = $_POST['food_requirements'] ?? '';
$Allergies = $_POST['allergies'] ?? '';


// Validate required fields
if (empty($Pet_ID) || empty($Pet_type) || empty($Pet_Name) || empty($Age_Years) || empty($Vaccinations) || empty($Environment_condition) || empty($Sex)) {
    header("Location: add_pet.php?error=1");
    exit();
}

// Insert into pets table
$sql = "INSERT INTO pets (Pet_ID, Pet_type, Pet_Name, Age_Years, Vaccinations, Environment_condition, Adoption_requirements, Booking_requirements, Sex)
        VALUES ('$Pet_ID', '$Pet_type', '$Pet_Name', '$Age_Years', '$Vaccinations', '$Environment_condition', '$Adoption_requirements', '$Booking_requirements', '$Sex')";

if ($conn->query($sql) === TRUE) {
    // Also insert into adoption table with "Processing" status
    $adoption_sql = "INSERT INTO adoption (Pet_ID, Food_requirements, Allergies, Adoption_status)
                 VALUES ('$Pet_ID', '$Food_requirements', '$Allergies', 'Processing')";
    $conn->query($adoption_sql);
    
    $conn->close();
    header("Location: add_pet.php?success=1");
    exit();
} else {
    error_log("SQL Error: " . $conn->error);
    $conn->close();
    header("Location: add_pet.php?error=1");
    exit();
}
?>
[file content end]