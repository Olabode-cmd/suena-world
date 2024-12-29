<?php
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $contact_method = htmlspecialchars($_POST['contact_method']);
    $service = htmlspecialchars($_POST['service']);
    $location = htmlspecialchars($_POST['location']);
    $comments = htmlspecialchars($_POST['comments']);

    // Email details
    $to = "manager@example.com"; // Replace with the manager's email address
    $subject = "New Appointment Request";
    $body = "You have received a new appointment request:\n\n" .
        "Name: $name\n" .
        "Phone: $phone\n" .
        "Email: $email\n" .
        "Preferred Contact Method: $contact_method\n" .
        "Service Requested: $service\n" .
        "Location: $location\n" .
        "Comments:\n$comments";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'mail.suenaworld.com'; // Replace with your domain's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'bookings@suenaworld.com'; // Replace with your domain email
        $mail->Password = 'suenaworld'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SMTPS as the screenshot indicates Port 465
        $mail->Port = 465; // SMTP Port from your screenshot

        // Email settings
        $mail->setFrom('bookings@suenaworld.com', 'Suena World'); // Replace with your domain email and name
        $mail->addAddress($to); // Add recipient
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send email
        if ($mail->send()) {
            echo "Appointment request sent successfully.";
        } else {
            echo "Failed to send the email.";
        }
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }

} else {
    echo "Invalid request method.";
}