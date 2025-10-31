<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Pet Sanctuary</title>
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
        
        .section {
            padding: 4rem 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--forest-green);
        }
        
        .about {
            background-color: var(--white);
        }
        
        .about-content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 2rem;
        }
        
        .about-text {
            flex: 1;
            min-width: 300px;
        }
        
        .about-image {
            flex: 1;
            min-width: 300px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .form-section {
            background-color: var(--light-tan);
        }
        
        .pet-form {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--forest-green);
        }
        
        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .form-row .form-group {
            flex: 1;
            min-width: 200px;
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
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Pets</a></li>
                        <li><a href="#">Adoption</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <section class="hero">
        <div class="container">
            <h1>Welcome to Forest Pet Sanctuary</h1>
            <p>A safe haven for animals in need of love, care, and forever homes. Join us in our mission to rescue, rehabilitate, and rehome pets.</p>
            <a href="#pet-form" class="btn">Add a New Pet</a>
        </div>
    </section>
    
    <section class="section about">
        <div class="container">
            <h2 class="section-title">About Our Sanctuary</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>Forest Pet Sanctuary is dedicated to providing a safe and nurturing environment for animals in need. Our team of dedicated professionals and volunteers work tirelessly to ensure every pet receives the care and attention they deserve.</p>
                    <p>We believe that every animal deserves a loving home, and we work to match our rescued pets with families who will provide them with the care and companionship they need to thrive.</p>
                    <p>Our sanctuary specializes in rescuing and rehabilitating pets from various situations, providing medical care, behavioral training, and lots of love before they're ready for adoption.</p>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Happy pets at our sanctuary">
                </div>
            </div>
        </div>
    </section>
    
    <section id="pet-form" class="section form-section">
        <div class="container">
            <h2 class="section-title">Add a New Pet to Our Sanctuary</h2>
            <div class="pet-form">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "pet_sanctuary";
                    
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    
                    if ($conn->connect_error) {
                        echo "<div style='color: red; margin-bottom: 1rem;'>Connection failed: " . $conn->connect_error . "</div>";
                    } else {
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
                            echo "<div style='color: green; margin-bottom: 1rem;'>New pet added successfully!</div>";
                        } else {
                            echo "<div style='color: red; margin-bottom: 1rem;'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                        }
                        
                        $conn->close();
                    }
                }
                ?>
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Pet_ID">Pet ID:</label>
                            <input type="text" id="Pet_ID" name="Pet_ID" required>
                        </div>
                        <div class="form-group">
                            <label for="Pet_type">Pet Type:</label>
                            <input type="text" id="Pet_type" name="Pet_type" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Pet_Name">Pet Name:</label>
                            <input type="text" id="Pet_Name" name="Pet_Name" required>
                        </div>
                        <div class="form-group">
                            <label for="Age_Years">Age (Years):</label>
                            <input type="number" id="Age_Years" name="Age_Years">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Vaccinations">Vaccinations:</label>
                            <input type="number" id="Vaccinations" name="Vaccinations">
                        </div>
                        <div class="form-group">
                            <label for="Sex">Sex (M/F):</label>
                            <input type="text" id="Sex" name="Sex" maxlength="1">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="Environment_condition">Environment Condition:</label>
                        <input type="text" id="Environment_condition" name="Environment_condition">
                    </div>
                    
                    <div class="form-group">
                        <label for="Adoption_requirements">Adoption Requirements:</label>
                        <input type="text" id="Adoption_requirements" name="Adoption_requirements">
                    </div>
                    
                    <div class="form-group">
                        <label for="Booking_requirements">Booking Requirements:</label>
                        <input type="text" id="Booking_requirements" name="Booking_requirements">
                    </div>
                    
                    <button type="submit" class="btn">Add Pet</button>
                </form>
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