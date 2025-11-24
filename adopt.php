<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt a Pet - Forest Pet Sanctuary</title>
    <style>
        :root {
            --forest-green: #2d5a27;
            --light-green: #4a7c59;
            --tan: #d2b48c;
            --light-tan: #f5f1e8;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-tan);
            color: #333;
            line-height: 1.6;
        }
        
        header {
            background-color: var(--forest-green);
            color: var(--white);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 1.5rem;
        }
        
        nav ul li a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        nav ul li a:hover {
            color: var(--tan);
        }
        
        .hero {
            background: linear-gradient(rgba(45, 90, 39, 0.7), rgba(45, 90, 39, 0.7)), 
                        url('https://images.unsplash.com/photo-1546197231-1ce8c5bf0c39?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: var(--white);
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--tan);
            color: var(--forest-green);
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #e0c9a6;
        }
        
        .btn-adopt {
            background-color: var(--forest-green);
            color: var(--white);
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        .btn-adopt:hover {
            background-color: var(--light-green);
        }

        .btn-pending {
            background-color: #666;
            color: var(--white);
            width: 100%;
            margin-top: 1rem;
            cursor: not-allowed;
            transition: all 0.3s ease;
        }

        .btn-adopted {
            background-color: #8B4513;
            color: var(--white);
            width: 100%;
            margin-top: 1rem;
            cursor: not-allowed;
        }
        
        .section {
            padding: 4rem 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--forest-green);
        }
        
        .pets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .pet-card {
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .pet-card:hover {
            transform: translateY(-5px);
        }
        
        .pet-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .pet-info {
            padding: 1.5rem;
        }
        
        .pet-name {
            font-size: 1.4rem;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
        }
        
        .pet-details {
            margin-bottom: 1rem;
        }
        
        .pet-detail {
            display: flex;
            margin-bottom: 0.5rem;
        }
        
        .detail-label {
            font-weight: bold;
            min-width: 120px;
        }
        
        .pet-description {
            margin-top: 1rem;
            font-style: italic;
            color: #666;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .status-available {
            background-color: #e8f5e8;
            color: var(--forest-green);
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-adopted {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .no-pets {
            text-align: center;
            padding: 3rem;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        footer {
            background-color: var(--forest-green);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
        }
        
        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 2rem;
        }
        
        .footer-section {
            flex: 1;
            min-width: 250px;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            color: var(--tan);
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .social-links a {
            color: var(--white);
            font-size: 1.5rem;
            transition: color 0.3s;
        }
        
        .social-links a:hover {
            color: var(--tan);
        }
        
        .copyright {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            nav ul {
                margin-top: 1rem;
                justify-content: center;
            }
            
            nav ul li {
                margin: 0 0.75rem;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .pets-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
<header>
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-paw"></i> Forest Pet Sanctuary
            </div>
            <nav>
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    
                    <li><a href="booking.php">Booking</a></li>

                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li><a href="add_pet.php">Give Pet</a></li>
                        <li><a href="logout.php">Logout (<?php echo $_SESSION['first_name']; ?>)</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>

                    
                </ul>
            </nav>
        </div>
    </div>
</header>

<section class="hero">
    <div class="container">
        <h1>Find Your New Best Friend</h1>
        <p>Browse our wonderful pets waiting for their forever homes. Each one has a unique story and is ready to bring joy to your life.</p>
    </div>
</section>

<section id="pets" class="section">
    <div class="container">
        <h2 class="section-title">Pets Available for Adoption</h2>

<?php
// Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "pet_sanctuary";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "<div style='color: red; text-align: center;'>Connection failed: " . $conn->connect_error . "</div>";
} else {

    // Determine query based on login state
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

        $user_id = $_SESSION['Customer_Id'];


        $sql = <<<SQL
    SELECT 
     p.Pet_ID, p.Pet_type, p.Pet_Name, p.Age_Years, p.Vaccinations,
     p.Environment_condition, p.Adoption_requirements, p.Booking_requirements,
     p.Sex, a.Adoption_status, a.Customer_Id
    FROM pets p
    JOIN adoption a ON p.Pet_ID = a.Pet_ID
    WHERE 
      a.Adoption_status = 'Available'
    OR (a.Adoption_status = 'Pending' AND a.Customer_Id = ?)
SQL;

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("SQL Prepare Failed: " . $conn->error);
        }

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

    } else {

        $sql = <<<SQL
SELECT 
    p.Pet_ID, p.Pet_type, p.Pet_Name, p.Age_Years, p.Vaccinations,
    p.Environment_condition, p.Adoption_requirements, p.Booking_requirements,
    p.Sex, a.Adoption_status
FROM pets p
JOIN adoption a ON p.Pet_ID = a.Pet_ID
WHERE a.Adoption_status = 'Available'
SQL;

        $result = $conn->query($sql);
    }

    // DO NOT overwrite $result again — FIXED
}

if ($result && $result->num_rows > 0) {
    echo '<div class="pets-grid">';

    while ($row = $result->fetch_assoc()) {

        $petType = strtolower($row["Pet_type"]);
        $imageUrl = "https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=500&q=60";

        if (strpos($petType, 'dog') !== false || strpos($petType, 'husky') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'cat') !== false || strpos($petType, 'tabby') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'rabbit') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'bird') !== false || strpos($petType, 'parrot') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'turtle') !== false || strpos($petType, 'tortoise') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1452857576997-f0f12cd77848?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'fish') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=500&q=60";
        }

        $adoptionStatus = $row["Adoption_status"] ?? "Available";
        if (empty($adoptionStatus)) $adoptionStatus = "Available";

        $statusClass = "status-available";
        $buttonClass = "btn-adopt";
        $disabled = false;
        $buttonText = "Adopt " . $row["Pet_Name"];

        if ($adoptionStatus === "Pending") {
            $statusClass = "status-pending";
            $buttonClass = "btn-pending";
            $buttonText = "Adoption Pending";
            $disabled = true;
        } elseif ($adoptionStatus === "Adopted") {
            $statusClass = "status-adopted";
            $buttonClass = "btn-adopted";
            $buttonText = "Already Adopted";
            $disabled = true;
        }

        echo '<div class="pet-card">';
        echo '<img src="' . $imageUrl . '" alt="' . $row["Pet_Name"] . '" class="pet-image">';
        echo '<div class="pet-info">';
        echo '<span class="status-badge ' . $statusClass . '">' . $adoptionStatus . '</span>';
        echo '<h3 class="pet-name">' . $row["Pet_Name"] . '</h3>';

        echo '<div class="pet-details">';
        echo '<div class="pet-detail"><span class="detail-label">Type:</span> ' . $row["Pet_type"] . '</div>';
        echo '<div class="pet-detail"><span class="detail-label">Age:</span> ' . $row["Age_Years"] . '</div>';
        echo '<div class="pet-detail"><span class="detail-label">Sex:</span> ' . $row["Sex"] . '</div>';
        echo '<div class="pet-detail"><span class="detail-label">Vaccinations:</span> ' . ($row["Vaccinations"] ?: "Pending") . '</div>';

        echo '</div>';

        $description = "";
        if ($row["Environment_condition"]) $description .= "Environment: {$row["Environment_condition"]}. ";
        if ($row["Adoption_requirements"]) $description .= "Requirements: {$row["Adoption_requirements"]}. ";
        if ($row["Booking_requirements"]) $description .= "Booking: {$row["Booking_requirements"]}. ";

        if ($description !== "") {
            echo '<p class="pet-description">' . $description . '</p>';
        }

        if ($disabled) {
            echo '<button class="btn ' . $buttonClass . '" disabled>' . $buttonText . '</button>';
        } else {
            echo '<button class="btn ' . $buttonClass . '" onclick="adoptPet(\'' . $row["Pet_ID"] . '\', \'' . $row["Pet_Name"] . '\', this)">' . $buttonText . '</button>';
        }

        echo '</div></div>';
    }

    echo '</div>';
} else {
    echo '<div class="no-pets"><h3>No pets available for adoption</h3></div>';
}

