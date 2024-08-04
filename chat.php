<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced ChatGPT Car Catalog</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS for chat history and cards -->
    <style>
        .chat-history {
            max-height: 400px;
            overflow-y: scroll;
        }
        .chat-history .message {
            margin-bottom: 10px;
        }
        .chat-history .user-message {
            text-align: right;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 10px;
        }
        .chat-history .bot-message {
            text-align: left;
            background-color: #e9f5f5;
            padding: 10px;
            border-radius: 10px;
        }
        .card1 {
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to our Car Catalog</h1>
        <div class="row">
            <?php
            session_start(); // Start session to store query type and models
            
            include('config.php'); // Include your database connection configuration
            
            // Initialize queryType to default (all cars)
            $queryType = 'car';

            // Check if message is posted from chat input
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Replace with your OpenAI API key for GPT-4
                $apiKey = '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';

                // OpenAI API endpoint for GPT-4 (e.g., davinci-4)
                $endpoint = 'https://api.openai.com/v1/engines/davinci-4/completions';

                // Headers required by OpenAI API
                $headers = [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $apiKey,
                ];

                // Data to send to OpenAI API
                $data = [
                    'prompt' => $_POST['message'], // User message or prompt
                    'max_tokens' => 150, // Adjust as needed
                    'stop' => '\n', // Stop completion at new line to ensure single response
                ];

                // Initialize cURL session
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                // Execute cURL session
                $response = curl_exec($ch);

                // Handle cURL errors
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }

                // Close cURL session
                curl_close($ch);

                // Decode JSON response from OpenAI
                $response = json_decode($response, true);

                // Check if 'choices' array exists and has valid text response
                if (isset($response['choices'][0]['text'])) {
                    // Output the AI response text
                    echo '<script>$("#chat-container").append(\'<div class="message bot-message"><strong>ChatGPT:</strong> ' . $response['choices'][0]['text'] . '</div>\');</script>';
                    // Store query type and models in session
                    $_SESSION['queryType'] = $queryType;
                    $_SESSION['models'] = $response['choices'][0]['text']; // Adjust as per your response
                } else {
                    // Handle case where response is not as expected
                    echo '<script>$("#chat-container").append(\'<div class="message bot-message"><strong>ChatGPT:</strong> I\\\'m sorry, I couldn\\\'t understand that. Could you please try again?</div>\');</script>';
                }
            }

            // Query to fetch cars based on queryType
            $query = "SELECT * FROM cars";
            if ($queryType == 'car') {
                $result = $conn->query($query);
            } else {
                $result = $conn->query($query);
            }

            // Check if there are any cars
            if ($result->num_rows > 0) {
                // Loop through each row (each car)
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img style="width: 100%" src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="Car Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['car_name']; ?></h5>
                                <p class="card-text">Seating Capacity: <?php echo $row['seating_capacity']; ?></p>
                                <p class="card-text">AC Option Price: <?php echo $row['ac_option']; ?></p>
                                <p class="card-text">Non-AC Option Price: <?php echo $row['non_ac_option']; ?></p>
                                <p class="card-text">Cancellation Policy: <?php echo $row['cancellation_policy']; ?></p>
                                <!-- Add more details as needed -->
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No cars found.";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Chat Section -->
                <h2>Chat with ChatGPT</h2>
                <div id="chat-container" class="chat-history">
                    <!-- Chat history will be appended here -->
                </div>
                <form id="chat-form" method="post" class="mt-3">
                    <input type="text" id="user-input" name="message" class="form-control" placeholder="Type your message...">
                    <button type="submit" id="send-btn" class="btn btn-primary mt-3">Send</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to load chat history
            function loadChatHistory() {
                // Replace with your logic to load chat history from database or storage
                var chatHistory = [
                    { user: 'User', message: 'Hi, I am interested in this car.' },
                    { user: 'ChatGPT', message: 'Sure, let me help you with that.' },
                    { user: 'ChatGPT', message: 'What specific details are you looking for?' }
                    // Add more chat history messages as needed
                ];

                // Display chat history in reverse order (latest messages at bottom)
                chatHistory.forEach(function (msg) {
                    var messageHtml = '<div class="message ' + (msg.user === 'User' ? 'user-message' : 'bot-message') + '"><strong>' + msg.user + ':</strong> ' + msg.message + '</div>';
                    $('#chat-container').append(messageHtml);
                });

                // Scroll to bottom of chat container
                $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
            }

            // Load initial chat history
            loadChatHistory();

            // Handle form submission
            $('#chat-form').submit(function (event) {
                event.preventDefault();
                var message = $('#user-input').val().trim();
                if (message !== '') {
                    // Send user message to PHP backend
                    $.post('chat.php', { message: message }, function (response) {
                        // Display AI response
                        var messageHtml = '<div class="message bot-message"><strong>ChatGPT:</strong> ' + response + '</div>';
                        $('#chat-container').append(messageHtml);
                        // Clear input field
                        $('#user-input').val('');
                        // Scroll to bottom of chat container
                        $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
                    });
                }
            });
        });
    </script>
</body>
</html>
