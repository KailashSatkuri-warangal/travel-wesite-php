document.querySelector('.btn').addEventListener('click', function () {
    var phoneNumber = this.getAttribute('data-contact');
    alert('Contact number: ' + phoneNumber);
});
{
    let atTop = true;
    let hoverTimeout;
    let autoShowTimeout;

    function toggleScroll() {
        const rotation = document.querySelector('.back-to-top').style.transform;
        const newRotation = rotation === 'rotate(360deg)' ? 'rotate(0deg)' : 'rotate(360deg)';

        document.querySelector('.back-to-top').style.transform = newRotation;

        if (atTop) {
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
        } else {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        atTop = !atTop;
    }

    function showLinksMenu() {
        const linksMenu = document.querySelector('.links-menu');
        linksMenu.style.display = 'block';
        document.body.classList.add('overlay-active');

        // Automatically hide menu after 20 seconds
        autoShowTimeout = setTimeout(() => {
            hideLinksMenu();
        }, 20000);
    }

    function hideLinksMenu() {
        const linksMenu = document.querySelector('.links-menu');
        linksMenu.style.display = 'none';
        document.body.classList.remove('overlay-active');

        // Clear auto show timeout
        clearTimeout(autoShowTimeout);
    }

    function closeLinksMenu() {
        const linksMenu = document.querySelector('.links-menu');
        linksMenu.style.display = 'none';
        document.body.classList.remove('overlay-active');

        // Clear auto show timeout
        clearTimeout(autoShowTimeout);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const carIcon = document.querySelector('.car-icon');
        const linksMenu = document.querySelector('.links-menu');

        carIcon.addEventListener('mouseenter', function () {
            hoverTimeout = setTimeout(showLinksMenu, 10000); // Show menu after 10 seconds
        });

        carIcon.addEventListener('mouseleave', function () {
            clearTimeout(hoverTimeout); // Cancel showing menu if mouse leaves
        });

        // Hide menu if clicked outside of it
        document.addEventListener('click', function (event) {
            if (!linksMenu.contains(event.target) && event.target !== carIcon) {
                hideLinksMenu();
            }
        });
    });


}

//login openpopup
    document.addEventListener('DOMContentLoaded', function() {
    // Get the popup and the button that opens it
    var loginPopup = document.getElementById('loginPopup');
    var openPopupButton = document.getElementById('openPopup');
    var closePopupButton = document.getElementById('closePopup');

    // Open the popup when the button is clicked
    openPopupButton.onclick = function() {
    loginPopup.style.display = 'block';
};

    // Close the popup when the close button or outside the popup is clicked
    closePopupButton.onclick = function() {
    loginPopup.style.display = 'none';
};

    window.onclick = function(event) {
    if (event.target == loginPopup) {
    loginPopup.style.display = 'none';
}
};
});


//home page search
function removeWarningMessage() {
    const existingMessage = document.getElementById('warningMessage');
    if (existingMessage) {
        existingMessage.style.display = 'none';
    }
}

function validateForm() {
    const location = document.getElementById('location').value;
    const travellers = document.getElementById('travellers').value;
    const departure = document.getElementById('departure').value;
    const returnDate = document.getElementById('return').value;

    removeWarningMessage();

    if (location.trim() === '' || travellers.trim() === '' || departure.trim() === '' || returnDate.trim() === '') {
        const warningMessage = document.getElementById('warningMessage');
        warningMessage.style.display = 'block';
        warningMessage.textContent = 'Please fill in all fields.';

        return false; // Prevent form submission
    }
    // Redirect to Destinations.html with query parameters
    const url = new URL('filterpage.php', window.location.href);
    url.searchParams.append('location', location);
    url.searchParams.append('travellers', travellers);
    url.searchParams.append('departure', departure);
    url.searchParams.append('return', returnDate);

    window.location.href = url;

    return false; // Prevent form from submitting the traditional way
}


//content filter of search


//destination

document.addEventListener('DOMContentLoaded', function () {
    // Select all like buttons
    const rateButtons = document.querySelectorAll('.like-button');

    // Attach event listeners to each like button
    rateButtons.forEach(button => {
        const category = button.parentElement.parentElement.classList[1]; // Get category from parent book-box class
        const likedKey = `liked_${category}`;

        // Restore like count from localStorage on page load
        let storedRate = parseInt(localStorage.getItem(category)) || 0;
        button.nextElementSibling.textContent = storedRate;

        // Check if the user has already liked this category in the current session
        let alreadyLiked = sessionStorage.getItem(likedKey);
        if (alreadyLiked) {
            button.disabled = true; // Disable the button if already liked in this session
            button.classList.add('glow'); // Add glowing effect if already liked
        }

        // Function to handle the Like button click
        button.addEventListener('click', function () {
            let rateCount = parseInt(button.nextElementSibling.textContent) || 0;

            if (!alreadyLiked) {
                // Increment the like count and update UI
                rateCount++;
                button.nextElementSibling.textContent = rateCount;

                // Store that the user has liked this category in sessionStorage
                sessionStorage.setItem(likedKey, true);

                // Update the like count in localStorage
                localStorage.setItem(category, rateCount);

                // Add the glow class to animate the thumbs-up icon
                button.classList.add('glow');

                // Disable the button after liking
                button.disabled = true;

                // Update the variable to prevent further likes without reload
                alreadyLiked = true;

                // Update the sorting and display after liking
                updateDisplay();
            } else {
                // Unlike process
                // Decrement the like count and update UI
                rateCount--;
                button.nextElementSibling.textContent = rateCount;

                // Remove the glow class to stop glowing effect
                button.classList.remove('glow');

                // Enable the button for future likes
                button.disabled = false;

                // Remove liked state from session storage
                sessionStorage.removeItem(likedKey);

                // Update the like count in localStorage
                localStorage.setItem(category, rateCount);

                // Update the sorting and display after unliking
                updateDisplay();

                // Update the variable to allow liking again
                alreadyLiked = false;
            }
        });
    });

    // Event listener for Category checkboxes
    const checkboxes = document.querySelectorAll('.category');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            updateDisplay();
        });
    });

    // Function to handle filtering and sorting based on selected categories
    function updateDisplay() {
        const selectedCategory = document.querySelector('input[name="category"]:checked');
        const allBoxes = document.querySelectorAll('.book-box');

        // Filter and sort the boxes based on the selected category
        allBoxes.forEach(box => {
            const category = box.classList.value.split(' ')[1];
            if (selectedCategory && selectedCategory.value !== category) {
                box.style.display = 'none'; // Hide boxes not matching selected category
            } else {
                box.style.display = 'block'; // Show boxes matching selected category or when all are shown
            }
        });
    }

    // Event listener for Show All button
    document.querySelector('.show-all').addEventListener('click', function () {
        const allBoxes = document.querySelectorAll('.book-box');
        allBoxes.forEach(box => {
            box.style.display = 'block'; // Display all boxes
        });
        // Uncheck all category checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        // Update display after showing all books
        updateDisplay();
    });

    // Initial display update on page load
    updateDisplay();
});


