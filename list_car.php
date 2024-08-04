<?php
include 'config.php';

// Fetch all cars
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

// Display cars as clickable links
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<a href="car_details.php?id=' . $row["id"] . '">' . $row["car_name"] . '</a><br>';
    }
} else {
    echo "No cars found.";
}

$conn->close();
?>
