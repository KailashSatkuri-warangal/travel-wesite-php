<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/destination.css" />

<div class="container">
    <div class="column">
        <div class="book-box hatchback">
            <img src="assets/car6.jpg" style="width: 50%;">
            <h2>Swift</h2>
            <div class="details">
                <p>Seating Capacity: 5</p>
                <p>AC Option: ₹4000 per day</p>
                <p>Non-AC Option: ₹1500 per day</p>
                <p>Cancellation Policy: Flexible</p>
            </div>
            <a href="hatchback.php"><button class="btn1">View more</button></a>
            <div class="rating">
                <button class="like-button"><i class="ri-thumb-up-line"></i>👍</button>
                <span class="rate-count">0</span>
            </div>
        </div>

        <div class="book-box sedan">
            <img src="assets/car1.jpg" style="width:50%;">
            <h2>Nissan</h2>
            <div class="details">
                <p>Seating Capacity: 5</p>
                <p>AC Option: ₹5000 per day</p>
                <p>Non-AC Option: ₹2000 per day</p>
                <p>Cancellation Policy: Flexible</p>
            </div>
            <a href="sedan.php"><button class="btn1">View more</button></a>
            <div class="rating">
                <button class="like-button"><i class="ri-thumb-up-line"></i>👍</button>
                <span class="rate-count">0</span>
            </div>
        </div>
        <div class="book-box suv">
            <img src="assets/car11.jpg" style="width:50%;">
            <h2>Mahindra Scorpio</h2>
            <div class="details">
                <p>Seating Capacity: 7</p>
                <p>AC Option: ₹6000 per day</p>
                <p>Non-AC Option: ₹2500 per day</p>
                <p>Cancellation Policy: Moderate</p>
            </div>
            <a href="Suv.php"><button class="btn1">View more</button></a>
            <div class="rating">
                <button class="like-button"><i class="ri-thumb-up-line"></i>👍</button>
                <span class="rate-count">0</span>
            </div>
        </div>
        <div class="book-box muv">
            <img src="assets/car16.jpg" style="width:50%;">
            <h2>Toyota Innova Crysta</h2>
            <div class="details">
                <p>Seating Capacity: 8</p>
                <p>AC Option: ₹7000 per day</p>
                <p>Non-AC Option: ₹3000 per day</p>
                <p>Cancellation Policy: Strict</p>
            </div>
            <a href="Muv.php"><button class="btn1">View more</button></a>
            <div class="rating">
                <button class="like-button"><i class="ri-thumb-up-line"></i>👍</button>
                <span class="rate-count">0</span>
            </div>
        </div>
        <div class="book-box coupe">
            <img src="assets/car21.jpg" style="width:50%;">
            <h2>BMW 2 Series Gran Coupe</h2>
            <div class="details">
                <p>Seating Capacity: 2</p>
                <p>AC Option: ₹8000 per day</p>
                <p>Non-AC Option: ₹3500 per day</p>
                <p>Cancellation Policy: Moderate</p>
            </div>
            <a href="coupe.php"><button class="btn1">View more</button></a>
            <div class="rating">
                <button class="like-button"><i class="ri-thumb-up-line"></i>👍</button>
                <span class="rate-count">0</span>
            </div>
        </div>
        <div class="book-box electric">
            <img src="assets/car26.jpg" style="width:50%;">
            <h2>Tata Punch EV</h2>
            <div class="details">
                <p>Seating Capacity: 5</p>
                <p>AC Option: ₹5500 per day</p>
                <p>Non-AC Option: ₹2500 per day</p>
                <p>Cancellation Policy: Flexible</p>
            </div>
            <a href="electricvehicle.php"><button class="btn1">View more</button></a>
            <div class="rating">
                <button class="like-button"><i class="ri-thumb-up-line"></i>👍</button>
                <span class="rate-count">0</span>
            </div>
        </div>
        <div class="book-box trips">
            <img src="assets/car31.jpg" style="width:50%;">
            <h2>Traveller</h2>
            <div class="details">
                <p>Seating Capacity: Varies</p>
                <p>AC Option: Varies</p>
                <p>Non-AC Option: Varies</p>
                <p>Cancellation Policy: Varies</p>
            </div>
            <a href="trips.php"><button class="btn1">View more</button></a>
            <div class="rating">
                <button class="like-button"><i class="ri-thumb-up-line"></i>👍</button>
                <span class="rate-count">0</span>
            </div>
        </div>
    </div>
    <div class="column">
        <div class="categories">
            <h2>Categories</h2>
            <ul>
                <li><input type="radio" name="category" class="category" value="hatchback"> Hatchback</li>
                <li><input type="radio" name="category" class="category" value="sedan"> Sedan</li>
                <li><input type="radio" name="category" class="category" value="suv"> SUV</li>
                <li><input type="radio" name="category" class="category" value="muv"> MUV</li>
                <li><input type="radio" name="category" class="category" value="coupe"> Coupe</li>
                <li><input type="radio" name="category" class="category" value="electric"> Electric Vehicle</li>
                <li><input type="radio" name="category" class="category" value="trips"> Trips</li>
                <li><button class="show-all btn1" >Show All</button></li>
                <!-- Add more categories as needed -->
            </ul>
        </div>
    </div>
</div>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['message'])) {
        $email = $_POST['email'];
        $message = $_POST['message'];

        $sql = "SELECT firstname, lastname FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $name = $user['firstname'] . ' ' . $user['lastname'];

                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'fellowships@monosage.com';
                    $mail->Password = 'Fellowships@12';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    //Recipients
                    $mail->setFrom($email, $name);
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject =  "=?UTF-8?B?" . base64_encode("🎉 Thanks for filling, " . $name . " from travel website - Our Feedback") . "?=";
                    $mail->Body    = nl2br($message);

                    $mail->send();
                    echo '
                        <div class="container thank-you-message">
                            <h1>Thank you for contacting me, ' . $name . '! I will get back to you as soon as possible! 😊</h1>
                            <p class="back">Go back to the <a href="index.html">homepage</a>.</p>
                        </div>
                    ';
                } catch (Exception $e) {
                    echo "Error sending email: {$mail->ErrorInfo}";
                }
            } else {
                die("Error: Email not found in users table!");
            }

            $stmt->close();
        } else {
            die("Error: Failed to prepare SQL statement!");
        }
    } else {
        die("Error: Email and message are required fields!");
    }

    $conn->close();
}
?>


<div class="feedback-container">
    <h2>Feedback Form</h2>
    <form id="feedbackForm" method="post" action="Destinations.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit" id="submitBtn">Submit</button>
    </form>
</div>
<script>
    document.getElementById('feedbackForm').addEventListener('submit', function(event) {
        // event.preventDefault(); // Prevent the default form submission

        // Here, you would normally send the form data to the server using AJAX
        // For now, we'll just show the thank-you message

        // document.getElementById('thankYouMessage').classList.remove('hidden');
    });
</script>
<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>