//counter wp
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.elementor-counter-number');

    counters.forEach(counter => {
        const updateCounter = () => {
            const target = +counter.getAttribute('data-to-value');
            const speed = +counter.getAttribute('data-duration');
            const increment = target / (speed / 10);
            const value = +counter.innerText.replace(',', '');

            if (value < target) {
                counter.innerText = Math.ceil(value + increment).toLocaleString();
                setTimeout(updateCounter, 10);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };

        updateCounter();
    });
});


//trip book
document.addEventListener("DOMContentLoaded", function () {
    const bookingFormContainer = document.getElementById('bookingFormContainer');

    // Create main elements
    const bookingForm = document.createElement('div');
    bookingForm.classList.add('booking-form');

    const heading = document.createElement('h2');
    heading.textContent = 'Book a Trip';

    const bookingSection = document.createElement('section');
    bookingSection.setAttribute('id', 'bookingSection');

    const container = document.createElement('div');
    container.classList.add('container');

    const row = document.createElement('div');
    row.classList.add('row');

    const form = document.createElement('form');
    form.setAttribute('id', 'formBooking');
    form.classList.add('form-group');

    // Create form groups
    const formGroups = [
        {label: 'Full Name:', type: 'text', id: 'fullName', name: 'fullName', placeholder: 'Enter your full name'},
        {label: 'Email:', type: 'email', id: 'email', name: 'email', placeholder: 'Enter your email', required: true},
        {
            label: 'Phone Number:',
            type: 'tel',
            id: 'phone',
            name: 'phone',
            placeholder: 'Enter your phone number',
            required: true
        },
        {label: 'Location:', type: 'text', id: 'location', name: 'location', placeholder: 'Enter location'},
        {label: 'Date:', type: 'date', id: 'date', name: 'date', placeholder: ''},
        {label: 'Number of Adults:', type: 'number', id: 'adults', name: 'adults', placeholder: '', min: 1},
        {label: 'Number of Children:', type: 'number', id: 'children', name: 'children', placeholder: '', min: 0}
    ];

    formGroups.forEach(group => {
        const formGroup = document.createElement('div');
        formGroup.classList.add('form-group');

        const label = document.createElement('label');
        label.setAttribute('for', group.id);
        label.textContent = group.label;

        const input = document.createElement('input');
        input.setAttribute('type', group.type);
        input.setAttribute('id', group.id);
        input.setAttribute('name', group.name);
        input.setAttribute('placeholder', group.placeholder);
        if (group.required) {
            input.setAttribute('required', '');
        }
        if (group.min !== undefined) {
            input.setAttribute('min', group.min);
        }

        formGroup.appendChild(label);
        formGroup.appendChild(input);
        form.appendChild(formGroup);
    });

    // Create submit button
    const button = document.createElement('button');
    button.setAttribute('id', 'bookButton');
    button.setAttribute('type', 'button');
    button.textContent = 'Book Now';

    // Append all elements to the DOM
    row.appendChild(form);
    form.appendChild(button);
    container.appendChild(row);
    bookingSection.appendChild(container);
    bookingForm.appendChild(heading);
    bookingForm.appendChild(bookingSection);
    bookingFormContainer.appendChild(bookingForm);

    // Add event listener for booking button
    button.addEventListener('click', function () {
        bookNow();
    });

    // Function to handle booking logic
    function bookNow() {
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();

        if (!email || !phone) {
            alert('Email and Phone Number are required.');
            return;
        }

        const message = `
      Full Name: ${document.getElementById('fullName').value.trim()}
      Email: ${email}
      Phone Number: ${phone}
      Location: ${document.getElementById('location').value.trim()}
      Date: ${document.getElementById('date').value.trim()}
      Number of Adults: ${document.getElementById('adults').value.trim()}
      Number of Children: ${document.getElementById('children').value.trim()}
    `;

        const whatsappUrl = `https://wa.me/1234567890?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    }
});

{
// Function to animate team members on hover
    const teamMembers = document.querySelectorAll('.team-member img');

    teamMembers.forEach(member => {
        member.addEventListener('mouseover', () => {
            member.style.transform = 'scale(1.1)';
        });

        member.addEventListener('mouseout', () => {
            member.style.transform = 'scale(1)';
        });
    });

// Example function to handle form submission (not implemented)
    function submitForm() {
        alert('Form submitted!'); // Example alert
    }
}