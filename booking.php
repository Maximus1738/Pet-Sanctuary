<?php
// booking.php

session_start();


$servername = "localhost";
$dbuser = "root";
$password = "";
$dbname = "pet_sanctuary";

// Central mysqli connection
$conn = new mysqli($servername, $dbuser, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Helper: flash messages
function flash($key, $default = '') {
    if (!empty($_SESSION[$key])) {
        $val = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $val;
    }
    return $default;
}




$customerId = $_SESSION['Customer_Id'] ?? $_SESSION['customer_id'] ?? '';
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';


$available_pets = [];
$exotic_pets = [];

try {
    // Fetch regular pets that are available for booking (status = 'processed')
    $stmt = $conn->prepare("SELECT Pet_ID, Pet_Name, Pet_type FROM pets WHERE status = 'processed' ORDER BY Pet_Name");
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $available_pets[] = $row;
    }
    $stmt->close();
    
    // Fetch exotic pets for adoption
    $stmt = $conn->prepare("SELECT Pet_ID, Pet_Name, Pet_type FROM exotic ORDER BY Pet_Name");
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $exotic_pets[] = $row;
    }
    $stmt->close();
} catch (Exception $e) {
    $_SESSION['flash_error'] = 'Could not retrieve list of pets.';
    header('Location: homepage.php');
    exit();
}


