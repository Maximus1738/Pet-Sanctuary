<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_sanctuary";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$petType = $_GET['type'] ?? '';

if (!$petType) {
    echo "INVALID";
    exit;
}

// Convert pet type into a prefix
$prefix = strtoupper(substr($petType, 0, 2));  // Example: Dog -> DO, Rabbit -> RA

// Get the highest existing ID starting with this prefix
$sql = "SELECT Pet_ID FROM pets WHERE Pet_ID LIKE '$prefix-%' ORDER BY CAST(SUBSTRING_INDEX(Pet_ID, '-', -1) AS UNSIGNED) DESC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Extract the number and add 1
    $lastNumber = intval(substr($row['Pet_ID'], strlen($prefix) + 1));
    $newNumber = $lastNumber + 1;
} else {
    // If none exist, start at 1
    $newNumber = 1;
}

// Final ID (e.g., DO-1)
$newPetID = $prefix . "-" . $newNumber;

// Double-check that ID still doesn't exist (safety)
$check = $conn->query("SELECT Pet_ID FROM pets WHERE Pet_ID = '$newPetID'");
if ($check->num_rows > 0) {
    // If collision happens, keep adding 1 until unused
    while (true) {
        $newNumber++;
        $newPetID = $prefix . "-" . $newNumber;
        $check = $conn->query("SELECT Pet_ID FROM pets WHERE Pet_ID = '$newPetID'");
        if ($check->num_rows == 0) break;
    }
}

echo $newPetID;

$conn->close();
?>
