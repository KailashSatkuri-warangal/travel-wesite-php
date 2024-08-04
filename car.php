<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<title>Booking Form</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="css/car.css">

<body>

<div class="container mt-5">
    <div class="booking-container">
        <form action="calendar_bookings.php" method="post" id="bookingForm" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="location">Choose your location</label>
                <select id="location" name="location" class="form-control" required>
                    <option value="" selected disabled>Select a city</option>
                    <option value="warangal">Warangal</option>
                    <option value="hyderabad">Hyderabad</option>
                    <option value="Chennai">Chennai</option>
                    <option value="gujarat">Gujarat</option>
                    <option value="ladakh">Ladakh</option>
                </select>
                <div class="invalid-feedback">
                    Please choose a location.
                </div>
            </div>
            <div class="form-group">
                <label for="passengers">No. of passengers</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" id="decrement" class="btn btn-outline-secondary">-</button>
                    </div>
                    <input type="number" id="passengers" name="passengers" value="4" readonly class="form-control" required>
                    <div class="input-group-append">
                        <button type="button" id="increment" class="btn btn-outline-secondary">+</button>
                    </div>
                    <div class="invalid-feedback">
                        Please enter number of passengers.
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="arrival">Arrival date</label>
                <input type="text" id="arrival" name="start_date" readonly class="form-control" required>
                <div class="invalid-feedback">
                    Please enter an arrival date.
                </div>
            </div>
            <div class="form-group">
                <label for="departure">Departure date</label>
                <input type="text" id="departure" name="departure_date" readonly class="form-control" required>
                <div class="invalid-feedback">
                    Please enter a departure date.
                </div>
            </div>
            <div class="form-group">
                <label for="appt-time">Time:</label>
                <input id="appt-time" type="time" name="hours" class="form-control" value="10:00" required>
                <div class="invalid-feedback">
                    Please enter a time.
                </div>
            </div>

            <div class="form-group text-center">
                <button type="submit" name="book" id="book" class="btn btn-primary">Book Now</button>
            </div>
        </form>
    </div>
</div>

