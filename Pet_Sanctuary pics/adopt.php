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
        ORDER BY 
            CASE 
                WHEN a.Adoption_status = 'Available' THEN 1
                WHEN a.Adoption_status = 'Pending' THEN 2
                ELSE 3
            END,
            p.Pet_Name
        SQL;

    
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("SQL Prepare Failed: " . $conn->error);
        }
    
        // Customer_Id is varchar -> use "s"
        $stmt->bind_param("s", $user_id);
    
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
        $imageUrl = "https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=500&q=60"; // DEFAULT IMAGE

        // Map each pet type to a specific image
        if (strpos($petType, 'dog') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'cat') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'Rabbit') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'bird') !== false) {
            $imageUrl = "https://images.unsplash.com/photo-1522926193341-e9ffd686c60f?auto=format&fit=crop&w=500&q=60";
        } elseif (strpos($petType, 'fish') !== false) {
            $imageUrl = "data:image/jpeg;base64,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";
        } elseif (strpos($petType, 'turtle') !== false) {
            $imageUrl = "data:image/jpeg;base64,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";
        } elseif (strpos($petType, 'tortoise') !== false) {
            $imageUrl = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTzePEdFrx54XLv3tcfXJQDuvlmfxdClqrAdiukYomGGAxJjHAQBqUX_dhOyQLuQpHYypAXlRCoZhM3MvdU17iMshhNO1wLi2YcfksmDkzj&s=10";
        } elseif (strpos($petType, 'snake') !== false) {
            $imageUrl = "data:image/jpeg;base64,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";
        } elseif (strpos($petType, 'lizard') !== false) {
            $imageUrl = "data:image/jpeg;base64,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";
        } elseif (strpos($petType, 'iguana') !== false) {
            $imageUrl = "data:image/jpeg;base64,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";
        } elseif (strpos($petType, 'hamster') !== false) {
            $imageUrl = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShNGdfrlpVcnFNofn5q74pkxTkMq4JVa_k41Ecgv84WJsmrG15fGufTQtUFj_OO9UZhqMFN55ibUSNdJvMCg3PnKOp3G-BRTU_jKjAjtH0&s=10";
        } elseif (strpos($petType, 'guinea Pig') !== false || strpos($petType, 'pig') !== false) {
            $imageUrl = "data:image/webp;base64,UklGRkwhAABXRUJQVlA4IEAhAABQ3ACdASo4ATgBPy2EtlWuqCstqhlc8dAliU3EVCsWPHrLAG1+EKMMAMSH+R3xRU8tDzfsX/RPzX/xx9X5/7Tnm/6e4F/1ebz5kcn9XbzHzJz/88Hf/8mgEDM/1mlYNwdGwH6Q1dptV+ENl16sFxptlHiBS1GqWHWxZTfgyUQ8D6kS1+bcVmLIaeD62Z1GFrQpNBnKwbHyYMQT/qos/+3kRrOm96Xdee+Ngu0GRWApnPFPcdvyWavHigk2ImmsZCYwocOkri7x8eIsVkpVemFesa027P9YILAEyPbKVRRepslLfqKsoL+Jw9BWy0GsgNE8iogTPNaooYgLSH8YZG2D06DAnjAQBV4TZpa7DdW4jBLU4HUPQfnw90H2HldBY3vJaiMnRv3j4Ho3ngUJHJiv9weQ89q9feFnlJTXdTt4ok0b5wRIaQJ+bTS+XSYKeYJyy7TRPmKmId0mSsusk0Cim3gBCwQ9lgjDuOpmqnLi6JIbXdYG/82RDJee4RxVh9HWz4tSeePMv9oq4ZTdeq6DXWY49AfkD4zYLjn/9jMMlpB4Lm+038BTZr2hD7121NtCBuWsDpksYRYOUTDnrNnCFVGlTDhH8qYwzg7AkUg92zsK3iGC8zMdz6lWZp7e6Cmt3blmdWTf+SX/2Lo32FGDBJrPyTj/09sI/hT3HXT6JRzzGG+0cLCUrC8YBv0Bn2PVrkmiDWTm3ZjnhUm3G9RM5toGjwZtIvQ8fdojMaxn+iJVvdFZFTj2Xs+K5kq64kGDQAjqapsVcMZNhoNVZxozzvmj0udxRFEDSuYdiCDDpMoTaR5fMs7GL9slTo1mMPTr33ym0pXYxlh4zmQknl1Y84JeQrZzwAX7c4zaNjaOQgitzG86TVao70pAo/ludmgW3+wtoBiCNol/k1rPcoiu/Ss3C6zgXPGVnwDBwCLXInicfD3l33Qndy6m6a8fJ3wHOcFr5JTAH8cGsH9zB7NJXcFJgyPBEATfvKAUjkip2YgbxEJG1ioo1snMo9sksJg6K0VsuBowdvgkFVzlX4MyHW3e3W4C2AgejqTgDECdzFM6xKcTYijG3yY8STTiCvQAXQwXGWxU1p4MBZv3A7+DFsEMxpUpomdghMbqfmzR4YuIKFVQLZu5n8mHGPuS92vYPARW5bIpZzeLMRwKI+Ba7OE+BQrynR5xMvPxJ95bW+q1c0FF67y4L2qoWyg6CzX08/Ul+626n/ckJfbup0N+ip5/f4Sd7xYVQCwesEh4sziJ8BK3VjfsykCKiEjoiSUl1tJ/Lz8ngsxUh0hzm84d66xChrHb4JIwjIxGRhus6x/aMn32cctYieI/Bqcr9b2KnwdMA+qSMBeONDxLQxkBG5LYNqNQRuMD9aE9chk5CDQ8ZSC0nz4OPfNgOXqphkJM/TIQe8HVvoVHshvsf162wZIE1Htzj3nP/QKMn8+hib66xbnlmtF8I6kFtJ7CkieDgmYBeJ+GZw2OyQeIJnr1Etbxr3OmhErS5RnvYTXG6E6nn6yJocFKxdcsZ1FBSDU2ryAlxM0TgSmTWRQYVmb14jSp18PFjU0pVeQUs+gwzL+cY+g/G/Jv7QllwhW46fwl6s5i4cV+HJ7xkdcNbQq3U4U3M8TyMfBrgDTXr/VVmABOzxqlGH/bQ48kH4YF2/eXDQcPFn4o2g5CCwCpJVwoyymyQrj/+HrHsiojkdWVzS7h0i517TI0SKAnYS6NO7ZYpK8j4qoAt8jWGdau5moHWt9C00V3PMGTy8UHqN6OXCP0X+VHGSl7SFpK4Cp4iSBz0pxGiFrBQhV7n/uzV8AMxsnsfhCA8Nn0p5KuFgSYuASdL618LHuKTiwIBW1ijas1K+1ugxzqYORi56aSTNfexLGy8edmrCEUzc3HP9dSxPmJdNtkBcnhJZc2rihglM2uaxP81RyUZZKdJ5oM9OicAhOHnY+auZxrtkDClaE2AGTAH6IvRn97xWAmXDHL0z+MuFKxlzMuTLMBQlvZCEnGfggRxYg/yjAyPLvEUxn1/JMi/0GpgGDotEG66PlaSAu+Z1BsQxIKmaBOpH4Eb9OaSi8v2L7aFg99amIlEwVjCOelilysMpNKehcGFFnBoebny5ijvpyfS2LqDOXEYhwCj6buyOqPeq6YmQwICSj2FBsXvsiQdHtlPn/ASpYgl6bE1Nw0+jVCc63kN/gfVSkHdJ14TI28dV0CJ1RKKxFvid0ZQy4o4KhkMoi+YqsFwvs33K5SBPKffSCuvZ8qmq05bPAy98E0iAUNzJnWtuoPSdPOUdt7IImn5MiXmflc6Mvyb7HfueKMhYvJu8Sk83t1oj/GKFSZ0vK7G9L248/B2TgOw1h9a+BVNCkgAP7IYcuUoKccct4pEIh72xRQLgejPvmxZAFlylB6q6iMlNxnS+Tuim29YdJOxHvxlsK3Rp1BzoGaF6kEjqLK2G3o7UaAlEgvFLAK8EhmLHqyeSpVTL8QHiVHJZi+uq2zJV/QRG7Tza/BKPAtMAYAyGHDVonWENTmoPLYtW/eQEvKooB2onCbWi7WRdYsQEFE2n9OYi/14AzS3EtMpGg6RjjLZOkFhiAbEsfP3HObJssfpQ9A2lHzq8v9na7prMDethPT3QoaKKY7AjzgTDjqJk/51IxjU7/m02NweJlVtUJyeWHM+loxWUXqGvUqOmdwQbcjiyUIDjtNiGEDOXEoV+9ZvSYWrr4dU4rYFpOc+wkugM9P/c7gwoakBu2PDqmrid12hHF3hEsRPiyy8HRoUR9exDWhr/NHHN0qg81xlRwnhayUrX8/XyDj2h0eIOBGnvBggssodF4U5etNLEAX8jaa5G/EsG2mNVIfleRTaP2jNwBI7CeHYUDIp/sjEyL3rzwzwCiGFGXMRbdrtPPrxfqUFqUQ6nPh2Xfq7LLP67cEIJCfVlFBRc1EzHsSIE99Z7AJ2S4DuaOX69k6T+214BNdq43Xzdnuy7T0jQHcZPVm7IA7hyBkjrmBfjKXhTpamwvtrFIPX9a5idMArLPTB5wk7Eqov9jD8WtUkOdSohQBZB4YOAu+ApRMT6kwkg+VK/m1zndB7KbpPIaqjtBNzBWI7uTS5qcvvkb8lN0rzqgkUDWMm+RtEj1Ts8vpsDuPnjrpEcQGENm1QxZQFsI34DZAjz8+RlYdlhoDX50NiqhCv5B5GINX2fJTB8baZsfmeFUv5Bybrvc7GmFGeWReUNyojVIU8QDpxjr5W/Nv36sQF+MBT+61sVuevL8p+KlTOjZvfF49SYGIZFderpKT+PYkcMt04/u7fLYMFPwgz53higK6PRVxP5txbfxA/R25u3U3XNosJGHLyb865LfdeRom1IlJt5ihRHJpimBKPDuxkW8QAU80YaxjakFRHLMh5qonY3Osb0fPBAy9fsxCRxv4GKfwjgVIHz7ERJJMv5BfNgNRxRPfp8UT39Tv+wxITZ2N0I8KEBW1ARO1jcwE1ijDM0v5FTJgTmbqA8fdlfRIxcMcilj97lqUf6xds273ZJ5sjSa4fRuWo0GBweTWBavKD3kQ+no3Ztbj7HtU6pVf0jPWUvopndU2s9GF1PIiiSChg4SKOJqCbKcrSFc+Rc+bgMbnYNqM7AGsULGaD58vwwF3t0c+3lpMticcLvVnb4a3N4DmTfEqvi+YwsSrgFEA+iK7iD1kUOWtQaSibKSEEQvMRE2yYaz/I9kVtfnW3V0XTx7xesDbrdmXNW5wPXVIsNJTk3oSpRQFSO5ch6CQBDRPdUvpDYd1nPR/mkgeGNi8slvDkaEcpEzpG7+1BLICtE/1rbds0jqfxAdRpzclF1rbFfVyuOAYjQZnzT+WbSRwOx4XL/3viB3UPTlo70/XVe7LHt3ENaAxSDb3V2/lubdgYQkBfE9OkD73Pf0txxhAYzlUB8L7Tm4FJULOBWVWY3B8zhsBcfQcTBcDEn8zPutcN4yxlUos9FZ4t7sI6I05B3BbqA51fQS5c7KcG05MIwhMCIJwR1fVnbI1KT/UdSEGTMYoW3UEoTu7You26aXdFRIOgPpNWNyA1Nn4XJw0+2gxRYfVO+oqw1dF3bNsP3KJxWJb76qv7XhPkqXeG7mYZ5U1/kq6z+SUNlOloU67yMOw2jw2RFQDaFJ8r9EiH7TIljIZvrvbAOFp/fPXaqOxQg9C5+hBT345Or9KR8rbo1UDiX6cCh3UAxHp/JgXPnoJ8XayvOitze57/mmbbuzMK4o3TQMeNGGiMZQeJfrlOWio3kWncObsdf/11HamlAsq8lRItXMnn/H0R3OCSQakXgks0WrvB1CMQgi5kxhGHbHxagAeK3DyYqEtcVvapYfggcp1MuvIPqx16Kj7PSh2Hosdicgti/HNZf9/J6PIFA5YQGO4UvAiFp0uZQMsQ6Ix1Yd5DFEABmGcyrpk9gPxCgO8BfofOM9haOJccU57vmJbj2imjLZOBiOHjY6MvRq4Sg9nbem4rZJAlEbLeFKoBzIL5fwxmOVjfLDXJ6W1n3vGglIZBGXKGUOoo66DZ9Ivy3VMNm7unuc6JQgero4tADneaxZzQ4UIEQgXyLsYiLTDEZOxSLR30owdjHlLMHgBTfBeU39QnnJEqIJjeuBIRt5nALzaSsT9s1PaYj1y7FxHEKBTmtoYUIivGQNXShPCkPtQkLw09dBhHISmdWfcXOswSef6HGeB71yDSAUd/xo629rBtKjl+UkM6nSDP3yBcHXJ6j/Ow16svhrL14LgNjkNgUPsnkPwoc7VjXhErUWVHTdcnFWZXQ9RKdtAzlhf8pFx/LfkK7kGmMc5J3aGmNaBvLlndE2DT4icFFbxNYpILYQElzxdFXdxEQZm4yHOPBJujqRd/Sq/DUBeDjBA+JUqIU423et5BnrGbE5PZXCcaYJj/FwNzitl0k02jvS9gjSSFjIgCc4kM7CdcSMx5ZtcZhUDaY93w+WHkX7dIgP/u8nmVVhagY62f8ISbAOyNUnkGJIPzowHEoPQ7EBGCpbYBueFCZZ/cq1I74ttfOlt2C7Js6TutopxECJo2OEvk+XEBBs7CRwYx4YWnWjD0Ma+Tim2YNYU4VOA2fH9OW+22RM4KYYRG6kWhAVSxneRQCHR+i4jWG7hXathsZ/MTaCbVvO5seZrDvRpjGhYCr746j/Mql58x7/YnJGDKSZJzmPvi3zWikRL3mPUZRSqHZKCYybBxFtW5qncGfLa5ik6xT86Ph/9Kn5OiRcmIPAuqaWelzCXV87OoBN6mTTE2KKWoCpQ2l9qJ3+xk6KUs+0JKD/rnfqv+gdQlcD7Nzwdl8QncNbXXIySgu2nR4FF8tjroYMgG5tLmZxM7hF3GshJR9QLTy6NlTDw6oPc8ZJyAf1F/fLqjOnDh7OBQDEhTc6JTKmg4+QcQr0xnQQEOJ69QqTtHnL/IckqBE4MIF5orjKpa2FiSK21tJaVyYznpfjF4R1dDfnfZSJCRFCe499HNMz+m4qMhYU9y3koc1DX5zUsGu6oudmxP/ylzB5x+SPx/VhBS11dYLvOgALRkoINdUEBr6WwFKInDXZ9wdwC7fI/1zHq/iosqEp9MJKGom2WB0KXbjTKJcOkclL8MBqjVbSikidkE7wozYNIw0LAvubbgLuO34kdC14AQYupGykaFXb+VdJbtrqfe08NWkB9ak2fIisjjRH+gLTz8F3kVVD0o9uqN6dfrGxRrsCBUJLr8YTAykyyy+i5TV/bWTofnBMR/a6K7spvqLrrGKdNwgbYB118CJeraIYFC/TsaIHI+1IGfNTZxFlo+dQSXNuClIdoDxMQOpDSKPSl5L7R49PC8W8Mi6m/BgHwwDa2V27SaoaXDXBMCg7oO55GFk2kKViYIkI15DoL28hEcyEBrLTiVyf1LEq93exjM3RAMYDwtZND4PiA6UlH3aY13Sluf0YN/EfmhoJzIDtZvm23KVIoHTP5tWKl6xMTGw8zVEufxlCLGNfNZUVXKA6h6yWPqNZCkj8pUfhbtLQZPILj1kYH9qoY9lFvLSaSBT7Ws3BmzQB/r7sVzdsIM7P925gjEmNyOZ3Y0oHizFdxxJOeGrxAUX0NHg3e2jgvc2ceZszU0YHrFaRoYcZcIUDOefJq6EEeH3o939Iflq5NtWwr9Ot6H4t66G+jeo+viNjWjTqlpsEkL5CmBuVbOTT4n2QXnTOmUuR3QhCbp0rmgOl7kPUCoOEjhKXsEHGNfx73HzhWPHHhdkeV7dnO0xzUxZF5RolGwEjInE9BRhh2TsIuSSjyhW/psVFo7mylmJcf1qIeXBJu8usWlgzT4B2xvzfP2wA+ylrCL1/V4MF37UdFKmd4TbZJ6h7KGnoqlgWcu0lVcc234PgsVSbdytRaMuJwa7cz7vzCfxpmuEn3tR0SdhBNNcqefBbU+8Xxb7nPluB6bVvDj1AFlKk6rYp03A/QszW3uW9v/mzuyXlCXe9nurFWt0jO8K5KqfIWceULIsJ423eSABwtZGb04HiEi1JEzyUP+ko9kNLYjlinbnGneFYf+xnyvaK3kuBwAXuJewi6N3CP98fqW4v8uNUtSqu7MMkEgvf2irj1gE6ktbakgGj9/6G+qxa21rj8utNU+dzlfegsIEztRrg3xcP5xovkg3QEoM4P4R4pK17JQ9q0E4oHmNlDjeSGhIodS9vxY3fjI40KLk3KSH0pSjtikgsb1VgViDTEZfXKMOLge65aPObgh5056su2Me/m1xpYFCgC30k1GsrpBCVcGx7Ai8RMUHcuJBk37LS5hYgAELFJzUDYKbGCH+8HH2nkg/nD+laIUJSIwg8G4c+4PfBF8ViqbKf6991rGVHtBDmJCczZhcSeyULVG8MLJV7e/AC2mW6tLXNBqBE9HPJwE46zY77haajQS48oZYuT+NQpuZR8rO2iQyRGZ5RmVpVxYHHQ7KuEh90vm2eCg89HCpUgRHAz6kM5XelFjb5ushlKH/7k+y9G7Q7a1nfPPlizDzvIIbmi3mcpAY6g4YJzcY751cml2gnBG28T0dagjZpac7Bdl+7SMvbOAV/xZAq8HaHeHJYjQwxLnoJydJQjZixMyUSjvzzVC8iG5l81Dfq+fjC7EH3oosRwZzUP8yp3FPtHnaMrUD9cA3mgsviiZxLIDDCWQHjj1LaxnpsJ0hze+aXh0Z1vqaPsdRlD39HFEiPBYOUf2p8SuaGcKEQ7CDYdkpxYRq8+etGCTCfA9qkS5PoTLp1cJ7X4leiAta+SWC8cTiMp47DD/Z42/pB2+Wfe1zWKxqaFzTrSvDRHaRgsJT5qnnCZImFlGUcFrFwbbz6v7pOmNg1XVhDIC08ALtYG3cUX1yOVLADPlO+ntsnN2+R4dNS1gD5xX08rT8BYslFUHObjq+rbtGTTJfXXwen6bgg0uVBP7Qc40dm5mPmVtfMg2nFNMN3+qrQ+TDqmA+wMpRZsXzziD59abkbCE66vJOUnKykJWzK53xL8hWLyE/CGqggHRliAcgdzUoTwK9j+gmGr4X+B2OEmG/oP8gvrlDE7A/RSm33OyVsgGr3YmLjRocdqdIqIRGpLVmMYtiS4LQH1HwUOmSzYFpB/t1ck6wo9DvzV8kXP8r+IRJ2FAO0uwg55vBMw2/VLswTBT0vUt8ps49IZfld/JiusKPbdwl5fQHtQyLojaVdGBUzgYU3cB83dQEXLSJdQDzXCh0+lq4URghtjcC7LclTShi6Z5SvrvI5Q5CKfTYNuuRLXukU7UQSv6RfhwcsQkJyvgaM62eltIqvx/g59Vvsge3IpZ1lBLqESHqtfWEKI0cTq5lWaDywojJQ51M6FP7o+gEhqs3bOOg6Oqf5BA1ze2cOGTtkhpatlr5A6FnkCMVpPLS0x8cHvRHx7qkcPrJI/t3lwhZDpp67n74z8p/t2LbUq4yvc8bDGN6cSTQOMeMz5u/EmZPVK2kO6KUZjk5pCd1c0tkVSEg/lbKpGObJxco04L3aq/rvTAXSKsLAHrLrhxZTZqw5y2F2xzhJVl2R3Li7VwB52z+3RxZyGFiZsaxdQHYCE+TTo4DFbtfhyIsuAwahI2oUqPUOobqjm6shKen0mWLZbSYWfC0YiCli44Pc8J3yKK6Oycm85pFJOMU0w8DQbTUlQf+zjnU7QBj7/9FDnd3aZlCrNnpsGI48npOjimQOVtkdUTcLwgHlU8GtyL4PdYN/AW8g4EudfyFNa0ycQXXYEVpGuk7XOAIVGjeVsAXLWZghGG2o1+Qib7la+QIqw9191GzZ3T6hknHGR2LQ18wr5q+uFBFlbGmAu1swa4RUSPQ273nW5Jnv6ssFOaoXAIWTb2WuoTdMOo0uS8/k7pwbceGxcTzmWXORGhZ36zoOV3hnTWSilyFtTgJGiV5s6II6YhfAL2nJMhmuC9CSvRf2oPqe+fXoW7tM6aatvr4kLWlWzfpG5aphqsResFV6G77huvMNpx/J6SyJnX52OZHI+ybi/wXR6diri36hbVkZGeQvSV+PamH3AwO8zcVa8lFlQEAOa26cS+UP8rLMy90dXWy2JSA+5XyVn3NfPklc7FoSOZ3Zt68C/UUJ/kJ7EdhIOtIzMrVTpciLPSnK6mi5epQbG01hR24ThW7nspDxNv2j5jg9xQSvbv80hZ+Bcd+BaK1ib5tU75w4oDuQ4lHzSewZ3q4wwBZ/78D6BRw8PW/3eJt7uvJ8lwtHo1l3opwE1LQ26+eWGpuMdaTU7kHKKA/o88x9j0RhfeK8v7BRUb50sCsz5k1GqMWxhHjr0PUXtlUG2pPhUw8PxQSEC5ERmPWk7d/TWDRxqu5M1/RZt9KDd+ggn9R1vQhGVao6SkyuRWrAkhegmMwUJeFr8/7LUdmekhCSky6yaSd5B2wnM/o4ycwqBSjnmuo2s1256+cc+IWDlZYeLABaEI4qxjhhJb9//MYjctl9y3vh53OPbNS4164SUAqA85cMFYaZqoPiHpKr2xnLAmitGSBIFoOxOkPShWqyY8b5im7bfFypRM9h7NXb6rnDVqD/Q6+HLUQpIJoxDEz9tvc+Aj1+nu2DPw1YsoGxBgDbeZDj0rG0jhIaw0sLOpGO44lCkwEyV9RtiZkU5m/gTE0HJzkpJm3YXGUINdQCk/AuhaK5u0KlLqWKisOt5PkNr3kqcNaKun2rbopT3XKAylKyr6mi9vzI66jRP1X751suEGkpQImn3LokpQTiQUNThMCA3W6m47yxP7D3jNKaza6vrM0Ls6fJ7PNeChftLL9y3Hy2Q3JkV9GDad4Jzr+PHv9KHo1TBCtI7AAuNsQRXU4A7WEHNpO8ArCWTislxtTIMWAFGtevdSbaJTg6hcgMh4Lj+pxE7gJcUYxR+pKS9Tnd4+gcUruXt3r9JGqvoeb6n9hA+KpdMgj432+C9PZ/HtsRaRxSbODihTHPPyLlcAMMHHuR8rjaN9sfZOeT6hdsRR0olXcSQ6DxtMO36+UCFP0ZwEuWehnjQ66ZmH3cvW1AHraUlBpk8EdUM9MDY66814crJ4pemo+zYTBmiaxaxQtjXHVT7q+AxA7NL2B4xKKLwEh426D7B2MeUpFOQ15tDXn8fIZ9LsyZ/FoliAXd7MyUXigZrw2HZ6knd55vYXPthx6SpFbhSw9CO2G1Z7wqWEHm+bTBZIXx2lmf1jz+9Jv5zqMQf2+qusTd9B7NVQA3ppeSdRy3B6C/MugczojsyKA97WRmQkH+VblXxAXsd7/lqv6Pc4O29/XE3i4qYgtKLwN0crSTmg4Nzr9+lJo9fkImkGGjgylf7WJENYRsyXmAuwtGWuNw49s3V4s9QMLcrdrXanL7N3wI/tpslGLm677NUVIvnBKrZBqQH6HWi+O0X7TPVipyITjCmPfG3QjDQ2Ze0EpUYow0p8hFC3J60OhArxJsw9HbUAcVlChmsleCehe/BMbTKfqF4DbmtVHqLsKzrh8jhC4pOrXzi8g/b+j884gcijfcCiD43tDYXm6SPFg81W4NLW5Nxnu2SSGqRsggouTYlKSEmdHz5MJgi+m80NuM9l465lhZ+lN2T5XPsWW0mV5i3PmQQhzJXHkV/Bbu/jeVe6VjJky1okFBHIG3utmcfU7iRgB2bi9ot2dcyIaro3EH79fC2rfnRjD+xe/LLLo9ghss2Vw8pxoYBMmk1kXFBVKe9aeZ6aKBeafs0dV80jE2LHafzave7dQ7k5CrF55jfhnuQsg7Bu6xzMeZpH9uqpbI/bfVjVGlf7GMWS5iuUbfNSnki7ztuwsKzqyRsm7nVYf4ZskNa7+gMswv1g6V0bWlNh2FLP+q6HFqA7Pj4oqFfMQQ3jxuZ2L5U9eI5iSSEMCX2YKcOTrxLupsH/tEh21YPTfaDF58lKlKHsWIDy97KuYiLMmxDMQnlKei3f1w7o2f1mV7nFGNS3LeKJUCOv+uBsIeqQSNpM+mrxM4fyRitGZMDhWpigaTu8YD5TxMPZf4Dve4aGOFxxSvi2SCbAtJcUol4f0q9ia+nKil6jmevDgB0jTajVEOQ7Wtta6W3iUkR+gsW6h6PdKYeXtTomVd8nekM6PmbKfe4ABRMkQoZEA9SaqA23NT5BIJzI4Asu5H7gRBT/Hpruvkkf6woRA+aui20SVZu8SVWmeOchUB1AM3Ka+e8Ns2eJ65+np/50OEMilAcajkQQ1UVMyWfDtRJ86F7lQvGFDmXzoXQ/JNXX1Mmc23hS/pGXpUZyPNrHTH7eeiM3bd9CaoKqsNkDPs7AHgRHu17+Wnee9AlK8iFsIfd5moJelz4ZtMWsGpivN8IhuQHu6TN2ZlnaRogIW3avRKi+sUT31X1mjCkC+llszcIHZGohlZL0XQ61RoFx1ELQkbphmiGhPU3w7saiA411eVwXw0vMOqH/gqW3p5lPw5/tguk2CiY6xjCud5whKqoYcykRsQr6sOdcCvr1ObCqZHC1VC2UeUG3UYOMVfxdsOoIKdG3Iaq4S00bdvgvgWllYtVPjRTxjn8PU4uaZ4u8Psie7MMbGjkQ0D0lWGZU+hQqenUa3dnt2ife1s9TBJRTE7UKk8hrIJ/4WIdCnhqkUivMeJQjNIHZ20WT1+6VMXlr1pVhN0HkpZT9WBxVCzqOJfum2ruUaHBW35ijbF9EJWChooy/vIU9Dwoj6u+VCIiZx1k/wLaZZQK9jspOlnqwAMCbw6MnVhrtz4CL0a52TBkvhwjdoLrIKL5Y0gfw78H3p4BohpAfCh64SClYN0cDQCw7vJwcSlsSrrTCympOtNv2jxE+oL+r03daWXLqzIi3ot+oYBjmEjBtwTBa8ehP5aP4I67ZWadmMxwbxalvnKywDT8Z1qy4ANk4LPVm5U6tVNJ9qIne3cEnvtcCAkHqA/EiSntYBdT3QAA";
        }
        // For any other pet type not listed above, it will use the default image

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
