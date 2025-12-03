<?php
$name = $email = $message = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
        // You can store in DB or send email here
        $success = "Thank you, $name! Your message has been sent successfully.";
        $name = $email = $message = ""; // Clear form
    } else {
        $error = "Please fill out all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(to right, #f0f4f8, #e1e8ed);
      color: #333;
    }

    header {
      background-color: #003366;
      padding: 40px;
      text-align: center;
      color: #fff;
      border-bottom: 5px solid #bfa14a;
    }

    header h1 {
      margin: 0;
      font-size: 3rem;
    }

    .hero {
      width: 100%;
      height: 300px;
      background: url('https://images.unsplash.com/photo-1581090700227-1e8e1dbf1cc4') center/cover no-repeat;
      animation: fadeZoom 2s ease-in-out forwards;
      opacity: 0;
    }

    @keyframes fadeZoom {
      from { opacity: 0; transform: scale(1.05); }
      to { opacity: 1; transform: scale(1); }
    }

    .container {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      padding: 40px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      border-radius: 10px;
    }

    h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      color: #003366;
      border-bottom: 2px solid #bfa14a;
      padding-bottom: 10px;
    }

    form label {
      display: block;
      margin-top: 20px;
      font-weight: bold;
    }

    form input[type="text"],
    form input[type="email"],
    form textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      margin-top: 6px;
      border-radius: 6px;
      transition: 0.3s ease;
      font-size: 1rem;
      font-family: inherit;
    }

    form input:focus,
    form textarea:focus {
      border-color: #003366;
      outline: none;
      box-shadow: 0 0 8px rgba(0,51,102,0.3);
    }

    form textarea {
      height: 120px;
      resize: vertical;
    }

    .btn {
      margin-top: 30px;
      padding: 12px 25px;
      background-color: #003366;
      color: white;
      border: none;
      font-size: 1rem;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background-color: #002244;
    }

    .message-box {
      margin-top: 20px;
      padding: 15px;
      border-radius: 6px;
      font-weight: bold;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    footer {
      text-align: center;
      padding: 25px;
      margin-top: 50px;
      background: #003366;
      color: #fff;
      font-style: italic;
    }

    @media (max-width: 600px) {
      .container {
        padding: 25px;
      }
    }
  </style>
</head>
<body>

  <?php include 'navbar.php'; ?>

  <header>
    <h1>Contact Us</h1>
  </header>

  <div class="hero"></div>

  <div class="container">
    <h2>We’d love to hear from you</h2>

    <?php if ($success): ?>
      <div class="message-box success"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="message-box error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" action="contact.php">
      <label for="name">Full Name:</label>
      <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>

      <label for="email">Email Address:</label>
      <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>

      <label for="message">Message:</label>
      <textarea name="message" id="message" required><?= htmlspecialchars($message) ?></textarea>

      <button class="btn" type="submit">Send Message</button>
    </form>
  </div>

  <footer>
    &copy; <?= date('Y') ?> iTrain. All rights reserved.
  </footer>
</body>
</html>
