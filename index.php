<!DOCTYPE html>
<html lang="en">
<header>
    <?php include 'header.php'; ?>
</header>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">

<body>
<!-- Main Content -->
<!-- Login Popup -->
<div id="loginPopup" class="popup">
    <div class="popup-content">
        <span class="close" id="closePopup">&times;</span>
        <div class="video-container">
            <video class="popup-video" src="assets/vid-1.mp4" autoplay muted loop></video>
        </div>
        <div class="login-form">
            <h2>Login</h2>
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            echo "Session role: " . (isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : "Not set") . "<br>";

            include 'config.php'; // Include database connection file

            // Handle login form submission
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $password = md5($password); // Hash password for comparison

                $sql = "SELECT * FROM users WHERE email='$username' AND password='$password'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role']; // Assuming 'role' is a column in your users table

                    // Set cookies for session management
                    $cookie_name = "user_session";
                    $cookie_value = session_id();
                    $cookie_expiry = time() + (86400); // 86400 seconds = 1 day
                    setcookie($cookie_name, $cookie_value, $cookie_expiry, "/");

                    if ($_SESSION['role'] == 'admin') {
                        header("Location: admin_panel.php"); // Redirect admins to admin panel
                    } else {
                        header("Location: car.php"); // Redirect regular users to destination page
                    }
                    exit();
                } else {
                    $login_error = "Incorrect Email or Password";
                }
            }

            // Check if user is already logged in via cookie
            if (session_status() == PHP_SESSION_NONE) {
                // Check if the user_session cookie is set
                if (isset($_COOKIE['user_session'])) {
                    // Set the session ID from the cookie before starting the session
                    session_id($_COOKIE['user_session']);
                }

                // Start the session
                session_start();
            } else {
                // Session is already started
            }

            ?>


            <?php if (isset($login_error)) { echo "<p>$login_error</p>"; } ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="username" id="username" placeholder="Username (Email)" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="submit" value="Login">
                <p>Forget password? <a href="#">Click here</a></p>
                <p>Don't have an account? <a href="register.php">Register now</a></p>
            </form>
        </div>
    </div>
</div>

<section class="header__container">
    <div class="header__content">
        <h1 class="section__header text-white">
            Find And Book<br />A Great Experience
        </h1>
    </div>
    <video class="header__video" src="assets/header.mp4" autoplay muted loop></video>
</section>

<section class="section__container booking__container">
    <div class="booking__nav">
        <span onclick="activateForm('formLocalMore20km', this)" class="active" data-form-id="formLocalMore20km">Quick Search</span>
    </div>
    <form id="formLocalMore20km" class="form__group active" method="GET" action="filterpage.php">
        <!-- Form content here -->
        <div class="form__group">
            <span><i class="ri-map-pin-line"></i></span>
            <div class="input__content">
                <div class="input__group">
                    <input type="text" id="location" name="location" class="Location" list="locationOptions" placeholder="Location" />
                    <label>Location</label>
                </div>
                <p>Where are you going?</p>
            </div>
        </div>
        <datalist id="locationOptions"></datalist>
        <div class="form__group">
            <span><i class="ri-user-3-line"></i></span>
            <div class="input__content">
                <div class="input__group">
                    <input type="number" id="travellers" name="travellers" class="Travellers" placeholder="Travellers"  min="1"/>
                    <label>Travellers</label>
                </div>
                <p>Add guests</p>
            </div>
        </div>
        <div class="form__group">
            <span><i class="ri-calendar-line"></i></span>
            <div class="input__content">
                <div class="input__group">
                    <input type="date" id="departure" name="departure" class="date-input" placeholder="Departure" required />
                    <label for="departure">Departure</label>
                </div>
                <p>Add date</p>
            </div>
        </div>
        <div class="form__group">
            <span><i class="ri-calendar-line"></i></span>
            <div class="input__content">
                <div class="input__group">
                    <input type="date" id="return" name="return" class="date-input" placeholder="Return" required />
                    <label for="return">Return</label>
                </div>
                <p>Add date</p>
            </div>
        </div>
        <button type="submit" class="btn1" id="searchButton">🔎</button>
    </form>
