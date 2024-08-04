$(document).ready(function() {
    $('#usersTable').DataTable();
    // Handle inline editing and update
    $('.editable').blur(function() {
        var userId = $(this).attr('data-user-id');
        var field = $(this).attr('data-field');
        var newValue = $(this).text();

        $.ajax({
            type: 'POST',
            url: 'update_userinfo.php',
            data: {
                action: 'update_user',
                user_id: userId,
                username: field === 'username' ? newValue : '',
                email: field === 'email' ? newValue : '',
                phone_number: field === 'phone_number' ? newValue : '',
                role: field === 'role' ? newValue : ''
            },
            success: function(response) {
                if (response === 'success') {
                    alert('User information updated successfully.');
                } else {
                    alert('Failed to update user information. Please try again.');
                }
            }
        });
    });

    // Handle update button click (optional if you want separate update button)
    $('.update-btn').click(function() {
        var userId = $(this).attr('data-user-id');

        // You can add specific update logic here if needed
        alert('Update button clicked for user ID: ' + userId);
    });
});
// edit car values
$(document).ready(function() {
    // Function to toggle edit image section visibility
    function toggleEditImageSection(show) {
        if (show) {
            $('#editImageSection').show(); // Show the edit image section
            $('#uploadImageFormGroup').hide(); // Hide the upload image form group
        } else {
            $('#editImageSection').hide(); // Hide the edit image section
            $('#uploadImageFormGroup').show(); // Show the upload image form group
        }
    }

    // Click event handler for Edit button
    $('#editCarButton').on('click', function() {
        // Example logic: Show edit image section when Edit button is clicked
        toggleEditImageSection(true);

        // Additional modal logic can go here if needed
    });
});
function editProcess(id, name, seatingCapacity, category, acOption, nonAcOption, cancellationPolicy, imagePath) {
    // Set form action to either add_car.php or edit_car.php based on carId presence
    if (id) {
        document.getElementById('carForm').action = 'edit_car.php';
        document.getElementById('carFormButton').textContent = 'Update Car';
    } else {
        document.getElementById('carForm').action = 'add_car.php';
        document.getElementById('carFormButton').textContent = 'Add Car';
    }

    // Populate form fields with existing car details
    document.getElementById('carId').value = id || '';
    document.getElementById('carName').value = name || '';
    document.getElementById('seatingCapacity').value = seatingCapacity || '';
    document.getElementById('carCategory').value = category || '';
    document.getElementById('acOption').value = acOption || '';
    document.getElementById('nonAcOption').value = nonAcOption || '';
    document.getElementById('cancellationPolicy').value = cancellationPolicy || '';

    // Display the existing image (if needed)
    if (imagePath) {
        document.getElementById('existingImage').src = imagePath;
        document.getElementById('existingImageContainer').style.display = 'block';
    } else {
        document.getElementById('existingImageContainer').style.display = 'none';
    }

    // Switch to the "Car Upload" tab
    $('#adminTabs a[href="#carUpload"]').tab('show');
}

// delete option
function deleteCar(carId) {
    if (confirm("Are you sure you want to delete this car?")) {
        $.ajax({
            url: 'delete_car.php',
            type: 'POST',
            data: { id: carId }, // Send car ID as POST data to delete_car.php
            success: function(response) {
                if (response == 'success') {
                    alert("Car deleted successfully.");
                    location.reload(); // Reload page after successful deletion
                } else {
                    alert("Error deleting car.");
                }
            },
            error: function() {
                alert("An error occurred.");
            }
        });
    }
}
$(document).ready(function() {
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var location = $(this).data('location');

        $('#car-id').val(id);
        $('#car-name').val(name);
        $('#location').val(location);

        $('#editModal').modal('show');
    });

    $('.view-order-btn').click(function() {
        var orderId = $(this).data('id');

        // AJAX request to update order status
        $.ajax({
            url: 'admin_panel.php', // Send request to the same file
            method: 'POST',
            data: { action: 'update_order_status', orderId: orderId },
            success: function(response) {
                alert('Order status updated successfully!');
                location.reload(); // Refresh page or update UI dynamically
            },
            error: function(xhr, status, error) {
                console.error('Error updating order status:', error);
                alert('Failed to update order status. Please try again.');
            }
        });
    });
});