if ($isPost && isset($_POST['action'])) {
    if ($_POST['action'] === 'submit_booking') {
        $petId = $_POST['pet_id'];
        $bookingTime = $_POST['booking_time'];
        $bookingDate = $_POST['booking_date'];
        $groupSize = intval($_POST['group_size']);
        $bookingType = $_POST['booking_type']; // 'visit' or 'adoption'

        // Generate a simple unique Booking_ID
        $bookingId = 'BK-' . rand(1000, 9999);
        
        // Determine which table to get pet info from
        $petTable = ($bookingType === 'adoption' && strpos($petId, 'EX-') === 0) ? 'exotic' : 'pets';
        
        // Fetch the pet name
        $stmt_name = $conn->prepare("SELECT Pet_Name FROM $petTable WHERE Pet_ID = ?");
        $stmt_name->bind_param("s", $petId);
        $stmt_name->execute();
        $pet_data = $stmt_name->get_result()->fetch_assoc();
        $petName = $pet_data['Pet_Name'] ?? 'Selected Pet';
        $stmt_name->close();

        try {
            $stmt = $conn->prepare("INSERT INTO booking (Booking_ID, Booking_Time, Booking_Date, Group_size, Customer_Id, Pet_ID) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiss", $bookingId, $bookingTime, $bookingDate, $groupSize, $customerId, $petId);
            $stmt->execute();
            $stmt->close();

            $actionType = ($bookingType === 'adoption') ? 'Adoption inquiry' : 'Booking';
            $_SESSION['flash_success'] = "$actionType for **" . htmlspecialchars($petName) . "** on **$bookingDate** at **$bookingTime** confirmed! Booking ID: **$bookingId**";
            header('Location: homepage.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Booking failed. Error: ' . $e->getMessage();
            header('Location: booking.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Visit or Adoption</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Shared Styles */
        :root { --forest-green: #2d5a27; --light-green: #4a7c59; --tan: #d2b48c; --light-tan: #f5f1e8; --white: #ffffff; }
        *{box-sizing:border-box;margin:0;padding:0;font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif}
        body{background:var(--light-tan);color:#222;min-height:100vh;display:flex;flex-direction:column}
        .container{width:90%;max-width:1200px;margin:0 auto}
        header{background:var(--forest-green);color:var(--white);padding:1rem 0}
        .header-content{display:flex;justify-content:space-between;align-items:center}
        nav ul{display:flex;list-style:none}
        nav ul li{margin-left:1rem}
        nav a{color:var(--white);text-decoration:none}
        .logo{font-size:1.8rem;font-weight:bold;display:flex;align-items:center;}
        .section{padding:3rem 0; flex-grow: 1;}
        .form-container { background-color: var(--white); border-radius: 8px; padding: 2rem; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-control,input[type=text],textarea,select{width:100%;padding:.8rem;border:1px solid #ddd;border-radius:6px; font-size: 1rem;}
        .form-row{display:flex;gap:1rem; margin-top: 1rem;}
        .form-half{flex:1}
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: var(--forest-green); }
        .btn{display:inline-block;padding:.8rem 1.5rem;border-radius:6px;border:none;cursor:pointer; font-weight: bold; transition: background-color 0.3s;}
        .btn-primary{background:var(--forest-green);color:#fff; width: 100%; margin-top: 1.5rem;}
        .btn-primary:hover{background: var(--light-green);}
        .btn-secondary{background:var(--tan);color:var(--forest-green); margin-right: 1rem;}
        .btn-secondary:hover{background: #e0c9a6;}
        .success-message{background:#d4edda;color:#155724;padding:1rem;margin-bottom:1rem;border-left:4px solid #0a0}
        .error-message{background:#f8d7da;color:#721c24;padding:1rem;margin-bottom:1rem;border-left:4px solid #a00}
        .section-title { text-align: center; margin-bottom: 2rem; color: var(--forest-green); }
        .tab-container { display: flex; border-bottom: 2px solid #ddd; margin-bottom: 2rem; }
        .tab { padding: 1rem 2rem; cursor: pointer; background: none; border: none; font-size: 1rem; color: #666; }
        .tab.active { color: var(--forest-green); border-bottom: 3px solid var(--forest-green); font-weight: bold; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .info-note { background-color: #e8f4f8; border-left: 4px solid #3498db; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px; }
        .info-note i { color: #3498db; margin-right: 0.5rem; }
        footer{background:var(--forest-green);color:var(--white);padding:2rem 0;margin-top:auto}
        
        /* Confirmation Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
        
        .modal-title {
            color: var(--forest-green);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .modal-message {
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .booking-details {
            background-color: var(--light-tan);
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        .booking-detail {
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
        }
        
        .booking-detail strong {
            color: var(--forest-green);
        }
        
        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        .modal.show {
            display: flex;
        }
        
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
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
                    <li><a href="adopt.php">Adopt</a></li>
                    
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li><a href="add_pet.php">Add Pet</a></li>
                        <li><a href="booking.php">Booking</a></li>
                        <li><a href="logout.php">Logout (<?php echo $_SESSION['first_name'] ?? 'User'; ?>)</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                    
                </ul>
            </nav>
        </div>
    </div>
</header>

<main class="container">
    <?php if ($msg = flash('flash_error')): ?>
        <div class="error-message"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if ($msg = flash('flash_success')): ?>
        <div class="success-message"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <section class="section">
        <h2 class="section-title">Schedule an Appointment</h2>
        
        <div class="tab-container">
            <button class="tab active" data-tab="visit">Visit a Pet</button>
            <button class="tab" data-tab="adoption">Book an Exotic Pet</button>
        </div>
        
        <!-- Visit Tab -->
        <div id="visit-tab" class="tab-content active">
            <div class="form-container">
                <h3>Book a Visit with Our Pets</h3>
                <div class="info-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Schedule a visit to meet and interact with our available pets before making any adoption decisions.</span>
                </div>
                
                <form method="POST" id="visitForm">
                    <input type="hidden" name="action" value="submit_booking">
                    <input type="hidden" name="booking_type" value="visit">
                    
                    <div class="form-group">
                        <label for="visit_pet_id">Select Pet to Visit</label>
                        <select id="visit_pet_id" name="pet_id" class="form-control" required>
                            <option value="">-- Choose a Pet to Visit --</option>
                            <?php foreach ($available_pets as $pet): ?>
                                <option value="<?= htmlspecialchars($pet['Pet_ID']) ?>">
                                    <?= htmlspecialchars($pet['Pet_Name']) ?> (<?= htmlspecialchars($pet['Pet_type']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-half form-group">
                            <label for="visit_booking_date">Preferred Date</label>
                            <input type="date" id="visit_booking_date" name="booking_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="form-half form-group">
                            <label for="visit_booking_time">Preferred Time</label>
                            <input type="time" id="visit_booking_time" name="booking_time" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1rem;">
                        <label for="visit_group_size">Group Size (Number of People)</label>
                        <input type="number" id="visit_group_size" name="group_size" class="form-control" required min="1" value="1">
                    </div>

                    <button type="button" class="btn btn-primary" id="confirmVisitBtn">Confirm Visit Booking</button>
                </form>
            </div>
        </div>
        
        <!-- Adoption Tab -->
        <div id="adoption-tab" class="tab-content">
            <div class="form-container">
                <h3>Schedule an Exotic Pet Booking</h3>
                <div class="info-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Our exotic pets require special care and handling. There are safety prosedures in place to ensure wellbeing.</span>
                </div>
                
                <form method="POST" id="adoptionForm">
                    <input type="hidden" name="action" value="submit_booking">
                    <input type="hidden" name="booking_type" value="adoption">
                    
                    <div class="form-group">
                        <label for="adoption_pet_id">Select Exotic Pet for Booking</label>
                        <select id="adoption_pet_id" name="pet_id" class="form-control" required>
                            <option value="">-- Choose an Exotic Pet --</option>
                            <?php foreach ($exotic_pets as $pet): ?>
                                <option value="<?= htmlspecialchars($pet['Pet_ID']) ?>">
                                    <?= htmlspecialchars($pet['Pet_Name']) ?> (<?= htmlspecialchars($pet['Pet_type']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-half form-group">
                            <label for="adoption_booking_date">Preferred Date</label>
                            <input type="date" id="adoption_booking_date" name="booking_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="form-half form-group">
                            <label for="adoption_booking_time">Preferred Time</label>
                            <input type="time" id="adoption_booking_time" name="booking_time" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1rem;">
                        <label for="adoption_group_size">Number of Attendees</label>
                        <input type="number" id="adoption_group_size" name="group_size" class="form-control" required min="1" value="1">
                    </div>

                    <button type="button" class="btn btn-primary" id="confirmAdoptionBtn">Schedule Adoption Meeting</button>
                </form>
            </div>
        </div>
    </section>

</main>

<!-- Confirmation Modal -->
<div class="modal" id="confirmationModal">
    <div class="modal-content">
        <h2 class="modal-title" id="modalTitle">Confirm Your Booking</h2>
        <div class="modal-message">
            <p id="modalMessage">Please review your booking details before confirming:</p>
        </div>
        
        <div class="booking-details" id="bookingDetails">
            <!-- Booking details will be populated here by JavaScript -->
        </div>
        
        <div class="modal-buttons">
            <button type="button" class="btn btn-secondary" id="cancelBookingBtn">Cancel</button>
            <button type="button" class="btn btn-primary" id="finalConfirmBtn">Confirm Booking</button>
        </div>
    </div>
</div>

<footer>
    <div class="container" style="text-align:center;padding:1rem 0">
        <small>&copy; <?= date('Y') ?> Forest Pet Sanctuary</small>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('DOMContentLoaded', function() {
    // Check for tab parameter in URL and switch to appropriate tab
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    
    if (tabParam === 'adoption') {
        // Switch to adoption tab
        document.querySelector('[data-tab="visit"]').classList.remove('active');
        document.querySelector('[data-tab="adoption"]').classList.add('active');
        document.getElementById('visit-tab').classList.remove('active');
        document.getElementById('adoption-tab').classList.add('active');
    } else if (tabParam === 'visit') {
        // Switch to visit tab (default, but explicit)
        document.querySelector('[data-tab="visit"]').classList.add('active');
        document.querySelector('[data-tab="adoption"]').classList.remove('active');
        document.getElementById('visit-tab').classList.add('active');
        document.getElementById('adoption-tab').classList.remove('active');
    }
    
    // Rest of your existing JavaScript code...
    const tabs = document.querySelectorAll('.tab');
    // ... rest of your code
});
    // Tab functionality
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Update active tab
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Show active content
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === `${tabId}-tab`) {
                    content.classList.add('active');
                }
            });
        });
    });
    
    // Modal functionality
    const confirmationModal = document.getElementById('confirmationModal');
    const cancelBookingBtn = document.getElementById('cancelBookingBtn');
    const finalConfirmBtn = document.getElementById('finalConfirmBtn');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    
    // Get pet name from selected option
    function getSelectedPetName(selectId) {
        const petSelect = document.getElementById(selectId);
        const selectedOption = petSelect.options[petSelect.selectedIndex];
        return selectedOption.textContent || 'Unknown Pet';
    }
    
    // Format time for display
    function formatTime(timeString) {
        if (!timeString) return 'Not specified';
        const [hours, minutes] = timeString.split(':');
        const hour = parseInt(hours);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const displayHour = hour % 12 || 12;
        return `${displayHour}:${minutes} ${ampm}`;
    }
    
    // Format date for display
    function formatDate(dateString) {
        if (!dateString) return 'Not specified';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
    }
    
    // Handle visit booking confirmation
    document.getElementById('confirmVisitBtn').addEventListener('click', function() {
        const form = document.getElementById('visitForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        showConfirmationModal('visit');
    });
    
    // Handle adoption booking confirmation
    document.getElementById('confirmAdoptionBtn').addEventListener('click', function() {
        const form = document.getElementById('adoptionForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        showConfirmationModal('adoption');
    });
    
    // Show confirmation modal
    function showConfirmationModal(type) {
        const isAdoption = type === 'adoption';
        const prefix = isAdoption ? 'adoption' : 'visit';
        
        // Get form values
        const petName = getSelectedPetName(`${prefix}_pet_id`);
        const bookingDate = document.getElementById(`${prefix}_booking_date`).value;
        const bookingTime = document.getElementById(`${prefix}_booking_time`).value;
        const groupSize = document.getElementById(`${prefix}_group_size`).value;
        
        // Set modal title and message
        modalTitle.textContent = isAdoption ? 'Confirm Adoption Meeting' : 'Confirm Your Visit Booking';
        modalMessage.textContent = isAdoption 
            ? 'Please review your adoption meeting details before confirming:' 
            : 'Please review your booking details before confirming:';
        
        // Populate booking details
        document.getElementById('bookingDetails').innerHTML = `
            <div class="booking-detail">
                <strong>Type:</strong> <span>${isAdoption ? 'Adoption Meeting' : 'Pet Visit'}</span>
            </div>
            <div class="booking-detail">
                <strong>Pet:</strong> <span>${petName}</span>
            </div>
            <div class="booking-detail">
                <strong>Date:</strong> <span>${formatDate(bookingDate)}</span>
            </div>
            <div class="booking-detail">
                <strong>Time:</strong> <span>${formatTime(bookingTime)}</span>
            </div>
            <div class="booking-detail">
                <strong>${isAdoption ? 'Attendees:' : 'Group Size:'}</strong> <span>${groupSize} person${groupSize > 1 ? 's' : ''}</span>
            </div>
        `;
        
        // Set up final confirmation
        finalConfirmBtn.onclick = function() {
            finalConfirmBtn.disabled = true;
            finalConfirmBtn.textContent = 'Processing...';
            const activeForm = isAdoption ? document.getElementById('adoptionForm') : document.getElementById('visitForm');
            activeForm.classList.add('loading');
            activeForm.submit();
        };
        
        // Show modal
        confirmationModal.classList.add('show');
    }
    
    // Cancel booking
    cancelBookingBtn.addEventListener('click', function() {
        confirmationModal.classList.remove('show');
        // Reset confirm button state
        finalConfirmBtn.disabled = false;
        finalConfirmBtn.textContent = 'Confirm Booking';
    });
    
    // Close modal when clicking outside
    confirmationModal.addEventListener('click', function(e) {
        if (e.target === confirmationModal) {
            confirmationModal.classList.remove('show');
            // Reset confirm button state
            finalConfirmBtn.disabled = false;
            finalConfirmBtn.textContent = 'Confirm Booking';
        }
    });
});
</script>

</body>
</html>