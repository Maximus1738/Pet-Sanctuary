<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_sanctuary";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("DB Connection failed: " . $conn->connect_error);
    echo "error: System error. Please try again.";
    exit();
}

// Verify login and user ID
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_id'])) {
    echo "error: Please login to adopt a pet";
    $conn->close();
    exit();
}

$userId = (int)$_SESSION['user_id']; // Cast to int for safety
$petId = $_POST['petId'] ?? '';

if (empty($petId)) {
    echo "error: No pet ID provided";
    $conn->close();
    exit();
}

// 🔍 CHECK: Is the pet AVAILABLE? (case-sensitive match)
$checkStmt = $conn->prepare("SELECT Adoption_status FROM adoption WHERE Pet_ID = ?");
$checkStmt->bind_param("s", $petId);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows === 0) {
    echo "error: Pet not found in adoption system";
    $checkStmt->close();
    $conn->close();
    exit();
}

$row = $result->fetch_assoc();
$currentStatus = $row['Adoption_status'];

// Only allow adoption if status is EXACTLY 'Available'
if ($currentStatus !== 'Available') {
    error_log("Adoption blocked: Pet_ID=$petId has status='$currentStatus' (expected 'Available')");
    echo "error: Pet is not available for adoption (status: " . htmlspecialchars($currentStatus) . ")";
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

// ✅ UPDATE to 'Pending'
$updateStmt = $conn->prepare("UPDATE adoption SET Adoption_status = 'Pending', Customer_Id = ? WHERE Pet_ID = ?");
$updateStmt->bind_param("is", $userId, $petId);

if ($updateStmt->execute()) {
    echo "success|" . $userId;
} else {
    error_log("Failed to update adoption for Pet_ID=$petId: " . $updateStmt->error);
    echo "error: Failed to process adoption";
}

$updateStmt->close();
$conn->close();
?>