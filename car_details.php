<?php
include 'config.php';
include 'header.php'; // Include your header

// Function to call Gemini API
function callGeminiAPI($pair) {
    $url = 'https://api.gemini.com/v1/pubticker/' . $pair; // Correct endpoint

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'GET', // GET method for fetching data
        ],
    ];

    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
        $error = error_get_last();
        return 'Error occurred while calling Gemini API: ' . $error['message'];
    }

    return json_decode($result, true);
}

// Check if car ID is provided
if (isset($_GET['id'])) {
    $car_id = intval($_GET['id']);
    
    // Fetch car details based on the ID
    $sql = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
        echo '<div class="container mt-5">';
        echo '<button id="showApiButton" class="btn btn-secondary mb-3">Show Gemini API Response</button>';
        echo '<div id="apiDetails" class="card" style="display: none;">';
        echo '<div class="card-body">';
        
        // Example: Fetching market data for BTC/USD
        $pair = 'BTCUSD';
        $apiResponse = callGeminiAPI($pair);

        if (is_string($apiResponse)) {
            // If the API response is an error message
            echo '<p class="text-danger">Gemini API Response: ' . $apiResponse . '</p>';
        } else {
            // Display API response in a readable format
            echo '<h5>Gemini API Response:</h5>';
            echo '<ul class="list-group">';
            echo '<li class="list-group-item"><strong>Bid Price:</strong> ' . $apiResponse['bid'] . '</li>';
            echo '<li class="list-group-item"><strong>Ask Price:</strong> ' . $apiResponse['ask'] . '</li>';
            echo '<li class="list-group-item"><strong>Last Price:</strong> ' . $apiResponse['last'] . '</li>';
            echo '<li class="list-group-item"><strong>Volume BTC:</strong> ' . $apiResponse['volume']['BTC'] . '</li>';
            echo '<li class="list-group-item"><strong>Volume USD:</strong> ' . $apiResponse['volume']['USD'] . '</li>';
            echo '<li class="list-group-item"><strong>Timestamp:</strong> ' . date('Y-m-d H:i:s', $apiResponse['volume']['timestamp'] / 1000) . '</li>';
            echo '</ul>';
        }
        
        echo '</div>';
        echo '</div>';
        
        // Car details section
        echo '<button id="showCarButton" class="btn btn-primary mb-3">Hide Car Details</button>';
        echo '<div id="carDetails" class="card">';
        echo '<div class="card-header">';
        echo '<h2>' . $car["car_name"] . '</h2>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<p><strong>Seating Capacity:</strong> ' . $car["seating_capacity"] . '</p>';
        echo '<p><strong>Category:</strong> ' . $car["car_category"] . '</p>';
        echo '<p><strong>AC Option Price:</strong> ' . $car["ac_option"] . '</p>';
        echo '<p><strong>Non-AC Option Price:</strong> ' . $car["non_ac_option"] . '</p>';
        echo '<p><strong>Cancellation Policy:</strong> ' . $car["cancellation_policy"] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="container mt-5"><div class="alert alert-danger">Car not found.</div></div>';
    }

    $stmt->close();
} else {
    echo '<div class="container mt-5"><div class="alert alert-danger">No car ID provided.</div></div>';
}

include 'footer.php'; // Include your footer
$conn->close();
?>


<script>
document.getElementById('showCarButton').addEventListener('click', function() {
    var carDetails = document.getElementById('carDetails');
    if (carDetails.style.display === 'none') {
        carDetails.style.display = 'block';
        this.textContent = 'Hide Car Details';
    } else {
        carDetails.style.display = 'none';
        this.textContent = 'Show Car Details';
    }
});

document.getElementById('showApiButton').addEventListener('click', function() {
    var apiDetails = document.getElementById('apiDetails');
    if (apiDetails.style.display === 'none') {
        apiDetails.style.display = 'block';
        this.textContent = 'Hide Gemini API Response';
    } else {
        apiDetails.style.display = 'none';
        this.textContent = 'Show Gemini API Response';
    }
});
</script>