</section>


<div id="warningMessage" style="display: none; color: red; margin-top: 10px;">
    Please fill in all fields.
</div>
<h1 class="heading">
    <span>A</span>
    <span>B</span>
    <span>O</span>
    <span>U</span>
    <span>T</span>
    <span style="background: white;"></span>
    <span>U</span>
    <span>S</span>
</h1>
<section class="counter-section">
    <div class="elementor-counter counter1">
        <div class="elementor-counter-number-wrapper">
            <span class="elementor-counter-number-prefix"></span>
            <span class="elementor-counter-number" data-duration="2000" data-to-value="9000" data-from-value="0" data-delimiter=",">0</span>
            <span class="elementor-counter-number-suffix">k+</span>
        </div>
        <div class="elementor-counter-title">Online Bookings</div>
    </div>
    <div class="elementor-counter counter2">
        <div class="elementor-counter-number-wrapper">
            <span class="elementor-counter-number-prefix"></span>
            <span class="elementor-counter-number" data-duration="2000" data-to-value="350" data-from-value="0" data-delimiter=",">0</span>
            <span class="elementor-counter-number-suffix">+</span>
        </div>
        <div class="elementor-counter-title">Cars availabile</div>
    </div>
    <div class="elementor-counter counter3">
        <div class="elementor-counter-number-wrapper">
            <span class="elementor-counter-number-prefix"></span>
            <span class="elementor-counter-number" data-duration="2000" data-to-value="90" data-from-value="0" data-delimiter=",">0</span>
            <span class="elementor-counter-number-suffix"></span>
        </div>
        <div class="elementor-counter-title">In India</div>
    </div>
    <div class="elementor-counter counter4">
        <div class="elementor-counter-number-wrapper">
            <span class="elementor-counter-number-prefix"></span>
            <span class="elementor-counter-number" data-duration="2000" data-to-value="100" data-from-value="0" data-delimiter=",">0</span>
            <span class="elementor-counter-number-suffix">%</span>
        </div>
        <div class="elementor-counter-title">Satisfaction</div>
    </div>
</section>
<section class="section__container plan__container">
    <p class="subheader">TRAVEL SUPPORT</p>
    <h2 class="section__header">Plan Your Travel With Confidence</h2>
    <p class="description">
        Find help with your bookings and travel plans, and seee what to expect
        along your journey.
    </p>
    <div class="plan__grid">
        <div class="plan__content">
            <span class="number">01</span>
            <h4>Wanderlust Haven</h4>
            <p>
                A comprehensive travel platform catering to adventurers seeking unique experiences worldwide.
                From off-the-beaten-path destinations to luxury escapes,
                Wanderlust Haven curates personalized itineraries and offers insider tips for immersive travel.
            </p>
            <span class="number">02</span>
            <h4>Global Roamers</h4>
            <p>
                An interactive travel hub designed for explorers of all types. Global Roamers provides detailed guides, budget-friendly options,
                and community-driven recommendations for globetrotters looking to discover hidden gems around the world.
            </p>
            <span class="number">03</span>
            <h4>Venture Voyager</h4>
            <p>
                For those with a passion for exploration, Venture Voyager is the ultimate travel companion. Offering curated travel packages, insider insights, and a vibrant community of like-minded travelers,
                it's the go-to platform for those seeking authentic experiences off the tourist trail.
            </p>
        </div>
        <div class="plan__image">
            <img src="assets/plan-1.jpg" alt="plan" />
            <img src="assets/plan-2.jpg" alt="plan" />
            <img src="assets/plan-3.jpg" alt="plan" />
        </div>
    </div>
</section>

