<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require '../mytech/PHPMailer-master/src/Exception.php';	// Double check directories
require '../mytech/PHPMailer-master/src/PHPMailer.php';
require '../mytech/PHPMailer-master/src/SMTP.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kl2408016802@student.uptm.edu.my';   	// Your Gmail address
        $mail->Password   = 'xudjjwzazmdrigpu';       				// Your 16-character Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('kl2408016802@student.uptm.edu.my', 'MYTECH Admin'); // Destination email

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Message from $name";
        $mail->Body    = "
            <h3>Name:</h3> $name 
            <br><h3>Email:</h3> $email 
            <br><h3>Message:</h3><p>$message</p>
        ";

        $mail->send();
        echo "Thank you! Your message has been sent successfully.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: { $mail->ErrorInfo }";
    }

} // <-- Closes the if statement
?>