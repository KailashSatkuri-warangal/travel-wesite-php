<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .booking-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }

        .booking-section {
            margin: 0 10px;
            text-align: center;
        }

        .booking-section label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .booking-section input, .booking-section select {
            width: 150px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        .booking-section button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .booking-section button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <form action="calendar_bookings.php" method="post">
            <div class="booking-section">
                <label for="location">Choose your location</label>
                <select id="location" name="location" required>
                    <option value="" selected disabled>Select a city</option>
                    <option value="New York">New York</option>
                    <option value="Los Angeles">Los Angeles</option>
                    <option value="Chicago">Chicago</option>
                    <option value="Houston">Houston</option>
                    <option value="Miami">Miami</option>
                </select>
            </div>
            <div class="booking-section">
                <label for="passengers">No. of passengers</label>
                <button type="button" id="decrement">-</button>
                <input type="text" id="passengers" name="passengers" value="4" readonly required>
                <button type="button" id="increment">+</button>
            </div>
            <div class="booking-section">
                <label for="arrival">Arrival date</label>
                <input type="text" id="arrival" name="start_date" readonly required>
            </div>
            <div class="booking-section">
                <label for="departure">Departure date</label>
                <input type="text" id="departure" name="departure_date" readonly required>
            </div>
            <div class="booking-section">
                <button type="submit" name="book" id="book">Book Now</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize datepickers
            $("#arrival, #departure").datepicker({
                dateFormat: "yy-mm-dd"
            });

            // Handle passenger count increment/decrement
            $("#increment").click(function() {
                let count = parseInt($("#passengers").val());
                $("#passengers").val(count + 1);
            });

            $("#decrement").click(function() {
                let count = parseInt($("#passengers").val());
                if (count > 1) {
                    $("#passengers").val(count - 1);
                }
            });
        });
    </script>
</body>
</html>
