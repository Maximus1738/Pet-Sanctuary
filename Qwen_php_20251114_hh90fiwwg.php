<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_sanctuary";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("DB Connection failed: " . $conn->connect_error);
    header("Location: add_pet.php?error=1");
    exit();
}

// Get form data (Pet_ID is NOT trusted from client)
$Pet_type = $_POST['Pet_type'] ?? '';
$Pet_Name = $_POST['Pet_Name'] ?? '';
$Age_Years = $_POST['Age_Years'] ?? '';
$Vaccinations = $_POST['Vaccinations'] ?? '';
$Environment_condition = $_POST['Environment_condition'] ?? '';
$Adoption_requirements = $_POST['Adoption_requirements'] ?? '';
$Booking_requirements = $_POST['Booking_requirements'] ?? '';
$Sex = $_POST['Sex'] ?? '';

// Validate
if (empty($Pet_type) || empty($Pet_Name) || empty($Age_Years) || empty($Vaccinations) || empty($Environment_condition) || empty($Sex)) {
    header("Location: add_pet.php?error=1");
    exit();
}

// =============== GENERATE Pet_ID SERVER-SIDE ===============
function getPetPrefix($petType) {
    $type = strtolower($petType);
    if (strpos($type, 'dog') !== false) return 'DG';
    if (strpos($type, 'cat') !== false) return 'CT';
    if (strpos($type, 'rabbit') !== false) return 'RB';
    if (strpos($type, 'bird') !== false) return 'BD';
    if (strpos($type, 'fish') !== false) return 'FS';
    if (strpos($type, 'turtle') !== false || strpos($type, 'tortoise') !== false || 
        strpos($type, 'snake') !== false || strpos($type, 'lizard') !== false || 
        strpos($type, 'iguana') !== false) return 'RP';
    if (strpos($type, 'hamster') !== false) return 'HM';
    if (strpos($type, 'guinea pig') !== false) return 'GP';
    return 'PT';
}

$prefix = getPetPrefix($Pet_type);
$validPrefixes = ['DG','CT','RB','BD','FS','RP','HM','GP','PT'];
if (!in_array($prefix, $validPrefixes)) $prefix = 'PT';

$stmt = $conn->prepare("SELECT Pet_ID FROM pets WHERE Pet_ID LIKE ? ORDER BY Pet_ID DESC LIMIT 1");
$likePattern = $prefix . '-%';
$stmt->bind_param("s", $likePattern);
$stmt->execute();
$result = $stmt->get_result();

$newID = $prefix . '-1';
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (preg_match('/^' . preg_quote($prefix, '/') . '-(\d+)$/', $row['Pet_ID'], $matches)) {
        $newID = $prefix . '-' . (intval($matches[1]) + 1);
    }
}
$stmt->close();

// =============== INSERT WITH TRANSACTION ===============
$conn->autocommit(FALSE);

// Insert into pets
$stmt = $conn->prepare("INSERT INTO pets (Pet_ID, Pet_type, Pet_Name, Age_Years, Vaccinations, Environment_condition, Adoption_requirements, Booking_requirements, Sex)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", 
    $newID, $Pet_type, $Pet_Name, $Age_Years, $Vaccinations, 
    $Environment_condition, $Adoption_requirements, $Booking_requirements, $Sex
);

if (!$stmt->execute()) {
    $conn->rollback();
    error_log("Insert into pets failed: " . $stmt->error);
    $conn->autocommit(TRUE);
    $conn->close();
    header("Location: add_pet.php?error=1");
    exit();
}
$stmt->close();

// 🔑 KEY FIX: Set status to 'Available' (not 'Processing')
$stmt = $conn->prepare("INSERT INTO adoption (Pet_ID, Adoption_status) VALUES (?, 'Available')");
$stmt->bind_param("s", $newID);

if (!$stmt->execute()) {
    $conn->rollback();
    error_log("Insert into adoption failed: " . $stmt->error);
    $conn->autocommit(TRUE);
    $conn->close();
    header("Location: add_pet.php?error=1");
    exit();
}
$stmt->close();

$conn->commit();
$conn->autocommit(TRUE);
$conn->close();

header("Location: add_pet.php?success=1");
exit();
?>