
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_sanctuary";

// Function to get featured pets (available for adoption)
function getFeaturedPets($conn) {
    $sql = "SELECT p.Pet_ID, p.Pet_type, p.Pet_Name, p.Age_Years, p.Sex, p.Vaccinations,
                   a.Adoption_status
            FROM pets p 
            LEFT JOIN adoption a ON p.Pet_ID = a.Pet_ID
            WHERE a.Adoption_status IS NULL OR a.Adoption_status = 'Available' 
            OR a.Adoption_status = ''
            ORDER BY RAND() LIMIT 6";
    
    $result = $conn->query($sql);
    return $result;
}

// Function to get adopted pets for homepage (all adopted pets)
function getAdoptedPets($conn) {
    $sql = "SELECT p.Pet_ID, p.Pet_type, p.Pet_Name, p.Age_Years, p.Sex, p.Vaccinations,
                   p.Environment_condition, p.Adoption_requirements, p.Booking_requirements,
                   a.Adoption_status, u.First_name, u.Last_Name
            FROM pets p 
            JOIN adoption a ON p.Pet_ID = a.Pet_ID
            JOIN users u ON a.Customer_Id = u.Customer_Id
            WHERE a.Adoption_status = 'Adopted'
            ORDER BY a.Adoption_ID DESC
            LIMIT 6";
    
    $result = $conn->query($sql);
    return $result;
}



