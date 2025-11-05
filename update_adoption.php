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
$petId = $_POST['petId'] ?? '';
$petName = $_POST['petName'] ?? '';

if (!empty($petId)) {
    // First, verify the pet exists in the pets table
    $checkPetSql = "SELECT * FROM pets WHERE Pet_ID = ?";
    $checkPetStmt = $conn->prepare($checkPetSql);
    $checkPetStmt->bind_param("s", $petId);
    $checkPetStmt->execute();
    $petResult = $checkPetStmt->get_result();
    
    if ($petResult->num_rows === 0) {
        echo "error: Pet not found in database";
        $checkPetStmt->close();
        $conn->close();
        exit();
    }
    $checkPetStmt->close();
    
    // Check if this pet already has an adoption record
    $checkAdoptionSql = "SELECT * FROM adoption WHERE Pet_ID = ?";
    $checkAdoptionStmt = $conn->prepare($checkAdoptionSql);
    $checkAdoptionStmt->bind_param("s", $petId);
    $checkAdoptionStmt->execute();
    $adoptionResult = $checkAdoptionStmt->get_result();
    
    if ($adoptionResult->num_rows > 0) {
        // Update existing record for this specific pet
        $updateSql = "UPDATE adoption SET Adoption_status = 'Pending' WHERE Pet_ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("s", $petId);
        
        if ($updateStmt->execute()) {
            // Get the Customer_Id that was assigned
            $getCustomerId = "SELECT Customer_Id FROM adoption WHERE Pet_ID = ?";
            $getCustomerStmt = $conn->prepare($getCustomerId);
            $getCustomerStmt->bind_param("s", $petId);
            $getCustomerStmt->execute();
            $customerResult = $getCustomerStmt->get_result();
            $customerData = $customerResult->fetch_assoc();
            $customerId = $customerData['Customer_Id'];
            
            echo "success|" . $customerId;
            $getCustomerStmt->close();
        } else {
            echo "error: " . $updateStmt->error;
        }
        $updateStmt->close();
    } else {
        // Insert new record for this specific pet (Customer_Id will auto-increment)
        $insertSql = "INSERT INTO adoption (Pet_ID, Food_requirements, Allergies, Adoption_status) 
                     VALUES (?, 'Standard diet', 'None', 'Pending')";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("s", $petId);
        
        if ($insertStmt->execute()) {
            // Get the auto-generated Customer_Id
            $customerId = $insertStmt->insert_id;
            echo "success|" . $customerId;
        } else {
            echo "error: " . $insertStmt->error;
        }
        $insertStmt->close();
    }
    
    $checkAdoptionStmt->close();
} else {
    echo "error: No pet ID provided";
}

$conn->close();
?>