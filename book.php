<?php
include 'config.php';

$train = null;
$train_id = null;
$message = "";

// For navbar active link highlighting
$currentPage = 'book';  // or whatever identifier you want

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $train_id = (int) ($_POST['train_id'] ?? 0);
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $age = (int) ($_POST['age'] ?? 0);
    $seats = (int) ($_POST['seats'] ?? 0);
    $facility = $conn->real_escape_string($_POST['facility'] ?? '');

    // Fetch train including price columns
    $stmt = $conn->prepare("SELECT * FROM trains WHERE id = ?");
    $stmt->bind_param("i", $train_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $train = $res->fetch_assoc();
    $stmt->close();

    if ($train && $train['seats_available'] >= $seats) {
        // Determine price per seat according to facility
        $price_to_charge = 0.0;
        switch ($facility) {
            case 'AC':
                $price_to_charge = $train['price_ac'] ?? 0;
                break;
            case 'Non‑AC':
                $price_to_charge = $train['price_non_ac'] ?? 0;
                break;
            case 'Sleeper':
                $price_to_charge = $train['price_sleeper'] ?? 0;
                break;
            case 'General':
            default:
                $price_to_charge = $train['price_general'] ?? 0;
                break;
        }
        $total_cost = $price_to_charge * $seats;

        // Insert booking
        $stmt2 = $conn->prepare("
            INSERT INTO bookings 
              (train_id, passenger_name, passenger_age, seats_booked, facility, total_price)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt2->bind_param("isissd", $train_id, $name, $age, $seats, $facility, $total_cost);
        $stmt2->execute();
        $stmt2->close();

        // Update seats availability
        $stmt3 = $conn->prepare("UPDATE trains SET seats_available = seats_available - ? WHERE id = ?");
        $stmt3->bind_param("ii", $seats, $train_id);
        $stmt3->execute();
        $stmt3->close();

        $message = "<div class='message success'>✅ Booking successful for <strong>" . htmlspecialchars($name) . "</strong> (Facility: " 
                   . htmlspecialchars($facility) . "). Total Price: ₹" . number_format($total_cost, 2) . "</div>";
    } else {
        $message = "<div class='message error'>❌ Not enough seats available or train not found.</div>";
    }
} elseif (isset($_GET['train_id'])) {
    $train_id = (int) $_GET['train_id'];
    $stmt = $conn->prepare("SELECT * FROM trains WHERE id = ?");
    $stmt->bind_param("i", $train_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $train = $res->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Ticket</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 60px auto 40px auto;
            background: #ffffff;
            padding: 30px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #003366;
            text-align: center;
            margin-bottom: 25px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        label {
            font-weight: 600;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        input:focus,
        select:focus {
            border-color: #003366;
            outline: none;
        }
        button {
            padding: 14px;
            background-color: #003366;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #002244;
        }
        .back-link {
            margin-top: 25px;
            text-align: center;
        }
        .back-link a {
            color: #003366;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .message {
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 1rem;
            text-align: center;
        }
        .message.success {
            background-color: #e6f7e6;
            border: 1px solid #b6e2b6;
            color: #257a3e;
        }
        .message.error {
            background-color: #ffe6e6;
            border: 1px solid #f5baba;
            color: #c62828;
        }
        @media (max-width: 500px) {
            .container {
                margin: 30px 15px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- include navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Book Ticket for: <?= htmlspecialchars($train['train_name'] ?? 'Train Not Found') ?></h2>

        <?php if (!empty($message)) echo $message; ?>

        <?php if ($train): ?>
        <form method="post" action="book.php">
            <input type="hidden" name="train_id" value="<?= $train['id'] ?>">

            <label for="name">Passenger Name:</label>
            <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">

            <label for="age">Passenger Age:</label>
            <input type="number" name="age" id="age" required min="1" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>">

            <label for="seats">Number of Seats:</label>
            <input type="number" name="seats" id="seats" min="1" max="<?= $train['seats_available'] ?>" required value="<?= htmlspecialchars($_POST['seats'] ?? '1') ?>">

            <label for="facility">Choose Facility:</label>
            <select name="facility" id="facility" required onchange="updatePrice()">
                <option value="General" <?= (isset($_POST['facility']) && $_POST['facility'] === 'General') ? 'selected' : '' ?>>General</option>
                <option value="Sleeper" <?= (isset($_POST['facility']) && $_POST['facility'] === 'Sleeper') ? 'selected' : '' ?>>Sleeper</option>
                <option value="Non‑AC" <?= (isset($_POST['facility']) && $_POST['facility'] === 'Non‑AC') ? 'selected' : '' ?>>Non‑AC</option>
                <option value="AC" <?= (isset($_POST['facility']) && $_POST['facility'] === 'AC') ? 'selected' : '' ?>>AC</option>
            </select>

           
            <button type="submit">Book Now</button>
        </form>
        <?php else: ?>
            <div class="message error">Train not found. <a href="view_trains.php">Go back</a></div>
        <?php endif; ?>

        <div class="back-link">
            <a href="view_trains.php">&larr; Back to Train List</a>
        </div>
    </div>

    <script>
    const prices = {
        'General': <?= json_encode($train['price_general'] ?? 0) ?>,
        'Sleeper': <?= json_encode($train['price_sleeper'] ?? 0) ?>,
        'Non‑AC': <?= json_encode($train['price_non_ac'] ?? 0) ?>,
        'AC': <?= json_encode($train['price_ac'] ?? 0) ?>
    };

    function updatePrice() {
        const fac = document.getElementById('facility').value;
        const display = document.getElementById('price_display');
        const pr = (prices[fac] !== undefined) ? prices[fac] : 0;
        display.innerText = '₹ ' + pr.toFixed(2);
    }

    window.onload = function() {
        updatePrice();
    }
    </script>
</body>
</html>
