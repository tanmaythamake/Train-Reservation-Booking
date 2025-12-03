<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Train Booking System - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
        }
        a {
            text-decoration: none;
            color: inherit;
        }

        /* Header Section */
        header {
            background: linear-gradient(to right, #2c3e50, #4ca1af);
            color: #fff;
            text-align: center;
            padding: 80px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            font-family: 'Merriweather', serif;
            font-size: 3rem;
            margin-bottom: 10px;
            animation: fadeInDown 1.2s ease-out;
        }
        header p {
            font-size: 1.2rem;
            color: #e0e0e0;
            margin-top: 10px;
        }

        /* Train Banner */
        .train-banner {
            width: 100%;
            max-height: 600px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
            border-bottom: 5px solid #3498db;
            animation: fadeIn 2s ease-out;
        }

        /* Main Content */
        main {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }
        .marketing-section {
            text-align: center;
            margin-bottom: 40px;
        }
        .marketing-section h2 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .marketing-quote {
            font-size: 1.2rem;
            color: #3498db;
            font-style: italic;
        }

        /* Cards Section */
        .cards-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 40px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card h3 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        .card p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }
        .card ul {
            list-style-type: none;
            padding-left: 20px;
        }
        .card ul li {
            font-size: 1rem;
            color: #555;
            margin-bottom: 5px;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
            font-size: 14px;
        }

        /* Animations */
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: scale(1.05); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .cards-container {
                flex-direction: column;
                align-items: center;
            }
            .card {
                width: 80%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <header>
        <h1>Welcome to Train Booking System</h1>
        <p>Book your journey with comfort & ease</p>
    </header>

    <img src="train2.jpg" alt="Train Banner" class="train-banner" />

    <main>
        <section class="marketing-section">
            <h2><i class="fa-solid fa-train"></i> Your Journey Begins Here</h2>
            <p class="marketing-quote">“Travel in comfort, book with confidence.”</p>
        </section>

        <section class="cards-container">
            <div class="card team-card">
                <h3><i class="fa-solid fa-users"></i> Meet Our Team</h3>
                <p>Dedicated professionals committed to delivering seamless travel experiences.</p>
                <ul>
                    <li><strong>Alisha Pathan</strong> — Roll No 206</li>
                    <li><strong>Maherosh Shaikh</strong> — Roll No 225</li>
                    <li><strong>Shriyash Gavali</strong> — Roll No 237</li>
                    <li><strong>Pratik Pandhare</strong> — Roll No 260</li>
                    <li><strong>Tanmay Thamake</strong> — Roll No 265</li>
                </ul>
            </div>

            <div class="card project-card">
                <h3><i class="fa-solid fa-clipboard-list"></i> About The Project</h3>
                <p>This Train Booking System is designed to simplify your travel planning — offering real-time schedules, easy booking, and reliable service.</p>
                <p class="project-quote">“Simplifying travel, one booking at a time.”</p>
            </div>
        </section>
    </main>

    <footer>
        &copy; 2025 Train Booking System. Designed by <span style="color: #f39c12;">iTrain Group</
::contentReference[oaicite:3]{index=3}
 
