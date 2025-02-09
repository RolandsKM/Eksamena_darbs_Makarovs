<?php
session_start();
if (!isset($_SESSION['lietotajvards'])) {
    header("Location: login.php");
    exit();
}

// Default profile image
$profileImage = "../images/user.png";

// Example user statistics (replace with actual database queries)
$userID = $_SESSION['lietotaju_ID'];

// Simulating database queries (replace with actual queries)
$participatedEvents = 5;  // Example: number of events the user has participated in
$createdEvents = 3;       // Example: number of events the user has created
$happyPeople = 20;        // Example: number of people helped by the user

// Simulate some events for "Sludinājumi" and "Vēsture"
$createdEventList = ['Event 1', 'Event 2', 'Event 3'];  // Example: List of events created by the user
$participatedEventList = ['Event A', 'Event B', 'Event C']; // Example: List of events the user has participated in

?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profils</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script>
        // JavaScript to switch between sections dynamically
        function showSection(section) {
            // Hide both sections initially
            document.getElementById('sludinajumi').style.display = 'none';
            document.getElementById('vesture').style.display = 'none';
            
            // Show the clicked section
            document.getElementById(section).style.display = 'block';
            
            // Highlight active button
            const buttons = document.querySelectorAll('.toggle-buttons a');
            buttons.forEach(button => {
                button.classList.remove('active');
            });
            document.getElementById(section + '-button').classList.add('active');
        }
        
        // Initialize to show 'Sludinājumi' by default
        window.onload = function() {
            showSection('sludinajumi');
        };
    </script>
</head>
<body>

<header>
    <a href="./" class="logo"><i class="fa-solid fa-handshake-angle"></i> Brīvprātīgais Centrs</a>
    <div class="header_btn">
        <a class="btn">Par Mums</a>
        <a class="btn">Sludinājumi</a>
        <a class="btn">Kontakti</a>
        <a class="btn">Ziedot</a>

        <!-- Profile Dropdown -->
        <div class="profile-dropdown">
            <button class="btn profile-btn">
                <?php echo htmlspecialchars($_SESSION['lietotajvards']); ?> <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a href="profile.php"><i class="fa-solid fa-user"></i> Profils</a>
                <a href="../logout.php"><i class="fa-solid fa-sign-out-alt"></i> Iziet</a>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const profileBtn = document.querySelector(".profile-btn");
        const dropdownMenu = document.querySelector(".dropdown-menu");

        profileBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle("show");
        });

        document.addEventListener("click", function (event) {
            if (!profileBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove("show");
            }
        });
    });
</script>


<div class="profile-header"></div>

<div class="profile-content">
    <div class="profile-photo">
        <img src="<?php echo $profileImage; ?>" alt="Profila attēls">
    </div>
    <div class="profile-details">
        <h2><?php echo htmlspecialchars($_SESSION['lietotajvards']); ?></h2>
        <p>Lietotāja ID: <?php echo htmlspecialchars($_SESSION['lietotaju_ID']); ?></p>
        <p>E-pasts: lietotajs@example.com</p>
        <p>Pievienošanās datums: 2024-02-08</p>
    </div>

    <!-- Edit Button -->
    <div class="edit-btn-container">
        <button class="btn edit-btn">Rediģēt</button>
    </div>
</div>

<section id="about-user">
    <div class="about-user-stat">
    <i class="fa-solid fa-handshake-angle"></i>
        <h4>Piedalījies</h4>
        <p><?php echo $participatedEvents; ?></p>
    </div>
    <div class="about-user-stat">
    <i class="fa-regular fa-copy"></i>
        <h4>Sludinājumi</h4>
        <p><?php echo $createdEvents; ?></p>
    </div>
    <div class="about-user-stat">
    <i class="fa-regular fa-face-smile-beam"></i>
        <h4>Laimīgi</h4>
        <p><?php echo $happyPeople; ?></p>
    </div>
</section>

<!-- Info Section -->
<section id="info">
    <!-- Buttons to toggle between Sludinājumi and Vēsture -->
    <div class="toggle-buttons">
        <a href="javascript:void(0);" id="sludinajumi-button" class="btn active" onclick="showSection('sludinajumi')">Sludinājumi</a>
        <a href="javascript:void(0);" id="vesture-button" class="btn" onclick="showSection('vesture')">Vēsture</a>
    </div>

    <!-- Content Displayed Based on Active Button -->
    <div class="section-content">
        <!-- Sludinājumi Section -->
        <div id="sludinajumi" style="display: none;">
            <h3>Jūsu Sludinājumi</h3>
            
        </div>

        <!-- Vēsture Section -->
        <div id="vesture" style="display: none;">
            <h3>Vēsture</h3>
          
        </div>
    </div>
</section>

</body>
</html>