<section class="memories">
    <div class="section__container memories__container">
        <div class="memories__header">
            <h2 class="section__header">
                Travel to make memories all around the world
            </h2>
            <button class="view__all">View All</button>
        </div>
        <div class="memories__grid">
            <div class="memories__card">
                <span><i class="ri-calendar-2-line"></i></span>
                <h4>Book & relax</h4>
                <p>
                    With "Book and Relax," you can sit back, unwind, and enjoy the
                    journey while we take care of everything else.
                </p>
            </div>
            <div class="memories__card">
                <span><i class="ri-shield-check-line"></i></span>
                <h4>Smart Checklist</h4>
                <p>
                    Introducing Smart Checklist with us, the innovative solution
                    revolutionizing the way you travel.
                </p>
            </div>
            <div class="memories__card">
                <span><i class="ri-bookmark-2-line"></i></span>
                <h4>Save More</h4>
                <p>
                    From discounted prices to exclusive promotions and deals,
                    we prioritize affordability without compromising on quality of services.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section__container lounge__container">
    <div class="lounge__image">
        <img src="assets/lounge-1.jpg" alt="lounge" />
        <img src="assets/lounge-2.jpg" alt="lounge" />
    </div>
    <div class="lounge__content">
        <h2 class="section__header">Some details of the cars</h2>
        <div class="lounge__grid">
            <div class="lounge__details">
                <h4>Sedan</h4>
                <ul>
                    <li>Compact Sedan</li>
                    <li>Mid-size Sedan</li>
                    <li>Full-size Sedan</li>
                    <li>Luxury Sedan</li>
                    <li>Sports Sedan</li>
                </ul>
            </div>
            <div class="lounge__details">
                <h4>SUV (Sports Utility Vehicle)</h4>
                <ul>
                    <li>Compact SUV</li>
                    <li>Mid-size SUV</li>
                    <li>Full-size SUV</li>
                    <li>Crossover SUV</li>
                </ul>
            </div>

            <div class="lounge__details">
                <h4>MUV (Multi Utility Vehicle)</h4>
                <ul>
                    <li>Compact MUV</li>
                    <li>Mid-size MUV</li>
                    <li>Full-size MUV</li>
                </ul>
            </div>

            <div class="lounge__details">
                <h4>Coupe</h4>
                <ul>
                    <li>Two-door Coupe</li>
                    <li>Four-door Coupe</li>
                </ul>
            </div>

            <div class="lounge__details">
                <h4>Electric vehicle</h4>
                <ul>
                    <li>Soft-top Electric vehicle</li>
                    <li>Hard-top Electric vehicle</li>
                </ul>
            </div>
            <div class="lounge__details">
                <h4>Experience Tranquility</h4>
                <p>
                    Serenity Haven offers a tranquil escape, featuring comfortable
                    seating, calming ambiance, and attentive service.
                </p>
            </div>
            <div class="lounge__details">
                <h4>Elevate Your Experience</h4>
                <p>
                    Designed for discerning travelers, this exclusive lounge offers
                    premium amenities, assistance, and private workspaces.
                </p>
            </div>
            <div class="lounge__details">
                <h4>A Welcoming Space</h4>
                <p>
                    Creating a family-friendly atmosphere, The Family Zone is the
                    perfect haven for parents and children.
                </p>
            </div>
            <div class="lounge__details">
                <h4>A Culinary Delight</h4>
                <p>
                    Immerse yourself in a world of flavors, offering international
                    cuisines, gourmet dishes, and carefully curated beverages.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section__container travellers__container">
    <h2 class="section__header">Best travellers of the month</h2>

    <div class="travellers__grid">
        <div class="travellers__card">
            <img src="assets/traveller-1.jpg" alt="traveller" />
            <div class="travellers__card__content">
                <img src="assets/client-1.jpg" alt="client" />
                <h4>Ragu</h4>
                <p>Sikkim</p>
            </div>
        </div>
        <div class="travellers__card">
            <img src="assets/traveller-2.jpg" alt="traveller" />
            <div class="travellers__card__content">
                <img src="assets/client-2.jpg" alt="client" />
                <h4>John Smith</h4>
                <p>Delhi</p>
            </div>
        </div>
        <div class="travellers__card">
            <img src="assets/traveller-3.jpg" alt="traveller" />
            <div class="travellers__card__content">
                <img src="assets/client-3.jpg" alt="client" />
                <h4>Malik sing</h4>
                <p>Punjab</p>
            </div>
        </div>
        <div class="travellers__card">
            <img src="assets/traveller-4.jpg" alt="traveller" />
            <div class="travellers__card__content">
                <img src="assets/client-4.jpg" alt="client" />
                <h4>Taylor</h4>
                <p>Delhi</p>
            </div>
        </div>
    </div>
