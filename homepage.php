
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
            ORDER BY RAND() LIMIT 12";
    
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
            LIMIT 12";
    
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
    $stmt->bind_param("s", $user_id); // FIX: Changed "i" to "s" for string binding
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
            <h2>Featured Exotic Pets</h2>
            <p>Experience our majestic exotic animals - Book a viewing session today!</p>
        </div>
        <div class="pets-grid">
            <?php
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                echo "<div style='color: red; text-align: center; width: 100%;'>Connection failed: " . $conn->connect_error . "</div>";
            } else {
                // Get ALL exotic pets from the exotic table
                $sql = "SELECT Pet_ID, Pet_type, Pet_Name, Age_Years, Sex, Vaccinations,
                               Environment_condition, Booking_requirements
                        FROM exotic
                        ORDER BY RAND()
                        LIMIT 12";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Custom images for each exotic animal
switch($row["Pet_type"]) {
    case 'Siberian Tiger':
        $imageUrl = 'data:image/jpeg;base64,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';
        break;
    case 'Grizzly Bear':
        $imageUrl = 'https://animalfactguide.com/wp-content/uploads/2024/01/grizzly-bear2.jpg';
        break;
    case 'Great White Shark':
        $imageUrl = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxAQEhUQDxAVFQ8PFRUPFRUVFQ8VFRAVFRUWFhUVFRUYHSggGBolHRUVITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OFxAQGC0dHR0tLS0tKy0tLS0tLS0rKy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIALcBEwMBIgACEQEDEQH/xAAbAAADAAMBAQAAAAAAAAAAAAAAAQIDBAUGB//EAD0QAAICAQIEAwUFBAkFAAAAAAABAhEDBCEFEjFBUWFxBhMigZEyQqGx0SNSwfAUFTNDYnKy4fEHJFNjov/EABoBAAMBAQEBAAAAAAAAAAAAAAABAgMEBQb/xAAkEQEBAAIBBAICAwEAAAAAAAAAAQIRAxIhMUEEURMiFGKhYf/aAAwDAQACEQMRAD8A8YwTIsaPotPPZEWjGikzSJqgQmxFBVgTY7ALTHZCY0wC0OyUwsYU2S2Fk2BG2S2DYrA1JgSAEqxWJsVgarHZIWIHYhMVhsG2KxNibFsw2KxWJsWwfMYmwbJbJUoLFYE2mGxNhZLZFAsCbARtkpEWNM3QyIpMxplJjhKbBEsLGFWFk2FhsLsdmCeeMWlKVN+NmYmcmNtkvc9VaCybAsjsViYWGyDFYgFs1WAgDZBsAYIWzMBBYbBNgIQtmLE2KyWw2A2S2BLFs9BsQmxEWmqwslsVk7NTZDYNktk2no7AiwJ2em2hkWOzqZssWUjEmWmBKbFZLYWMKsLIsdioa3EIWlLw/Jl8O1H93Jqn9mT25X5vwLzK4teRz8Z5Py7ePlmWLq4v2x1XcyQcW4yVSWzRNj0OseSMMWWksacYTr4kvuxk/vRT+l+iFOLTp9ju4Pkzln/WGfHcaTEMR0dSACM2DS5MjqEJSb8E2drReyWqn1UYf5nv9FZnly44+aNVwaHynv8AQf8ATvm/tMzflGKX4uz0mh/6baSO+RTl5OT/AIUc+XzeOe9rnFlXxzlEff17K8PxLbS4du8oxk/rKzWzcPxt8uLFBLyhBfw2Mr8/H1Ffhr4TyjcH4P6M+4ZOF9m16UaOp0cFtf0/Un+f/X/R+J8aa8iWfWJaPHfxfnZr5+HabdzW3mosqfOn0X43y1kM+g5tDoX/AHS+iX5HOz8BwTf7LHL1TlX8Sv5uA6K8ayWeo1Hso4/faT+f8DmangUoq1NP1TX4qyp8njvsdNcdsVmbJpZrtfozDKLXVFTlxvin00WKxWKytg2yWxNiZNoFgIBbNtWUmY0yjr2yWmVZjTKsYNsLJsLAKHZFlIm0zOdBbm9lnyq/5sy8J4TPNv0h+8/4eJ5fzbuyN+LtLWPQ6eeR8uOLbW/p6nqI8LxKC9+5e97LHytPw5m+nyNrT4o4Y8mNb/m/GT/gbmi0HPbk2/Gt2znw/XvDyu3J0/AYveTe/RbHa0HAI2lHGrfdq3+PQ73DtEormaS8L3f6I7GlUMac6t/4n1foXnz5X2iYxz9DwtQ2SuX4I7Gj0kesn/E4uo1MVLmzZKT8dl6I2cPtHgSaT3Wy670jmyyaYx63SxUei6j1WtjBbvc8rj9o+bHzL7TV1ffvv/PQ5j4usuHmUvicL67p8u9+ZnctLeh1XFOb7LVPv+hGk4hGUlFPze/4s8tquIRlihKMqcoxv6JdOxoYNU1bT+0qROVKPV6zivxuMXsurOZrOJ1TSs5uGE6tvr28fM3sOgUknN0vD8vkTcja39PlLtv+pqaiGSTpxpdt+p1sOhV/Cr87TS9TPq9K+Vp2tnVX+f8APUUz0HltVinBpOO7dJeLqxR4rPEns9vDobEdV7uGLJK37uMvhb3d1V827kqr6mrruJY8nWKk3v4JfJBc6ckcnWe1k5JPor62kma2p4hLljKT2yLmUlNNS+nox8Q4L/Sd+bddORfDHybOfqODTi4YscZTUetK1fV32W5UqtRh9+5bq/1Mfvfi6s7H9WNSUOXdyUezjzbum+iVRbfovE2tesGFNzWLmapLGpdfJWa48eWXZNykcBvFdS6eK6mlZl1GbmbpUjAz1ODDLHH9qwyst7GS2BLNSMBCFsNqwhNPoxWYpRp8yNuXPLGbk2iTbaTGTgkp9HT8+hU4OPVBhzY5eCs0QE2Oy9hSNzQaDJmdY43XV9IxXi32MvDOG87TyPlh9G/0R2dXxmEIrDp4pY49/wB5+Pmc/LzzHtPJzG1iw8FxQSeVqTXjtH5LuZ8uvjH4YLp36JeiOVk1je8ma0c1s8/PO5XdbY4u9p527bt/h9D0umzwxxjFdl+LPFabUU78OhsviD8SBY9tDiN99uxjnxTd77R6eFnkocRfibOPU2TSbvGZTyJTu+VqX12aNdYWpR5Lppb9vJ/ixym5R5fEeny8+GT6ZMPNB34Q+L/RzL5GPvVX6Z+HT5JSi993JLyb/Wxt+7nLDytStpLa/j+KO/pJGpqJuWPHON80eeMtt2nyuPr9/wCplnnlLJB18clBpV1a+Bf6SumFtysvPjl7qV1jk4Vv2dLr5He4VpVJW5VRp8d0GWGeXvVU2oZGn/iit/w/MrSSaVX57GWWK9u3CcE1FU+VVZer1jqKW0OjPO5NU4vZ7nc4FoXrFOMnywVO/Py/EmYW0/Day8Uhjiu1d/XocLW+0OScuXGt3Sr97+fA7UPZWbf7TJ8C+ba8P9zbwcEh7z/tsUYvvklcuX/Km+ppjwX2nrjgw4Akll12dQfXlfxyX1dIa1HCsXSHvPOUuvyR62fsrpZb517ySp80m7td1XT5HM1XsroIR+3OPK7+3a8tpWttq9DaYa8Quqe68zrfazSfZxaeHhstvp8jz+v9pHN9kl2jt/wZPaWekwv3enbk47dIV67JfU8q2dXFxe6i2enW1ntBmyQ92qjjT5qil18WzlTm27bt+ZLYrOnHGY+EmJsQmUDbJYNiFaZ2BIyQ2LGSOzq2zY5Lldrp+RuYtW3Hle6/L0NeStUYItpnBzYdGW54rSd43JI2oRjiSlPeb3S/d/V/kYFL3cbkvik7in1S8TUnKUncnuF5sunQmM228mulLq9vAmOc1kikc1aTTZ97Y45DXiy0yaptrKV701VIuDYt0N3Fk3Ojp89HIgzb0+4k2PQaXVxezXkRgz48WqSm6wale6m30jLfkk/m2vSTNXSOMWuZPxI47r9PLG8fK+Z9Guz7Mz5J7GP09Hh0qUGp1JYskYyr1eO/RuSZ2/6tWny6fJ1hkVRTX2ZRadPxW8mvQ8h7M8TuHuptOOswZMUn95ZcS+Bxl2v9n9Ee44Jx7FqsEMiwySwOKSnT5fhrmT7+F9TTCdScuzocX4Fi1GZZckpKoLG0qqSjJtb9n8TRoP2X00X1nXb4o/ob2r4kuXmUla3a71/L/A4+Xj2Nfftm/wCOM7lW9H2f0i+43XjKW/qbWH3WFVCKiurrazy+p9poLozha/2p60ypxyFu177NrY95UjV1HtDixL7SPluq9o8j6SZyc+unLq2aTj2NV9E4r7exjax7s8Xxf2lz57ubUX2RxZTvqQ2aTCQ9G5E2AizMCQAzbFYNkti2BYmACBAACDYGmSM6WarMWTZplmPP0XqY8/fCrx8tnHqOXeVO/qbMNZB18K+iOZd7FrwMeHK5b+jyxjaywX2o9H28DNg0E5ukq7W+xhw5eS00rdp7KUvCt9l+Zl/rB3aVLwu6K/FjaW63MfAsj7x+r/Qz4vZ3I+s4Lyt/oamPirNqHGgvDgnqzbS9mJf+SH/14ehnfsxL7uSL6dbXqakOO0ZV7RMjLjwEyzVn4C8UXPLlhCCtttvZbdq3fkciPHY45OOmxLI3SU8sdk/GONP82bPGNUtVFY1B80Wpc/M+WN9mujf5Gbh3D4Yo8z28+7OHPtezfHx3VouE5s/7XWZnGC35I1G/JJbI1NfhxK+VVFdO/wDyzLrtY3v9xbdav/c42fUuTvsuiJw4ss6q5ab3CdRPE4tpOMHKUYu9uZJXfZ7J/I6Gk4vlww93DJKMG7rzqu/T5HnnnZLm/E7sODpZZXbuZOMZH1nJv1ZrT1033OWSm/3m/mXcamSNzLqJeJglO+5jsVmsmgpslsTYmyho7JbFYrJ2Z2FisLAGFisViBtiEKxBTZICEDAVgGwz2VZFjTOlCrIy9CrIyK1SM+SbxsVPKMTt+hlsiKpDsjjx6cdKt3VWNMlDLJaY7JTGPZKs2dDpXllS6Lq/57j4bw+eeXLBbd34HtuH6LHp0oQi8mWnJRiuZ7K3KTXRLq32Ofm5pjNTycm2ppuHRxx5pqorsc7ifEortUV0XeXzI9oOLfHyxyQyKlK8bk4K+1tLdHnc+olN3L08kjl4+K53d7Re9Mmq1Usjt/JLojBZNhZ3Y4zGaiDsLJsLKC+YLIsdiCrFZLYrDYOxNhZIbB2IBCBgKxiAABAA2KwYhA7EArEZiCwAM1jskZ0IVYhAxWmGFisCdmZSIRkxtXum14J1+IrQcU3st2zs8P4LfxZnyx8LV/N9jQhr+T+zgo+e7f1MObVzn9qT9Oi+hjleTLtJpXZ7DT8U0eG1LI1CO3JijzZMnik21GP+aXyTOPxn2nyZk8eGPuNPLZwi255V/wC7J1n6bRXZHAbE2LDgk73vRcvo7CybCzZKrExPcA3QdiEABTCyRgBYWIGAArAQAAIABjsQCBiAViAEDYgM7EFiEZgIA2GZDJRRrtAEAhWmYCAnYMpMkYbBhYhDB2ITZDcvAm5aORdlVtfYxxb7opMN7m4SlX8pg4iU2JyDuAFiAoKAQCAEAAAJgINgDJCxBQCsABkgIDMQ0/FCb8BbMAIBUxYCAWxpmTHZKGXtB2KxAxbBgIA2FIZN0CmhdU+z1VCARZAF5iEMKl5bkc78PwGFmdxt9nKOZvsOxpMEgnbzR5IaFT+QDl2NGAgKIWIBMAGxWAgMwEAgoBCAGxWACMMQMBbMAIZNpgAAWwyWFgA2YsVjAcBWOwAoz2GgANQEJsAKgKwsAAALAAA5hcwAZcmdx8Kk2djTADSd4miwYABEJgAzKxAAjAWMAAEACMAACoACAkzFYASDAAAP/9k=';
        break;
    case 'African Lion':
        $imageUrl = 'https://images.unsplash.com/photo-1552410260-0fd9b577afa6?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80';
        break;
    case 'Polar Bear':
        $imageUrl = 'data:image/jpeg;base64,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';
        break;
    case 'King Cobra':
        $imageUrl = 'data:image/jpeg;base64,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';
        break;
    case 'Silverback Gorilla':
        $imageUrl = 'https://www.bwindinationalparkuganda.com/wp-content/uploads/2017/09/maxresdefault.jpg';
        break;
    default:
        $imageUrl = getPetImage($row["Pet_type"]);
}

                        echo '<div class="pet-card">';
                        echo '<div style="position: relative;">';
                        echo '<span style="position: absolute; top: 10px; left: 10px; background-color: #8B0000; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;"><i class="fas fa-exclamation-triangle"></i> Exotic</span>';
                        echo '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($row["Pet_Name"]) . '" class="pet-image">';
                        echo '</div>';
                        echo '<div class="pet-info">';
                        echo '<span class="status-badge status-available">Available for Viewing</span>';
                        echo '<h3 class="pet-name">' . htmlspecialchars($row["Pet_Name"]) . '</h3>';

                        echo '<div class="pet-details">';
                        echo '<div class="pet-detail"><span class="detail-label">Species:</span> ' . htmlspecialchars($row["Pet_type"]) . '</div>';
                        echo '<div class="pet-detail"><span class="detail-label">Age:</span> ' . htmlspecialchars($row["Age_Years"]) . ' years</div>';
                        echo '<div class="pet-detail"><span class="detail-label">Sex:</span> ' . htmlspecialchars($row["Sex"]) . '</div>';
                        echo '<div class="pet-detail"><span class="detail-label">Vaccinations:</span> ' . htmlspecialchars($row["Vaccinations"]) . '</div>';
                        echo '</div>';

                        $description = "";
                        if ($row["Environment_condition"]) $description .= "Habitat: {$row["Environment_condition"]}. ";
                        if ($row["Booking_requirements"]) $description .= "Requirements: {$row["Booking_requirements"]}";

                        if ($description !== "") {
                            echo '<p class="pet-description" style="color: #8B0000; font-weight: bold; font-size: 0.9rem;">';
                            echo '<i class="fas fa-exclamation-circle"></i> ' . htmlspecialchars($description);
                            echo '</p>';
                        }

                        echo '<a href="booking.php?pet_id=' . htmlspecialchars($row["Pet_ID"]) . '&tab=adoption" class="btn" style="width: 100%; margin-top: 1rem; background-color: #8B0000; color: white; border: none;">';
                        echo '<i class="fas fa-calendar-alt"></i> Book Viewing: ' . htmlspecialchars($row["Pet_Name"]);
                        echo '</a>';

                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div style="text-align: center; width: 100%; grid-column: 1 / -1;">';
                    echo '<h3>No exotic pets available at the moment</h3>';
                    echo '<p>Check back soon for new arrivals!</p>';
                    echo '</div>';
                }

                $conn->close();
            }
            ?>
        </div>
        <div style="text-align: center; margin-top: 3rem;">
            <a href="booking.php?tab=adoption" class="btn btn-primary" style="background-color: #8B0000; border-color: #8B0000;">View All Exotic Pets</a>
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
                        LIMIT 12";

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
                        echo '<a href="booking.php?pet_id=' . $row["Pet_ID"] . '&tab=visit" class="btn" style="width: 100%; margin-top: 1rem;">Book ' . $row["Pet_Name"] . '</a>';
                        

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
    <section class="section section-light">
    <div class="container">
        <div class="section-title">
            <h2>Pets Available for Adoption</h2>
            <p>Find your perfect companion from our wonderful pets looking for forever homes</p>
        </div>
        <div class="pets-grid">
            <?php
            // Connect to the database
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                echo "<div style='color: red; text-align: center; width: 100%;'>Connection failed: " . $conn->connect_error . "</div>";
            } else {
                // First, get the Pet_IDs that were displayed in the exotic section
                $displayedExoticIds = array();
                if (isset($exoticResult) && $exoticResult->num_rows > 0) {
                    // Reset pointer and collect IDs
                    $exoticResult->data_seek(0);
                    while ($row = $exoticResult->fetch_assoc()) {
                        $displayedExoticIds[] = $conn->real_escape_string($row['Pet_ID']);
                    }
                }
                
                // Build WHERE clause to exclude already displayed exotic pets
                $excludeClause = '';
                if (!empty($displayedExoticIds)) {
                    $excludeClause = "AND p.Pet_ID NOT IN ('" . implode("','", $displayedExoticIds) . "')";
                }
                
                // Fetch pets available for adoption (status 'processed' and not adopted)
                $sql = "SELECT p.Pet_ID, p.Pet_type, p.Pet_Name, p.Age_Years, p.Sex, p.Vaccinations,
                               p.Environment_condition, p.Adoption_requirements, p.Booking_requirements,
                               a.Adoption_status
                        FROM pets p
                        LEFT JOIN adoption a ON p.Pet_ID = a.Pet_ID
                        WHERE (p.status = 'processed' OR p.status = 'processing')
                        AND (a.Adoption_status IS NULL OR a.Adoption_status = 'Available' OR a.Adoption_status = '')
                        $excludeClause
                        ORDER BY RAND()
                        LIMIT 12";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imageUrl = getPetImage($row["Pet_type"]);

                        echo '<div class="pet-card">';
                        echo '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($row["Pet_Name"]) . '" class="pet-image">';
                        echo '<div class="pet-info">';
                        
                        // Determine status badge
                        if ($row['Adoption_status'] === 'Available' || empty($row['Adoption_status'])) {
                            echo '<span class="status-badge status-available">Available</span>';
                        } else {
                            echo '<span class="status-badge status-adopted">' . htmlspecialchars($row['Adoption_status']) . '</span>';
                        }
                        
                        echo '<h3 class="pet-name">' . htmlspecialchars($row["Pet_Name"]) . '</h3>';

                        echo '<div class="pet-details">';
                        echo '<div class="pet-detail"><span class="detail-label">Type:</span> ' . htmlspecialchars($row["Pet_type"]) . '</div>';
                        echo '<div class="pet-detail"><span class="detail-label">Age:</span> ' . htmlspecialchars($row["Age_Years"]) . ' years</div>';
                        echo '<div class="pet-detail"><span class="detail-label">Sex:</span> ' . htmlspecialchars($row["Sex"]) . '</div>';
                        echo '<div class="pet-detail"><span class="detail-label">Vaccinations:</span> ' . htmlspecialchars($row["Vaccinations"]) . '</div>';
                        echo '</div>';

                        $description = "";
                        if ($row["Environment_condition"]) $description .= "Ideal Home: {$row["Environment_condition"]}. ";
                        if ($row["Adoption_requirements"]) $description .= "Requirements: {$row["Adoption_requirements"]}. ";

                        if ($description !== "") {
                            echo '<p class="pet-description">' . htmlspecialchars($description) . '</p>';
                        }

                        echo '<a href="adopt.php?pet_id=' . htmlspecialchars($row["Pet_ID"]) . '" class="btn" style="width: 100%; margin-top: 1rem; background-color: var(--forest-green); color: white;">';
                        echo '<i class="fas fa-heart"></i> Adopt ' . htmlspecialchars($row["Pet_Name"]);
                        echo '</a>';

                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div style="text-align: center; width: 100%; grid-column: 1 / -1;">';
                    echo '<h3>No pets available for adoption at the moment</h3>';
                    echo '<p>Check back soon for new arrivals!</p>';
                    echo '</div>';
                }

                $conn->close();
            }
            ?>
        </div>
        <div style="text-align: center; margin-top: 3rem;">
            <a href="adopt.php" class="btn btn-primary">View All Adoptable Pets</a>
        </div>
    </div>