<div class="container">
    <!-- Filter Form -->
    <form method="GET" action="">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="price_min">Min Price</label>
                <select class="form-control" id="price_min" name="price_min">
                    <option value="">Select Min Price</option>
                    <?php
                    $min_prices = [500, 600, 700, 800,1000];
                    foreach ($min_prices as $price) {
                        echo '<option value="' . $price . '"' . (isset($_GET['price_min']) && $_GET['price_min'] == $price ? ' selected' : '') . '>' . $price . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="price_max">Max Price</label>
                <select class="form-control" id="price_max" name="price_max">
                    <option value="">Select Max Price</option>
                    <?php
                    $max_prices = [1000, 1500, 2000, 2500,5000,7000,10000];
                    foreach ($max_prices as $price) {
                        echo '<option value="' . $price . '"' . (isset($_GET['price_max']) && $_GET['price_max'] == $price ? ' selected' : '') . '>' . $price . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="seating_capacity">Seating Capacity</label>
                <select class="form-control" id="seating_capacity" name="seating_capacity">
                    <option value="">Select Capacity</option>
                    <?php
                    $capacities = [1, 2, 3, 4, 5, 6, 7,8,9];
                    foreach ($capacities as $capacity) {
                        echo '<option value="' . $capacity . '"' . (isset($_GET['seating_capacity']) && $_GET['seating_capacity'] == $capacity ? ' selected' : '') . '>' . $capacity . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="ac_option">AC Option</label>
                <select class="form-control" id="ac_option" name="ac_option">
                    <option value="">Any</option>
                    <option value="1" <?php echo isset($_GET['ac_option']) && $_GET['ac_option'] == '1' ? 'selected' : ''; ?>>AC</option>
                    <option value="0" <?php echo isset($_GET['ac_option']) && $_GET['ac_option'] == '0' ? 'selected' : ''; ?>>Non-AC</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset Filters</button>
        <button type="button" id="showAll" class="btn btn-secondary" onclick="showAll()">Show All</button>
    </form>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // Initialize variables
    include 'config.php';

    // Initialize variables
    $min_price_error = "";

    // Check if seating capacity is selected, then ensure both minprice and maxprice are selected
    if (isset($_GET['seating_capacity']) && $_GET['seating_capacity'] !== '' && (!isset($_GET['price_min']) || $_GET['price_min'] === '' || !isset($_GET['price_max']) || $_GET['price_max'] === '')) {
        $min_price_error = "Please select both Min Price and Max Price when Seating Capacity is selected.";
    }
    elseif (isset($_GET['price_min']) && $_GET['price_min'] !== '' && isset($_GET['price_max']) && $_GET['price_max'] !== '') {
        $price_min = intval($_GET['price_min']);
        $price_max = intval($_GET['price_max']);

        // Validate min price condition
        if ($price_min < 500) {
            $min_price_error = "The minimum price should be at least 500.";
        }

        // Validate difference between min and max prices
        if (($price_max - $price_min) < 500) {
            $min_price_error = "The difference between Min Price and Max Price should be at least 500.";
        }
        // If no error, proceed with SQL query
        if (!$min_price_error) {
            // Initialize conditions array
            $conditions = [];

            // Build SQL query with conditions
            $sql = "SELECT * FROM s2.cars WHERE ";

            // Add conditions based on selected filters
            if (isset($_GET['price_min']) && $_GET['price_min'] !== '') {
                $conditions[] = "ac_option >= " . $price_min;
            }
            if (isset($_GET['price_max']) && $_GET['price_max'] !== '') {
                $conditions[] = "ac_option <= " . $price_max;
            }
            if (isset($_GET['seating_capacity']) && $_GET['seating_capacity'] !== '') {
                $conditions[] = "seating_capacity >= " . intval($_GET['seating_capacity']);
            }
            if (isset($_GET['ac_option']) && $_GET['ac_option'] !== '') {
                $conditions[] = "ac_option = " . intval($_GET['ac_option']);
            }

            // Combine conditions into SQL query
            $sql .= implode(' AND ', $conditions);

            // Execute SQL query
            $result = mysqli_query($conn, $sql);

            // Display error message if any
            if ($min_price_error) {
                echo "<div class='error'>{$min_price_error}</div>";
            } else {
                echo "<div class='row mt-4'>";
                // Check if there are any cars
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col-md-4">
                            <div class="card1">
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
                    $min_price_error = "No cars found.";
                }
                echo "</div>"; // End of row
            }
        }
    } else {
        // Display error if minprice and maxprice not selected
        $min_price_error = "Please select both Min Price and Max Price when Seating Capacity is selected.";
    }
    // Display cars based on query result

    // Close database connection
    mysqli_close($conn);
    ?>

<?php
if ($min_price_error) {
    echo "<div class='alert alert-danger' style='margin-top: 20px'>{$min_price_error}</div>";
}
?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(document).ready(function () {
        // Initialize datepickers with a range from the current date to 15 days in the future
        var currentDate = new Date();
        var maxDate = new Date();
        maxDate.setDate(currentDate.getDate() + 15);

        $("#arrival").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: currentDate,
            maxDate: maxDate,
            onSelect: function (selectedDate) {
                var selectedDateObj = new Date(selectedDate);
                selectedDateObj.setDate(selectedDateObj.getDate() + 1);
                $("#departure").datepicker("option", "minDate", selectedDateObj);
            }
        });

        $("#departure").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: new Date(currentDate.getTime() + (24 * 60 * 60 * 1000)), // Minimum date is tomorrow
            maxDate: maxDate
        });

        // Handle passenger count increment/decrement
        $("#increment").click(function () {
            let count = parseInt($("#passengers").val());
            $("#passengers").val(count + 1);
        });

        $("#decrement").click(function () {
            let count = parseInt($("#passengers").val());
            if (count > 1) {
                $("#passengers").val(count - 1);
            }
        });

        // Custom validation using JavaScript
        $("#bookingForm").submit(function (event) {
            // Validate form fields
            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
                $(this).addClass('was-validated'); // Add Bootstrap's validation classes
            } else {
                // Show confirmation message and redirect after form submission
                alert("Form submitted successfully!");
                onclick(bookNow());
                //window.location.href = ".php"; // Replace with your actual success page
            }
        });

        function validateForm() {
            var valid = true;

            // Location validation (if required)
            if ($("#location").val() === "") {
                valid = false;
                $("#location").siblings(".invalid-feedback").text("Please choose a location.");
            }

            // Passenger validation (if required)
            var passengers = parseInt($("#passengers").val());
            if (passengers < 1 || isNaN(passengers)) {
                valid = false;
                $("#passengers").siblings(".invalid-feedback").text("Please enter number of passengers.");
            }

            // Arrival date validation (if required)
            if ($("#arrival").val() === "") {
                valid = false;
                $("#arrival").siblings(".invalid-feedback").text("Please enter an arrival date.");
            }

            // Departure date validation (if required)
            if ($("#departure").val() === "") {
                valid = false;
                $("#departure").siblings(".invalid-feedback").text("Please enter a departure date.");
            }

            // Time validation (if required)
            if ($("#appt-time").val() === "") {
                valid = false;
                $("#appt-time").siblings(".invalid-feedback").text("Please enter a time.");
            }

            return valid;
        }
    });
    function resetFilters() {
        document.getElementById("price_min").value = "";
        document.getElementById("price_max").value = "";
        document.getElementById("seating_capacity").value = "";
        document.getElementById("ac_option").value = "";
    }
</script>

<?php include('footer.php') ?>
</body>
</html>
