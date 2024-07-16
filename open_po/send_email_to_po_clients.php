<?php
// Ensure form data is retrieved securely
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
$message  = filter_input(INPUT_POST, 'message ', FILTER_SANITIZE_STRING);

// Email details
$to = $email;
$subject = $subject;
$message = $message;

// Email headers
$headers = "From: enquiry_po@ankusamenggservices.com\r\n";
$headers .= "Reply-To: enquiry_po@ankusamenggservices.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: application/json; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";

// Additional tips to avoid spam
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Send the email
if(mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Failed to send email.";
}
?>