</section>
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
                    // *** THIS LINE ENSURES SPECIFICITY TO THE USER ***
                    $user_id = $_SESSION['Customer_Id'];
                    $result = getUserAdoptedPets($conn, $user_id);
                    // ************************************************
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $imageUrl = getPetImage($row["Pet_type"]);

                            // Determine if pet is exotic - using the same logic as above
                            $exoticTypes = ['snake', 'lizard', 'iguana', 'turtle', 'tortoise', 'corn snake', 'bearded dragon', 'ball python', 'red-eared slider', 'crested gecko', 'tarantula (chilean rose)', 'macaw', 'sugar glider', 'hedgehog', 'chinchilla', 'ferret'];
                            $petTypeLower = strtolower($row["Pet_type"]);

                            $isExotic = in_array($petTypeLower, $exoticTypes) || 
                                       (strpos($petTypeLower, 'snake') !== false && !in_array($petTypeLower, ['corn snake', 'ball python'])) || 
                                       (strpos($petTypeLower, 'lizard') !== false && !in_array($petTypeLower, ['iguana', 'bearded dragon', 'crested gecko'])) ||
                                       (strpos($petTypeLower, 'turtle') !== false && !in_array($petTypeLower, ['red-eared slider'])) ||
                                       (strpos($petTypeLower, 'tortoise') !== false && !in_array($petTypeLower, ['russian tortoise']));
                            
                            echo '<div class="pet-card">';
                            
                            if ($isExotic) {
                                // For adopted pets, we need to know if it's from the exotic table, but the query only selects from pets table (due to join with adoption)
                                // We'll rely on the Pet_type for image and the badge will still show
                                echo '<div style="position: relative;">';
                                echo '<span style="position: absolute; top: 10px; left: 10px; background-color: var(--dark-brown); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">Unique</span>';
                                echo '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($row["Pet_Name"]) . '" class="pet-image">';
                                echo '</div>';
                            } else {
                                echo '<img src="' . $imageUrl . '" alt="' . htmlspecialchars($row["Pet_Name"]) . '" class="pet-image">';
                            }

                            echo '<div class="pet-info">';
                            echo '<span class="status-badge status-adopted">Adopted</span>';
                            echo '<h3 class="pet-name">' . htmlspecialchars($row["Pet_Name"]) . '</h3>';
                            
                            echo '<div class="pet-details">';
                            echo '<div class="pet-detail"><span class="detail-label">Type:</span> ' . htmlspecialchars($row["Pet_type"]) . '</div>';
                            echo '<div class="pet-detail"><span class="detail-label">Age:</span> ' . htmlspecialchars($row["Age_Years"]) . '</div>';
                            echo '<div class="pet-detail"><span class="detail-label">Sex:</span> ' . htmlspecialchars($row["Sex"]) . '</div>';
                            echo '</div>';
                            
                            $description = "";
                            if (isset($row["Environment_condition"]) && $row["Environment_condition"]) $description .= "Environment: " . htmlspecialchars($row["Environment_condition"]) . ". ";
                            if (isset($row["Adoption_requirements"]) && $row["Adoption_requirements"]) $description .= "Requirements: " . htmlspecialchars($row["Adoption_requirements"]) . ". ";
                            
                            if ($description !== "") {
                                echo '<p class="pet-description">' . $description . '</p>';
                            }
                            
                            if ($isExotic) {
                                echo '<p style="color: var(--dark-brown); font-weight: bold; margin-bottom: 0.5rem;"><i class="fas fa-star"></i> Unique Pet</p>';
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
