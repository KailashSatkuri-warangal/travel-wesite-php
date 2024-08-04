<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<?php
include ('config.php');

// Check if car_id is provided and numeric
if (isset($_GET['car_id']) && is_numeric($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Query to fetch car details
    $sql_car = "SELECT * FROM cars WHERE id = ?";
    $stmt_car = $conn->prepare($sql_car);
    $stmt_car->bind_param('i', $car_id);
    $stmt_car->execute();
    $result_car = $stmt_car->get_result();

    if ($result_car->num_rows > 0) {
        $row_car = $result_car->fetch_assoc();
        ?>
        <head>
            <meta charset="UTF-8">
            <title><?php echo $row_car['car_name']; ?> Details</title>
        </head>
        <body class="bg-gray-100">
        <div class="max-w-4xl mx-auto py-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <h2 class="text-2xl font-semibold text-gray-800"><?php echo $row_car['car_name']; ?></h2>
                    <p class="text-gray-600 mt-2">Seating Capacity: <?php echo $row_car['seating_capacity']; ?></p>
                    <p class="text-gray-600">Category: <?php echo $row_car['car_category']; ?></p>
                    <p class="text-gray-600">AC Option Price: <?php echo $row_car['ac_option']; ?></p>
                    <p class="text-gray-600">Non-AC Option Price: <?php echo $row_car['non_ac_option']; ?></p>
                    <p class="text-gray-600">Cancellation Policy: <?php echo $row_car['cancellation_policy']; ?></p>
                    <!-- Add more details as needed -->

                    <!-- Display car images -->
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <?php
                        // Query to fetch car images
                        $sql_images = "SELECT * FROM car_images WHERE car_id = ?";
                        $stmt_images = $conn->prepare($sql_images);
                        $stmt_images->bind_param('i', $car_id);
                        $stmt_images->execute();
                        $result_images = $stmt_images->get_result();

                        while ($row_image = $result_images->fetch_assoc()) {
                            ?>
                            <div>
                                <img src="<?php echo $row_image['image_path']; ?>" alt="Car Image" class="w-full h-auto rounded-lg shadow-md">
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </body>
        <?php
    } else {
        echo "Car not found.";
    }
} else {
    echo "Invalid car ID.";
}
?>
<?php include 'footer.php'; ?>
</html>
