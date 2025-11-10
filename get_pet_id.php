<?php
// get_pet_id.php
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

$petType = $_GET['type'] ?? '';

function getPetPrefix($petType) {
    $petType = strtolower($petType);
    
    // Map pet types to prefixes based on your database
    if (strpos($petType, 'dog') !== false) return 'DG';
    if (strpos($petType, 'cat') !== false) return 'CT';
    if (strpos($petType, 'rabbit') !== false) return 'RB';
    if (strpos($petType, 'bird') !== false) return 'BD';
    if (strpos($petType, 'fish') !== false) return 'FS';
    if (strpos($petType, 'turtle') !== false) return 'RP';
    if (strpos($petType, 'tortoise') !== false) return 'RP';
    if (strpos($petType, 'snake') !== false) return 'RP';
    if (strpos($petType, 'lizard') !== false) return 'RP';
    if (strpos($petType, 'iguana') !== false) return 'RP';
    if (strpos($petType, 'hamster') !== false) return 'HM';
    if (strpos($petType, 'guinea pig') !== false) return 'GP';
    
    // Default for other pets
    return 'PT';
}

if (!empty($petType)) {
    $prefix = getPetPrefix($petType);
    
    // Get the highest existing Pet_ID for this prefix
    $sql = "SELECT Pet_ID FROM pets WHERE Pet_ID LIKE '$prefix-%' ORDER BY Pet_ID DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastID = $row['Pet_ID'];
        
        // Extract the numeric part and increment
        if (preg_match('/'.$prefix.'-(\d+)/', $lastID, $matches)) {
            $number = intval($matches[1]) + 1;
            $newID = $prefix . '-' . $number;
        } else {
            $newID = $prefix . '-1';
        }
    } else {
        $newID = $prefix . '-1';
    }
    
    echo $newID;
} else {
    echo 'PT-1';
}

$conn->close();
?>