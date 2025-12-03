<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Bookings</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            font-family: Georgia, serif;
            background-color: #f5f5dc;
            color: #333;
            margin: 0;
            padding-top: 100px; /* for navbar spacing */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-family: 'Times New Roman', serif;
            font-size: 2.8rem;
            color: #003366;
            margin-bottom: 30px;
        }

        .table-container {
            width: 90%;
            max-width: 1200px;
            overflow-x: auto;
            margin-bottom: 40px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            border: 1px solid #777;
            box-shadow: 3px 3px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #aaa;
            text-align: left;
            font-size: 1rem;
        }

        th {
            background-color: #003366;
            color: white;
            text-transform: uppercase;
            font-family: Georgia, serif;
            letter-spacing: 1px;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e6f0ff;
        }

        a.cancel-link {
            color: #990000;
            font-weight: bold;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s ease;
        }
        a.cancel-link:hover, a.cancel-link:focus {
            color: #cc0000;
            text-decoration: underline;
        }

        .back-home {
            margin: 20px auto;
            font-family: Georgia, serif;
            font-size: 1.3rem;
            background: #003366;
            color: #fff;
            padding: 12px 35px;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-home:hover {
            background-color: #002244;
        }

        ::selection {
            background: #003366;
            color: #fff;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
            }
            th, td {
                padding: 8px 10px;
                font-size: 0.9rem;
            }
            .back-home {
                font-size: 1rem;
                padding: 10px 25px;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h1>All Bookings</h1>

    <div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Passenger</th>
                <th>Age</th>
                <th>Train</th>
                <th>Seats</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT b.*, t.train_name FROM bookings b JOIN trains t ON b.train_id = t.id ORDER BY b.booking_time DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['passenger_name']) . "</td>
                    <td>" . (int)$row['passenger_age'] . "</td>
                    <td>" . htmlspecialchars($row['train_name']) . "</td>
                    <td>" . (int)$row['seats_booked'] . "</td>
                    <td>" . htmlspecialchars($row['booking_time']) . "</td>
                    <td>
                        <a href='cancel.php?id=" . (int)$row['id'] . "'
                           onclick=\"return confirm('Are you sure you want to cancel this booking?');\"
                           class='cancel-link' title='Cancel booking'>
                            <i class='fa-solid fa-trash'></i> Cancel
                        </a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>No bookings found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>

    <a href="index.php" class="back-home">Back to Home</a>

</body>
</html>
