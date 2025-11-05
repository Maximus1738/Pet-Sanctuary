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
        }
        
        .btn-adopt:hover {
            background-color: var(--light-green);
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
                    <i class="fas fa-paw"></i>
                    Forest Pet Sanctuary
                </div>
                <nav>
                    <ul>
                        <li><a href="homepage.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="adopt.php">Adopt</a></li>
                        <li><a href="add_pet.php">Add Pet</a></li>
                        <li><a href="contact.php">Contact</a></li>
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
            <h2 class="section-title">Featured Pets</h2>
            <div class="pets-grid">
                <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "pet_sanctuary";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                if ($conn->connect_error) {
                    echo "<div style='color: red; text-align: center;'>Connection failed: " . $conn->connect_error . "</div>";
                } else {
                    // Fetch pets from database that are available for adoption
                    $sql = "SELECT p.*, a.Adoption_status 
                            FROM Pets p 
                            LEFT JOIN adoption a ON p.Pet_ID = a.Pet_ID 
                            WHERE a.Adoption_status IS NULL OR a.Adoption_status = 'Available' 
                            LIMIT 6";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            // Generate a placeholder image based on pet type
                            $petType = strtolower($row["Pet_type"]);
                            $imageUrl = "";
                            
                            // Map pet types to appropriate Unsplash images
                            switch($petType) {
                                case "dog":
                                    $imageUrl = "https://images.unsplash.com/photo-1552053831-71594a27632d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
                                    break;
                                case "cat":
                                    $imageUrl = "https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
                                    break;
                                case "rabbit":
                                    $imageUrl = "https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
                                    break;
                                case "bird":
                                    $imageUrl = "https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
                                    break;
                                default:
                                    $imageUrl = "https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60";
                            }
                            
                            echo '<div class="pet-card">';
                            echo '<img src="' . $imageUrl . '" alt="' . $row["Pet_Name"] . '" class="pet-image">';
                            echo '<div class="pet-info">';
                            echo '<h3 class="pet-name">' . $row["Pet_Name"] . '</h3>';
                            echo '<div class="pet-details">';
                            echo '<div class="pet-detail"><span class="detail-label">Type:</span> ' . $row["Pet_type"] . '</div>';
                            echo '<div class="pet-detail"><span class="detail-label">Age:</span> ' . $row["Age_Years"] . ' years</div>';
                            echo '<div class="pet-detail"><span class="detail-label">Sex:</span> ' . $row["Sex"] . '</div>';
                            echo '<div class="pet-detail"><span class="detail-label">Vaccinations:</span> ' . ($row["Vaccinations"] ? $row["Vaccinations"] . ' received' : 'Pending') . '</div>';
                            echo '</div>';
                            
                            // Create description from database fields
                            $description = "This " . strtolower($row["Pet_type"]) . " is looking for a loving home. ";
                            if ($row["Environment_condition"]) {
                                $description .= "They thrive in " . $row["Environment_condition"] . " environments. ";
                            }
                            if ($row["Adoption_requirements"]) {
                                $description .= "Adoption requirements: " . $row["Adoption_requirements"] . ". ";
                            }
                            if ($row["Booking_requirements"]) {
                                $description .= "Booking requirements: " . $row["Booking_requirements"] . ".";
                            }
                            
                            echo '<p class="pet-description">' . $description . '</p>';
                            echo '<a href="adopt.php" class="btn btn-adopt">Adopt ' . $row["Pet_Name"] . '</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<div style='text-align: center; width: 100%;'>No pets available for adoption at the moment.</div>";
                    }
                    $conn->close();
                }
                ?>
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
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 Forest Pet Sanctuary. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>