// Function to get user's adopted pets (for logged-in users)
function getUserAdoptedPets($conn, $user_id) {
    $sql = "SELECT p.Pet_ID, p.Pet_type, p.Pet_Name, p.Age_Years, p.Sex, p.Vaccinations,
                   p.Environment_condition, p.Adoption_requirements, p.Booking_requirements,
                   a.Adoption_status
            FROM pets p 
            JOIN adoption a ON p.Pet_ID = a.Pet_ID
            WHERE a.Customer_Id = ? AND a.Adoption_status = 'Adopted'
            ORDER BY a.Adoption_ID DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Function to get pet image URL
function getPetImage($petType) {
    $petType = strtolower($petType);
    $imageUrl = "https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
    
    if (strpos($petType, 'dog') !== false) {
        $imageUrl = "https://images.unsplash.com/photo-1552053831-71594a27632d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
    } elseif (strpos($petType, 'cat') !== false) {
        $imageUrl = "https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
    } elseif (strpos($petType, 'rabbit') !== false) {
        $imageUrl = "https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
    } elseif (strpos($petType, 'bird') !== false) {
        $imageUrl = "https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
    } elseif (strpos($petType, 'turtle') !== false || strpos($petType, 'tortoise') !== false) {
        $imageUrl = "https://images.unsplash.com/photo-1452857576997-f0f12cd77848?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
    }
    
    return $imageUrl;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Pet Sanctuary - Home</title>
    <style>
        :root {
            --forest-green: #2d5a27;
            --light-green: #4a7c59;
            --tan: #d2b48c;
            --light-tan: #f5f1e8;
            --white: #ffffff;
            --dark-brown: #8B4513;
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
            position: sticky;
            top: 0;
            z-index: 1000;
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
            background-attachment: fixed;
            color: var(--white);
            padding: 8rem 0;
            text-align: center;
            position: relative;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .btn {
            display: inline-block;
            background-color: var(--tan);
            color: var(--forest-green);
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .btn:hover {
            background-color: #e0c9a6;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        
        .btn-primary {
            background-color: var(--forest-green);
            color: var(--white);
            margin-right: 1rem;
        }
        
        .btn-primary:hover {
            background-color: var(--light-green);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }
        
        .btn-secondary:hover {
            background-color: var(--white);
            color: var(--forest-green);
        }
        
        .section {
            padding: 5rem 0;
        }
        
        .section-light {
            background-color: var(--white);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--forest-green);
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .section-title p {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: var(--white);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: var(--forest-green);
            margin-bottom: 1.5rem;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--forest-green);
        }
        
        .stats {
            background: linear-gradient(rgba(0,0,0,0.9), rgba(0,0,0,0.9)), 
                        url('https://images.unsplash.com/photo-1452857576997-f0f12cd77848?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: var(--white);
            text-align: center;
            padding: 4rem 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .stat-item h3 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            color: var(--tan);
        }
        
        .stat-item p {
            color: var(--white);
            font-size: 1.1rem;
        }
        
        .pets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .pet-card {
            background-color: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .pet-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
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
        
        .pet-type {
            color: var(--light-green);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .testimonials {
            background-color: var(--light-tan);
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .testimonial-card {
            background: var(--white);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 1.5rem;
            color: #555;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--tan);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--forest-green);
            font-weight: bold;
        }
        
        .cta {
            background: linear-gradient(135deg, var(--forest-green), var(--light-green));
            color: var(--white);
            text-align: center;
            padding: 5rem 0;
        }
        
        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }
        
        .cta p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        footer {
            background-color: var(--forest-green);
            color: var(--white);
            padding: 3rem 0 1rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1.5rem;
            color: var(--tan);
        }
        
        .footer-section p {
            margin-bottom: 0.5rem;
        }
        
        .social-links {
            display: flex;
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
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 2rem;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .status-adopted {
            background-color: #e8f5e8;
            color: var(--forest-green);
        }
        
        .status-available {
            background-color: #fff3cd;
            color: #856404;
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
            font-size: 0.9rem;
        }
        
        .adopted-by {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: var(--light-green);
            font-weight: 600;
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
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .btn {
                display: block;
                margin: 0.5rem auto;
                width: 80%;
                max-width: 250px;
            }
            
            .btn-primary {
                margin-right: 0;
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
                    <i class="fas fa-paw"></i>
                    Forest Pet Sanctuary
                </div>
                <nav>
                    <ul>
                        <li><a href="homepage.php">Home</a></li>
                        <li><a href="booking.php">Booking</a></li>
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <li><a href="add_pet.php">Give Pet</a></li>
                            <li><a href="adopt.php">Adopt</a></li>
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
            <div class="hero-content">
                <h1>Welcome to Forest Pet Sanctuary</h1>
                <p>Where every pet finds love, care, and a second chance at happiness. Join us in creating forever homes for our furry, feathered, and scaled friends.</p>
                <div class="hero-buttons">
                    <a href="adopt.php" class="btn btn-primary">Adopt a Pet</a>
                    <a href="booking.php" class="btn btn-primary">Bookings</a>
                    <a href="add_pet.php" class="btn btn-primary">Give a Pet For Adoption</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="section section-light">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Forest Pet Sanctuary?</h2>
                <p>We are committed to providing the best care and finding loving homes for all our animals</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Loving Care</h3>
                    <p>Our dedicated team provides personalized attention and medical care to every animal in our sanctuary.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>Forever Homes</h3>
                    <p>We carefully match pets with loving families to ensure successful, lifelong adoptions.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3>Community Support</h3>
                    <p>Join our community of pet lovers, volunteers, and supporters making a difference every day.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="stats">
        <div class="container">
            <div class="section-title">
                <h2 style="color: #ffffff;">Our Impact</h2>
                <p style="color: #d2b48c;">Making a difference in the lives of animals and families</p>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Pets Rescued</p>
                </div>
                <div class="stat-item">
                    <h3>350+</h3>
                    <p>Successful Adoptions</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Volunteers</p>
                </div>
                <div class="stat-item">
                    <h3>98%</h3>
                    <p>Success Rate</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Featured Pets</h2>
                <p>Meet some of our wonderful pets waiting for their forever homes</p>
            </div>
            <div class="pets-grid">
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                if ($conn->connect_error) {
                    echo "<div style='color: red; text-align: center; width: 100%;'>Connection failed: " . $conn->connect_error . "</div>";
                } else {
                    $result = getFeaturedPets($conn);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $imageUrl = getPetImage($row["Pet_type"]);
                            
                            echo '<div class="pet-card">';
                            echo '<img src="' . $imageUrl . '" alt="' . $row["Pet_Name"] . '" class="pet-image">';
                            echo '<div class="pet-info">';
                            echo '<span class="status-badge status-available">Available</span>';
                            echo '<h3 class="pet-name">' . $row["Pet_Name"] . '</h3>';
                            echo '<p class="pet-type">' . $row["Pet_type"] . ' • ' . $row["Age_Years"] . ' years • ' . $row["Sex"] . '</p>';
                            echo '<a href="adopt.php" class="btn" style="width: 100%; margin-top: 1rem;">Meet ' . $row["Pet_Name"] . '</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div style="text-align: center; width: 100%; grid-column: 1 / -1;">';
                        echo '<h3>No pets available at the moment</h3>';
                        echo '<p>Check back soon for new arrivals!</p>';
                        echo '</div>';
                    }
                    $conn->close();
                }
                ?>
            </div>
            <div style="text-align: center; margin-top: 3rem;">
                <a href="adopt.php" class="btn btn-primary">View All Pets</a>
            </div>
        </div>
    </section>
    
    <section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Featured Friends</h2>
            <p>Book a Friend Today</p>
        </div>
        <div class="pets-grid">
            <?php
            // Connect to the database
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                echo "<div style='color: red; text-align: center; width: 100%;'>Connection failed: " . $conn->connect_error . "</div>";
            } else {
                // Fetch pets with status 'Processed'
                $sql = "SELECT Pet_ID, Pet_type, Pet_Name, Age_Years, Sex, Vaccinations,
                               Environment_condition, Adoption_requirements, Booking_requirements
                        FROM pets
                        WHERE status = 'Processed'
                        ORDER BY RAND()
                        LIMIT 6";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imageUrl = getPetImage($row["Pet_type"]);

                        echo '<div class="pet-card">';
                        echo '<img src="' . $imageUrl . '" alt="' . $row["Pet_Name"] . '" class="pet-image">';
                        echo '<div class="pet-info">';
                        echo '<span class="status-badge status-available">Processed</span>';
                        echo '<h3 class="pet-name">' . $row["Pet_Name"] . '</h3>';

                        echo '<div class="pet-details">';
                        echo '<div class="pet-detail"><span class="detail-label">Type:</span> ' . $row["Pet_type"] . '</div>';
                        echo '<div class="pet-detail"><span class="detail-label">Age:</span> ' . $row["Age_Years"] . '</div>';
                        echo '<div class="pet-detail"><span class="detail-label">Sex:</span> ' . $row["Sex"] . '</div>';
                        echo '</div>';

                        $description = "";
                        if ($row["Environment_condition"]) $description .= "Environment: {$row["Environment_condition"]}. ";
                        if ($row["Booking_requirements"]) $description .= "Booking Requirements: {$row["Booking_requirements"]}. ";

                        if ($description !== "") {
                            echo '<p class="pet-description">' . $description . '</p>';
                        }

                        echo '<a href="booking.php?pet_id=' . $row["Pet_ID"] . '" class="btn" style="width: 100%; margin-top: 1rem;">Book ' . $row["Pet_Name"] . '</a>';

                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div style="text-align: center; width: 100%; grid-column: 1 / -1;">';
                    echo '<h3>No pets are available for booking right now</h3>';
                    echo '<p>Check back soon to find your new friend!</p>';
                    echo '</div>';
                }

                $conn->close();
            }
            ?>
        </div>
        <div style="text-align: center; margin-top: 3rem;">
            <a href="booking.php" class="btn btn-primary">View All Booking Pets</a>
        </div>
    </div>
</section>

    <section class="section testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Happy Stories</h2>
                <p>Hear from families who found their perfect companions</p>
            </div>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Adopting Luna from Forest Pet Sanctuary was the best decision we ever made. The staff was incredibly helpful and supportive throughout the entire process."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">SJ</div>
                        <div>
                            <strong>Sarah Johnson</strong>
                            <p>Adopted 2 months ago</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "We adopted our rabbit, Thumper, and the sanctuary provided us with all the information we needed to create the perfect home for him. Highly recommended!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">MD</div>
                        <div>
                            <strong>Mike Davis</strong>
                            <p>Adopted 6 months ago</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "The adoption process was smooth and professional. Our new cat, Whiskers, has brought so much joy to our family. Thank you, Forest Pet Sanctuary!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">ET</div>
                        <div>
                            <strong>Emily Thompson</strong>
                            <p>Adopted 1 year ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <section class="section section-light">
        <div class="container">
            <div class="section-title">
                <h2>Pets You Took Home</h2>
                <p>Your adopted companions and their happy stories</p>
            </div>
            <div class="pets-grid">
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                if ($conn->connect_error) {
                    echo "<div style='color: red; text-align: center; width: 100%;'>Connection failed: " . $conn->connect_error . "</div>";
                } else {
                    $user_id = $_SESSION['Customer_Id'];
                    $result = getUserAdoptedPets($conn, $user_id);
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $imageUrl = getPetImage($row["Pet_type"]);
                            
                            echo '<div class="pet-card">';
                            echo '<img src="' . $imageUrl . '" alt="' . $row["Pet_Name"] . '" class="pet-image">';
                            echo '<div class="pet-info">';
                            echo '<span class="status-badge status-adopted">Adopted</span>';
                            echo '<h3 class="pet-name">' . $row["Pet_Name"] . '</h3>';
                            
                            echo '<div class="pet-details">';
                            echo '<div class="pet-detail"><span class="detail-label">Type:</span> ' . $row["Pet_type"] . '</div>';
                            echo '<div class="pet-detail"><span class="detail-label">Age:</span> ' . $row["Age_Years"] . '</div>';
                            echo '<div class="pet-detail"><span class="detail-label">Sex:</span> ' . $row["Sex"] . '</div>';
                            echo '</div>';
                            
                            $description = "";
                            if ($row["Environment_condition"]) $description .= "Environment: {$row["Environment_condition"]}. ";
                            if ($row["Adoption_requirements"]) $description .= "Requirements: {$row["Adoption_requirements"]}. ";
                            
                            if ($description !== "") {
                                echo '<p class="pet-description">' . $description . '</p>';
                            }
                            
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div style="text-align: center; width: 100%; grid-column: 1 / -1;">';
                        echo '<h3>You haven\'t adopted any pets yet</h3>';
                        echo '<p>Visit our adoption page to find your perfect companion!</p>';
                        echo '<a href="adopt.php" class="btn btn-primary" style="margin-top: 1rem;">Browse Pets</a>';
                        echo '</div>';
                    }
                    $conn->close();
                }
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <section class="cta">
        <div class="container">
            <h2>Ready to Make a Difference?</h2>
            <p>Whether you're looking to adopt, volunteer, or support our mission, there are many ways to get involved and help animals in need.</p>
            <div class="cta-buttons">
                <a href="adopt.php" class="btn" style="background-color: var(--tan); color: var(--forest-green); margin-right: 1rem;">Adopt a Pet</a>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Forest Lane, Green Valley</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@forestpetsanctuary.org</p>
                </div>
                
                <div class="footer-section">
                    <h3>Hours</h3>
                    <p>Monday - Friday: 9am - 6pm</p>
                    <p>Saturday: 10am - 4pm</p>
                    <p>Sunday: Closed</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="adopt.php" style="color: var(--white); text-decoration: none;">Adopt a Pet</a></p>
                    <p><a href="booking.php" style="color: var(--white); text-decoration: none;">Booking</a></p>
                    <p><a href="add_pet.php" style="color: var(--white); text-decoration: none;">Give a Pet</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 Forest Pet Sanctuary. All rights reserved. | Made with <i class="fas fa-heart" style="color: #ff6b6b;"></i> for animals</p>
            </div>
        </div>
    </footer>
</body>
</html>
