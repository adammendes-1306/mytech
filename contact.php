<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <style>
        .contact-card {
            max-width: 450px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .contact-card h2 {
            text-align: center;
            margin-bottom: 20px;
			font-size: 28px;
        }

        .contact-card label {
            font-weight: bold;
        }

        .contact-card input,
        .contact-card textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
			font-size: 1rem;
        }

        .contact-card textarea {
            resize: vertical;
            height: 120px;
        }

        .contact-card button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #333;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .contact-card button:hover {
            background: #555;
        }
    </style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
    <div class="contact-card">
        <h2>Contact Us</h2>

        <form action="sendemail.php" method="POST">
            <label>Name: </label>
            <input type="text" name="name" placeholder="Enter your name" required>

            <label>Email Address: </label>
            <input type="email" name="email" placeholder="example@email.com" required>

            <label>Your Message: </label>
            <textarea name="message" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send</button>
        </form>
    </div>
<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