</section>

<section class="subscribe">
    <div class="section__container subscribe__container">
        <h2 class="section__header">Subscribe newsletter & get latest news</h2>
        <form class="subscribe__form">
            <input type="text" placeholder="Enter your email here" />
            <button class="btn">Subscribe</button>
        </form>
        <div class="cracker">&#127878;</div> <!-- Unicode for cracker -->
        <div class="moving-car">&#128663;</div>
        <div class="cracker">&#127878;</div><!-- Unicode for car -->
    </div>
</section>

<div class="back-to-top">
    <div class="car-icon" onclick="toggleScroll()">🚗</div>
    <div class="links-menu">
        <div class="menu-items">
            <a href="https://example.com/page1" target="_blank">Option 1</a>
            <a href="https://example.com/page2" target="_blank">Option 2</a>
            <a href="https://example.com/page3" target="_blank">Option 3</a>
            <a href="https://example.com/page4" target="_blank">Option 4</a>
            <a href="https://example.com/page5" target="_blank">Option 5</a>
        </div>
        <div class="close-button" onclick="closeLinksMenu()">&times;</div>
    </div>
</div>
<section class="container__background">
    <div class="main__background"></div>
    <div class="sub__background"></div>
</section>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include footer and scripts -->
<?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="js/search.js"></script>
<script src="js/script.js"></script>
<script src="js/book.js"></script>
<script>

        // Get today's date and set the minimum and maximum selectable dates
        var today = new Date();
        var maxDate = new Date(today.getTime() + 15 * 24 * 60 * 60 * 1000); // 15 days from today

        // Format the max date for input
        var maxDateString = maxDate.toISOString().slice(0, 10);

        // Set the attributes for the date inputs
        document.getElementById("departure").setAttribute("min", today.toISOString().slice(0, 10));
        document.getElementById("departure").setAttribute("max", maxDateString);
        document.getElementById("return").setAttribute("min", today.toISOString().slice(0, 10));
        document.getElementById("return").setAttribute("max", maxDateString);

        $(document).ready(function() {
            let mainLocation = ''; // Global variable to store the matched key

            // Fetch locations.json and populate options
            fetch('js/locations.json')
                .then(response => response.json())
                .then(data => {
                    const locationInput = document.getElementById('location');
                    const datalist = document.getElementById('locationOptions');

                    // Populate options from JSON
                    data.locations.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location;
                        datalist.appendChild(option);
                    });

                    // Function to handle input change and suggest options
                    locationInput.addEventListener('input', function() {
                        const inputText = this.value.trim().toLowerCase();
                        const firstWord = inputText.split(' ')[0]; // Get the first word after trimming

                        // Filter options based on the first word
                        const filteredOptions = data.locations.filter(option =>
                            option.toLowerCase().startsWith(firstWord)
                        );

                        // Clear previous options
                        while (datalist.firstChild) {
                            datalist.removeChild(datalist.firstChild);
                        }

                        // Populate filtered options
                        filteredOptions.forEach(option => {
                            const newOption = document.createElement('option');
                            newOption.value = option;
                            datalist.appendChild(newOption);
                        });

                        // Update mainLocation with current input value
                        mainLocation = inputText; // Assign inputText directly to mainLocation
                    });
                })
                .catch(error => console.error('Error fetching locations:', error));

            // Handle form submission
            $('#searchButton').click(function() {
                // Get form data
                var travellers = $('#travellers').val();
                var departure = $('#departure').val();
                var returnDate = $('#return').val();

                // Save form data locally
                localStorage.setItem('booking_location', mainLocation); // Overwrite 'location' with 'mainLocation'
                localStorage.setItem('booking_travellers', travellers);
                localStorage.setItem('booking_departure', departure);
                localStorage.setItem('booking_return', returnDate);

                // Redirect to filterpage.php
                window.location.href = 'filterpage.php';
            });
        });
</script>
</body>
</html>