<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Pet - Forest Pet Sanctuary</title>
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
        
        .btn-submit {
            background-color: var(--forest-green);
            color: var(--white);
            width: 100%;
            margin-top: 1rem;
            font-size: 1.1rem;
            padding: 1rem;
        }
        
        .btn-submit:hover {
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
        
        .form-container {
            background-color: var(--white);
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-row {
            display: flex;
            gap: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: var(--forest-green);
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--forest-green);
            outline: none;
        }
        
        .form-half {
            flex: 1;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-info {
            background-color: #f0f7f0;
            border-left: 4px solid var(--forest-green);
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }
        
        .form-info h3 {
            color: var(--forest-green);
            margin-bottom: 0.5rem;
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
            
            .form-row {
                flex-direction: column;
                gap: 0;
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
                        <li><a href="give_pet.php">Give Pet</a></li>
                        <li><a href="add_pet.php">Add Pet</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <section class="hero">
        <div class="container">
            <h1>Add New Pet to Sanctuary</h1>
            <p>Add a new pet to our database. This form is for sanctuary staff to register new arrivals.</p>
        </div>
    </section>
    
    <section class="section">
        <div class="container">
            <h2 class="section-title">Pet Registration Form</h2>
            
            <div class="form-container">
                <div class="form-info">
                    <h3>Staff Information</h3>
                    <p>This form is for sanctuary staff use only. Please ensure all information is accurate before submitting.</p>
                </div>
                
                <form action="insert_pet.php" method="POST" id="petForm">
                    <div class="form-group">
                        <label for="Pet_ID">Pet ID (Auto-generated)</label>
                        <input type="text" class="form-control" id="Pet_ID" name="Pet_ID" value="Select pet type first" readonly>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-half">
                            <div class="form-group">
                                <label for="Pet_type">Pet Type *</label>
                                <select class="form-control" id="Pet_type" name="Pet_type" required>
                                    <option value="">Select Pet Type</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Rabbit">Rabbit</option>
                                    <option value="Bird">Bird</option>
                                    <option value="Fish">Fish</option>
                                    <option value="Turtle">Turtle</option>
                                    <option value="Tortoise">Tortoise</option>
                                    <option value="Snake">Snake</option>
                                    <option value="Lizard">Lizard</option>
                                    <option value="Iguana">Iguana</option>
                                    <option value="Hamster">Hamster</option>
                                    <option value="Guinea Pig">Guinea Pig</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-half">
                            <div class="form-group">
                                <label for="Pet_Name">Pet Name *</label>
                                <input type="text" class="form-control" id="Pet_Name" name="Pet_Name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-half">
                            <div class="form-group">
                                <label for="Age_Years">Age (Years) *</label>
                                <input type="number" class="form-control" id="Age_Years" name="Age_Years" min="0" max="30" step="0.1" required>
                            </div>
                        </div>
                        
                        <div class="form-half">
                            <div class="form-group">
                                <label for="Sex">Sex *</label>
                                <select class="form-control" id="Sex" name="Sex" required>
                                    <option value="">Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Unknown">Unknown</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="Vaccinations">Vaccination Status *</label>
                        <select class="form-control" id="Vaccinations" name="Vaccinations" required>
                            <option value="">Select Vaccination Status</option>
                            <option value="Up to date">Up to date</option>
                            <option value="Partially vaccinated">Partially vaccinated</option>
                            <option value="Not vaccinated">Not vaccinated</option>
                            <option value="Unknown">Unknown</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="Environment_condition">Ideal Environment *</label>
                        <textarea class="form-control" id="Environment_condition" name="Environment_condition" required placeholder="Describe the ideal home environment for this pet (e.g., quiet home, active family, needs yard, etc.)"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="Adoption_requirements">Adoption Requirements</label>
                        <textarea class="form-control" id="Adoption_requirements" name="Adoption_requirements" placeholder="Any specific requirements for adoption (e.g., experienced owner, no small children, etc.)"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="Booking_requirements">Booking/Meeting Requirements</label>
                        <input type="text" class="form-control" id="Booking_requirements" name="Booking_requirements" placeholder="Any specific requirements for meeting the pet (e.g., home visit, multiple visits, etc.)">
                    </div>
                    
                    <button type="submit" class="btn btn-submit">Add Pet to Database</button>
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
    
    <script>
        // Update Pet ID when pet type changes
        document.getElementById('Pet_type').addEventListener('change', function() {
            const petType = this.value;
            
            if (petType) {
                // Send AJAX request to get new Pet ID
                fetch('get_pet_id.php?type=' + encodeURIComponent(petType))
                    .then(response => response.text())
                    .then(petId => {
                        document.getElementById('Pet_ID').value = petId;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                document.getElementById('Pet_ID').value = 'Select pet type first';
            }
        });

        // Form validation
        document.getElementById('petForm').addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = document.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '#ddd';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            } else {
                // Show confirmation before submitting
                if (!confirm('Are you sure you want to add this pet to the database?')) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>