<?php
include 'config.php';

$message = "";
$type = "";

// If single cancel via GET (id)
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $booking = $conn->query("SELECT * FROM bookings WHERE id = $id")->fetch_assoc();
    if ($booking) {
        $conn->query("DELETE FROM bookings WHERE id = $id");
        $conn->query("UPDATE trains SET seats_available = seats_available + {$booking['seats_booked']} WHERE id = {$booking['train_id']}");
        $message = "Booking cancelled successfully.";
        $type = "success";
    } else {
        $message = "Booking not found.";
        $type = "error";
    }
}

// If bulk cancel via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cancel_ids']) && is_array($_POST['cancel_ids'])) {
    $ids = array_map('intval', $_POST['cancel_ids']);
    if (count($ids) > 0) {
        // For each id, fetch booking, delete, update seats
        foreach ($ids as $bid) {
            $b = $conn->query("SELECT * FROM bookings WHERE id = $bid")->fetch_assoc();
            if ($b) {
                $conn->query("DELETE FROM bookings WHERE id = $bid");
                $conn->query("UPDATE trains SET seats_available = seats_available + {$b['seats_booked']} WHERE id = {$b['train_id']}");
            }
        }
        $message = "Selected bookings cancelled successfully.";
        $type = "success";
    } else {
        $message = "No bookings selected to cancel.";
        $type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Cancel Booking</title>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Merriweather', serif;
      background: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 100px;
      min-height: 100vh;
    }
    .container {
      width: 90%;
      max-width: 800px;
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      text-align: center;
    }
    .message.success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    .message.error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    .message {
      padding: 20px;
      margin-bottom: 30px;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: bold;
      text-align: center;
    }
    .back-link {
      display: inline-block;
      margin: 20px 10px;
      padding: 12px 24px;
      background-color: #003366;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }
    .back-link:hover {
      background-color: #002244;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      padding: 12px 15px;
      border: 1px solid #aaa;
      text-align: left;
    }
    th {
      background-color: #003366;
      color: #fff;
    }
    tbody tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    tbody tr:hover {
      background-color: #e6f0ff;
    }
    .checkbox-cell {
      text-align: center;
    }
    .cancel-btn {
      padding: 10px 20px;
      background-color: #990000;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s ease;
    }
    .cancel-btn:hover {
      background-color: #cc0000;
    }
    @media (max-width: 600px) {
      th, td {
        padding: 8px 10px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if ($message !== ""): ?>
      <div class="message <?= $type ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="">
      <table>
        <thead>
          <tr>
            <th><input type="checkbox" id="selectAll" /></th>
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
        $res = $conn->query($sql);
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                  <td class='checkbox-cell'><input type='checkbox' name='cancel_ids[]' value='" . (int)$row['id'] . "'></td>
                  <td>" . htmlspecialchars($row['passenger_name']) . "</td>
                  <td>" . (int)$row['passenger_age'] . "</td>
                  <td>" . htmlspecialchars($row['train_name']) . "</td>
                  <td>" . (int)$row['seats_booked'] . "</td>
                  <td>" . htmlspecialchars($row['booking_time']) . "</td>
                  <td>
                    <a href='?id=" . (int)$row['id'] . "' onclick=\"return confirm('Cancel this booking?');\" class='back-link' style='background:#990000;'>Cancel</a>
                  </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align:center;'>No bookings found.</td></tr>";
        }
        ?>
        </tbody>
      </table>

      <button type="submit" class="cancel-btn">Cancel Selected</button>
    </form>

    <a href="bookings.php" class="back-link">← Back to Bookings</a>
  </div>

  <script>
    document.getElementById('selectAll').addEventListener('change', function() {
      const checked = this.checked;
      document.querySelectorAll("input[name='cancel_ids[]']").forEach(cb => {
        cb.checked = checked;
      });
    });
  </script>
</body>
</html>
