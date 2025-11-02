<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_sanctuary";  // <-- change this

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Pet_ID = $_POST['Pet_ID'];
$Pet_type = $_POST['Pet_type'];
$Pet_Name = $_POST['Pet_Name'];
$Age_Years = $_POST['Age_Years'];
$Vaccinations = $_POST['Vaccinations'];
$Environment_condition = $_POST['Environment_condition'];
$Adoption_requirements = $_POST['Adoption_requirements'];
$Booking_requirements = $_POST['Booking_requirements'];
$Sex = $_POST['Sex'];

$sql = "INSERT INTO Pets (Pet_ID, Pet_type, Pet_Name, Age_Years, Vaccinations, Environment_condition, Adoption_requirements, Booking_requirements, Sex)
VALUES ('$Pet_ID', '$Pet_type', '$Pet_Name', '$Age_Years', '$Vaccinations', '$Environment_condition', '$Adoption_requirements', '$Booking_requirements', '$Sex')";

if ($conn->query($sql) === TRUE) {
    echo "New pet added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
