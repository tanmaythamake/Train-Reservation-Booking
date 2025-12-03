<?php
include 'config.php'; // DB connection

// Fetch some trains (उदा. 10)
$sql = "SELECT * FROM trains LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Available Trains</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        /* Reset & base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5dc; /* light beige */
            color: #333;
            padding: 100px 20px 30px; /* top padding for navbar space */
            min-height: 100vh;
        }

        /* Navbar */
        nav.navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #003366;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            z-index: 1000;
        }
        nav.navbar .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        nav.navbar .logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
        }
        nav.navbar ul.nav-links {
            list-style: none;
            display: flex;
            gap: 25px;
        }
        nav.navbar ul.nav-links a {
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            padding: 6px;
            position: relative;
            transition: color 0.3s ease;
        }
        nav.navbar ul.nav-links a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0%;
            height: 2px;
            background: #66a3ff;
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        nav.navbar ul.nav-links a:hover,
        nav.navbar ul.nav-links a:focus {
            color: #66a3ff;
        }
        nav.navbar ul.nav-links a:hover::after,
        nav.navbar ul.nav-links a:focus::after {
            width: 100%;
        }

        /* Heading */
        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.8rem;
            color: #003366;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Table */
        .table-wrapper {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border: 1px solid #777;
            box-shadow: 3px 3px 8px rgba(0,0,0,0.1);
            margin: 0 auto 40px auto;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #aaa;
        }
        th {
            background-color: #003366;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #e0ebff;
        }

        .train-number-container {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            color: #003366;
        }
        .copy-icon {
            margin-right: 8px;
            font-size: 1.2rem;
            color: #666;
            transition: color 0.3s ease;
        }
        .train-number-container:hover {
            color: #00509e;
        }
        .train-number-container:hover .copy-icon {
            color: #004080;
        }

        a.book-link {
            color: #003366;
            font-weight: bold;
            text-decoration: none;
            padding: 6px 12px;
            border: 1px solid #003366;
            border-radius: 4px;
            transition: background 0.3s, color 0.3s;
            display: inline-block;
        }
        a.book-link:hover {
            background-color: #003366;
            color: #fff;
        }

        .back-home {
            display: block;
            margin: 30px auto;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem;
            background: #003366;
            color: #fff;
            padding: 12px 35px;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .back-home:hover {
            background-color: #002244;
        }

        /* Responsive tweaks */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.2rem;
            }
            th, td {
                padding: 10px;
            }
        }
        @media (max-width: 480px) {
            nav.navbar .nav-container {
                flex-direction: column;
                align-items: flex-start;
            }
            nav.navbar ul.nav-links {
                flex-wrap: wrap;
                margin-top: 10px;
            }
        }
    </style>

    <script>
        function copyTrainNumber(el) {
            const txt = el.querySelector('.train-number-text').innerText;
            navigator.clipboard.writeText(txt).then(() => {
                // optional feedback
            }).catch(err => {
                console.error("Copy failed", err);
            });
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">iTrain</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="view_trains.php">View Trains</a></li>
                <li><a href="bookings.php">My Bookings</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <h1>Available Trains</h1>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Train Number</th>
                    <th>Train Name</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Seats Available</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $trainNum = htmlspecialchars($row['train_number']);
                        echo "<tr>
                            <td>
                              <div class='train-number-container' onclick='copyTrainNumber(this)'>
                                <i class='fa-solid fa-clipboard copy-icon'></i>
                                <span class='train-number-text'>{$trainNum}</span>
                              </div>
                            </td>
                            <td>" . htmlspecialchars($row['train_name']) . "</td>
                            <td>" . htmlspecialchars($row['source']) . "</td>
                            <td>" . htmlspecialchars($row['destination']) . "</td>
                            <td>" . htmlspecialchars($row['departure_time']) . "</td>
                            <td>" . htmlspecialchars($row['arrival_time']) . "</td>
                            <td>" . htmlspecialchars($row['seats_available']) . "</td>
                            <td><a href='book.php?train_id=" . urlencode($row['id']) . "' class='book-link'>Book Now</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center;'>No trains available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <a href="index.php" class="back-home">Back to Home</a>
</body>
</html>