$conn->close();
?>

    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2023 Forest Pet Sanctuary</p>
    </div>
</footer>

<script>
function adoptPet(petId, petName, buttonElement) {
    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
        alert("Please login to adopt a pet.");
        window.location.href = "login.php?error=2";
        return;
    <?php endif; ?>

    if (confirm("Are you sure you want to adopt " + petName + "?")) {
        // Immediately update the UI
        buttonElement.disabled = true;
        buttonElement.textContent = "Processing...";
        buttonElement.className = "btn btn-pending";

        fetch("update_adoption.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "petId=" + encodeURIComponent(petId) + "&petName=" + encodeURIComponent(petName)
        })
        .then(res => res.text())
        .then(msg => {
            if (msg.startsWith("success")) {
                // Update to final pending state
                buttonElement.textContent = "Adoption Pending";
                buttonElement.className = "btn btn-pending";
                
                // Optional: Show a success message
                showNotification("Adoption request submitted for " + petName + "!", "success");
            } else {
                // Revert if there was an error
                buttonElement.disabled = false;
                buttonElement.textContent = "Adopt " + petName;
                buttonElement.className = "btn btn-adopt";
                
                // Show error message
                const errorMsg = msg.replace("error: ", "");
                showNotification("Failed to adopt " + petName + ": " + errorMsg, "error");
            }
        })
        .catch(err => {
            // Revert on network error
            buttonElement.disabled = false;
            buttonElement.textContent = "Adopt " + petName;
            buttonElement.className = "btn btn-adopt";
            
            showNotification("Network error. Please try again.", "error");
            console.error("Adoption error:", err);
        });
    }
}

// Helper function to show notifications
function showNotification(message, type = "success") {
    // Create notification element if it doesn't exist
    let notification = document.getElementById("adoption-notification");
    if (!notification) {
        notification = document.createElement("div");
        notification.id = "adoption-notification";
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            z-index: 10000;
            max-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        `;
        document.body.appendChild(notification);
    }
    
    // Style based on type
    if (type === "success") {
        notification.style.backgroundColor = "#27ae60";
    } else {
        notification.style.backgroundColor = "#e74c3c";
    }
    
    // Show message
    notification.textContent = message;
    notification.style.display = "block";
    notification.style.opacity = "1";
    
    // Auto-hide after 3 seconds
    setTimeout(() => {
        notification.style.opacity = "0";
        setTimeout(() => {
            notification.style.display = "none";
        }, 300);
    }, 3000);
}
</script>

</body>
</html>
