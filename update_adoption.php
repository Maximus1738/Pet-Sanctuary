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
$userId = $_SESSION['Customer_Id'] ?? $_SESSION['customer_id'] ?? '';
if (!empty($petId) && !empty($userId)) {
    try {
        // First, verify the user exists in the database
        $checkUserSql = "SELECT Customer_Id FROM users WHERE Customer_Id = ?";
        $checkUserStmt = $conn->prepare($checkUserSql);
        $checkUserStmt->bind_param("s", $userId);
        $checkUserStmt->execute();
        $userResult = $checkUserStmt->get_result();
        
        if ($userResult->num_rows === 0) {
            echo "error: User account not found. Please log in again.";
            $checkUserStmt->close();
            exit();
        }
        $checkUserStmt->close();
        
        // Check if pet exists and get its current adoption status
        $checkPetSql = "SELECT p.Pet_ID, a.Adoption_status, a.Customer_Id 
                        FROM pets p 
                        LEFT JOIN adoption a ON p.Pet_ID = a.Pet_ID 
                        WHERE p.Pet_ID = ?";
        $checkPetStmt = $conn->prepare($checkPetSql);
        $checkPetStmt->bind_param("s", $petId);
        $checkPetStmt->execute();
        $petResult = $checkPetStmt->get_result();
        
        if ($petResult->num_rows === 0) {
            echo "error: Pet not found in database";
            $checkPetStmt->close();
            exit();
        }
        
        $petData = $petResult->fetch_assoc();
        $currentStatus = $petData['Adoption_status'] ?? null;
        $currentCustomer = $petData['Customer_Id'] ?? null;
        
        // Check if pet is available for adoption
        if ($currentStatus === 'Available' || $currentStatus === null) {
            // If no adoption record exists, create one
            if ($currentStatus === null) {
                $insertSql = "INSERT INTO adoption (Pet_ID, Customer_Id, Adoption_status) VALUES (?, ?, 'Pending')";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param("ss", $petId, $userId);
                
                if ($insertStmt->execute()) {
                    echo "success|" . $userId;
                } else {
                    echo "error: Failed to create adoption record: " . $insertStmt->error;
                }
                $insertStmt->close();
            } else {
                // Update existing adoption record
                $updateSql = "UPDATE adoption SET Adoption_status = 'Pending', Customer_Id = ? WHERE Pet_ID = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ss", $userId, $petId);
                
                if ($updateStmt->execute()) {
                    echo "success|" . $userId;
                } else {
                    echo "error: Failed to update adoption record: " . $updateStmt->error;
                }
                $updateStmt->close();
            }
        } else if ($currentStatus === 'Pending') {
            if ($currentCustomer === $userId) {
                echo "error: You already have a pending adoption request for this pet";
            } else {
                echo "error: This pet already has a pending adoption request from another user";
            }
        } else if ($currentStatus === 'Adopted') {
            echo "error: This pet has already been adopted";
        } else {
            echo "error: Pet not available for adoption. Current status: " . $currentStatus;
        }
        
        $checkPetStmt->close();
        
    } catch (Exception $e) {
        echo "error: Database error: " . $e->getMessage();
    }
} else {
    if (empty($petId)) {
        echo "error: No pet ID provided";
    } else {
        echo "error: User not properly logged in. Please log in again.";
    }
}

$conn->close();
?>