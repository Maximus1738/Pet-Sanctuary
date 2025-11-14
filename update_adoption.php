[file name]: update_adoption.php
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

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "error: Please login to adopt a pet";
    $conn->close();
    exit();
}

// Get the POST data
$petId = $_POST['petId'] ?? '';
$petName = $_POST['petName'] ?? '';

// Get user ID from session
$userId = $_SESSION['user_id'];

if (!empty($petId)) {
    // Check if this pet exists and is available
    $checkAdoptionSql = "SELECT * FROM adoption WHERE Pet_ID = ? AND Adoption_status = 'Available'";
    $checkAdoptionStmt = $conn->prepare($checkAdoptionSql);
    $checkAdoptionStmt->bind_param("s", $petId);
    $checkAdoptionStmt->execute();
    $adoptionResult = $checkAdoptionStmt->get_result();
    
    if ($adoptionResult->num_rows > 0) {
        // Update the existing record (Pet_ID is primary key, so only one record per pet)
        $updateSql = "UPDATE adoption SET Adoption_status = 'Pending', Customer_Id = ? WHERE Pet_ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        
        if ($updateStmt) {
            $updateStmt->bind_param("is", $userId, $petId);
            
            if ($updateStmt->execute()) {
                echo "success|" . $userId;
            } else {
                echo "error: Failed to update adoption record: " . $updateStmt->error;
            }
            $updateStmt->close();
        } else {
            echo "error: Failed to prepare update statement";
        }
    } else {
        echo "error: Pet not available for adoption or not found";
    }
    
    $checkAdoptionStmt->close();
} else {
    echo "error: No pet ID provided";
}

$conn->close();
?>
[file content end]