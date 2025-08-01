<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get and sanitize form inputs
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(["\r", "\n"], [" ", " "], $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject_input = trim($_POST["subject"]);
    $number = trim($_POST["number"]);
    $message = trim($_POST["message"]);

    // Validate inputs
    if (empty($name) || empty($message) || empty($number) || empty($subject_input) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // Set recipient
    $recipient = "ggcapitalavenue@gmail.com";

    // Email subject
    $subject = "New contact from $subject_input";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone Number: $number\n";
    $email_content .= "Subject: $subject_input\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($recipient, $subject, $email_content, $headers)) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
