function handleLogin(event) {
    event.preventDefault(); // Prevent form submission

    // Retrieve input values
    const username = document.getElementById('loginUsername').value.trim();
    const password = document.getElementById('loginPassword').value.trim();

    // Retrieve stored user data from localStorage
    const storedUsername = localStorage.getItem('username');
    const storedPassword = localStorage.getItem('password');

    // Validate username and password
    if (username === storedUsername && password === storedPassword) {
        alert('Login successful!');

        // Store login state in localStorage
        localStorage.setItem('isLoggedIn', 'true');
        localStorage.setItem('username', username); // Store username if needed

        // Redirect or update UI
        window.location.href = '/index.html'; // Redirect to dashboard or another page
    } else {
        alert('Invalid username or password. Please try again.');
    }
}

// Event listener for login form submission
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', handleLogin);
}
