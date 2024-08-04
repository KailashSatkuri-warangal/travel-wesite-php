<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $car_name = $_POST['car_name'];
    $location = $_POST['location'];

    $sql = "UPDATE cars SET car_name=?, location=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $car_name, $location, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    header('Location: admin_panel.php');
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM cars WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

$locations = ['Hanmakonda', 'Warangal', 'Delhi', 'Mumbai', 'Goa', 'Gujarat', 'Ladakh', 'Bangalore', 'Hyderabad', 'Kolkata', 'Chennai', 'Jaipur', 'Ahmedabad', 'Pune', 'Surat', 'Kanpur', 'Nagpur', 'Indore', 'Thane', 'Bhopal'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
        }
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Car Details</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $car['id']; ?>">
        <div class="form-group">
            <label for="car_name">Car Name</label>
            <input type="text" class="form-control" id="car_name" name="car_name" value="<?php echo $car['car_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <select class="form-control" id="location" name="location" required>
                <?php foreach ($locations as $loc): ?>
                    <option value="<?php echo $loc; ?>" <?php echo $car['location'] == $loc ? 'selected' : ''; ?>>
                        <?php echo $loc; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
