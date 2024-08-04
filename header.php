<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'config.php'; // Include other PHP files or scripts after session_start()

$loggedIn = false;
$email = '';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $loggedIn = true;
    $sql = "SELECT firstname, lastname, email, phone_number, profile_pic FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User not found");
    }

    $stmt->close();
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css"> <!-- Your custom CSS file -->
    <title>Home | Travel</title>
    <div id="top-section" class="bg-primary"></div>
</head>
<body>
<header>
    <nav class="nav-container">
        <div class="nav__logo">Travel</div>
        <ul class="nav__links">
            <li class="link"><a href="index.php">Home</a></li>
            <li class="link"><a href="aboutus.php">About</a></li>
            <li class="link parent">
                <a href="car.php">Cars</a>
                <ul class="sub-menu">
                    <li><a href="hatchback.php">Hatchback</a></li>
                    <li><a href="sedan.php">Sedan</a></li>
                    <li><a href="Suv.php">SUV</a></li>
                    <li><a href="Muv.php">MUV</a></li>
                    <li><a href="coupe.php">Coupe</a></li>
                    <li><a href="electricvechiles.php">Electric vehicle</a></li>
                    <li><a href="trips.php">Trips</a></li>
                </ul>
            </li>
            <li class="link"><a href="Destinations.php">Destinations</a></li>
        </ul>

        <ul class="nav__links">
            <div class="nav-button">
                <button class="btn" data-contact="8309740722">Contact</button>
                <?php if ($loggedIn): ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="link"><a href="admin_panel.php" class="btn">Admin Panel</a></li>
                    <?php endif; ?>
                    <li class="link parent">
                        <?php if (!empty($user['profile_pic']) && $user['profile_pic'] !== 'uploads/default.png'): ?>
                            <button class="btn1">
                                <!-- Display user's profile picture -->
                                <img style="border: 3px solid #007bff; height: 80px; width: 80px;" src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" id="profilePicNav" class="rounded-circle" width="50" height="50">
                                <i class="ri-user-line"></i> <?php echo htmlspecialchars($email); ?>
                            </button>
                        <?php else: ?>
                            <!-- Show a default avatar or placeholder image -->
                            <a href="profile.php" class="btn1">Upload Your Picture 📷<br><?php echo htmlspecialchars($email); ?></a>
                        <?php endif; ?>
                        <ul class="sub-menu">
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="link"><button class="btn" id="openPopup">Login</button></li>
                <?php endif; ?>
            </div>
        </ul>
    </nav>

</header>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script>
    // Example JavaScript for smooth scroll to sections
    $(document).ready(function() {
        $('a[href^="index.php"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
        });
    });
    window.addEventListener('scroll', function() {
        let scrollTop = window.scrollY;
        let docHeight = document.body.scrollHeight - window.innerHeight;
        let scrollPercent = (scrollTop / docHeight) * 100;
        let red1 = (scrollTop % 255);
        let green1 = ((scrollTop + 85) % 255);
        let blue1 = ((scrollTop + 170) % 255);
        let red2 = ((scrollTop + 170) % 255);
        let green2 = ((scrollTop + 255) % 255);
        let blue2 = ((scrollTop + 85) % 255);
        let topSection = document.getElementById('top-section');
        topSection.style.width = scrollPercent + '%';
        topSection.style.background = `linear-gradient(45deg, rgb(${red1}, ${green1}, ${blue1}), rgb(${red2}, ${green2}, ${blue2}))`;
    });
</script>

