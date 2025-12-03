<?php
if (!isset($currentPage)) {
    $currentPage = '';
}
?>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-logo">
            <!-- Train Logo Image (transparent background) -->
            <img src="train_logo.jpg" alt="Train Logo" class="logo-img">
        </a>
        <ul class="navbar-links">
            <li>
              <a href="index.php" class="<?php if ($currentPage == 'home') echo 'active'; ?>">Home</a>
            </li>
            <li>
              <a href="view_trains.php" class="<?php if ($currentPage == 'view_trains') echo 'active'; ?>">View Trains</a>
            </li>
            <li>
              <a href="bookings.php" class="<?php if ($currentPage == 'bookings') echo 'active'; ?>">My Bookings</a>
            </li>
            <li>
              <a href="contact.php" class="<?php if ($currentPage == 'contact') echo 'active'; ?>">Contact</a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .navbar {
        background-color: #003366;
        padding: 14px 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 999;
        font-family: 'Roboto', sans-serif;
    }

    .navbar-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 20px;
    }

    .navbar-logo {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .logo-img {
        height: 50px;   /* Adjust logo size */
        width: auto;
        transition: transform 0.3s ease;
    }

    .navbar-logo:hover .logo-img {
        transform: scale(1.1); /* zoom effect on hover */
    }

    .navbar-links {
        list-style: none;
        display: flex;
        gap: 25px;
        margin-left: auto;
    }

    .navbar-links li a {
        color: #f0f0f0;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 500;
        padding: 6px 10px;
        border-radius: 4px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .navbar-links li a:hover,
    .navbar-links li a.active {
        background-color: #fff;
        color: #003366;
    }

    @media (max-width: 768px) {
        .navbar-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar-links {
            flex-direction: column;
            width: 100%;
            gap: 10px;
            margin-top: 10px;
        }

        .navbar-links li a {
            width: 100%;
            display: block;
        }
    }
</style>
