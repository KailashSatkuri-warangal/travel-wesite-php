document.getElementById('bookButton').addEventListener('click', bookNow);

function bookNow() {
    // Check if the user is logged in
    let loggedIn = checkLoginStatus();

    if (loggedIn) {
        // Make an AJAX call to fetch the phone number
        fetchPhoneNumber().then(phoneNumber => {
            if (phoneNumber) {
                // Define the message you want to send
                let message = encodeURIComponent("Hello, I would like to book a service.");
                // Redirect to WhatsApp with the phone number and message
                window.location.href = `https://wa.me/${phoneNumber}?text=${message}`;
            } else {
                // Handle the case where the phone number is not found (optional)
                alert('Phone number not found.');
            }
        }).catch(error => {
            console.error('Error fetching phone number:', error);
            alert('An error occurred. Please try again.');
        });
    } else {
        // Redirect to register.php
        window.location.href = 'register.php';
    }
}

function checkLoginStatus() {
    // Implement the logic to check if the user is logged in
    // For example, check a cookie or session variable
    return document.cookie.includes('user_session='); // Example logic
}

function fetchPhoneNumber() {
    return new Promise((resolve, reject) => {
        // Make an AJAX request to a backend script to fetch the phone number
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetchPhoneNumber.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                resolve(xhr.responseText); // Assume the phone number is returned as plain text
            } else {
                reject('Failed to fetch phone number');
            }
        };
        xhr.onerror = function() {
            reject('AJAX request failed');
        };
        xhr.send();
    });
}
