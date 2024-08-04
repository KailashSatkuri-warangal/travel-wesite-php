<!DOCTYPE html>
<html lang="en"><style>
    :root {
        --bg-color-light: #ffffff;
        --text-color-light: #333333;
        --bg-color-dark: #1a1a1a;
        --text-color-dark: #ffffff;
    }

    body {
        background-color: var(--bg-color-light);
        color: var(--text-color-light);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .container {
        max-width: 600px;
    }

    .mode-switch {
        display: flex;
        justify-content: center;
    }

    .btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    .btn:focus {
        outline: none;
        box-shadow: none;
    }

    .btn span {
        transition: transform 0.3s ease;
    }

    .btn-dark {
        background-color: var(--bg-color-dark);
        color: var(--text-color-dark);
    }

    .btn-light {
        background-color: var(--bg-color-light);
        color: var(--text-color-light);
    }

    /* Dark Mode */
    body.dark-mode {
        background-color: var(--bg-color-dark);
        color: var(--text-color-dark);
    }

    .btn-dark.active {
        transform: scale(1.1);
    }

    .btn-dark.active span {
        transform: rotate(360deg);
    }

    .btn-light.active {
        transform: scale(1.1);
    }

    .btn-light.active span {
        transform: rotate(360deg);
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dark/Light Mode Switch</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Dark/Light Mode Switch</h1>
    <div class="mode-switch">
        <button id="darkModeBtn" class="btn btn-dark">
            <span class="fas fa-moon"></span>
        </button>
        <button id="lightModeBtn" class="btn btn-light">
            <span class="fas fa-sun"></span>
        </button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
</body>
</html>
<script>
    $(document).ready(function() {
        const darkModeBtn = document.getElementById('darkModeBtn');
        const lightModeBtn = document.getElementById('lightModeBtn');

        darkModeBtn.addEventListener('click', () => {
            document.body.classList.add('dark-mode');
            localStorage.setItem('theme', 'dark');
            darkModeBtn.classList.add('active');
            lightModeBtn.classList.remove('active');
        });

        lightModeBtn.addEventListener('click', () => {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
            lightModeBtn.classList.add('active');
            darkModeBtn.classList.remove('active');
        });

        // Check user preference for theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.classList.add('dark-mode');
            darkModeBtn.classList.add('active');
        } else {
            document.body.classList.remove('dark-mode');
            lightModeBtn.classList.add('active');
        }
    });

</script>