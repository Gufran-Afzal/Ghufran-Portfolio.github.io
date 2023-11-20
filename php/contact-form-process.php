<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_to = "gufranafzal54@gmail.com";
    $email_subject = "New form submission";

    // Validate and sanitize user inputs
    $name = clean_string($_POST['Name']);
    $email = clean_string($_POST['Email']);
    $message = clean_string($_POST['Message']);

    // Additional validation if needed
    // ...

    // Check for valid email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        problem('The Email address you entered does not appear to be valid.');
    }

    // Check if the message length is sufficient
    if (strlen($message) < 2) {
        problem('The Message you entered does not appear to be valid.');
    }

    // Create the email message
    $email_message = "Form details below.\n\n";
    $email_message .= "Name: $name\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Message: $message\n";

    // Create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Send the email
    if (mail($email_to, $email_subject, $email_message, $headers)) {
        // Success message
        echo "Thank you for contacting us. We will be in touch with you very soon.";
    } else {
        // Error message
        problem("Sorry, there was an issue sending your message. Please try again later.");
    }
}

function clean_string($string)
{
    $bad = array("content-type", "bcc:", "to:", "cc:", "href");
    return str_replace($bad, "", $string);
}

function problem($error)
{
    echo "We are very sorry, but there were error(s) found with the form you submitted. ";
    echo "These errors appear below.<br><br>";
    echo $error . "<br><br>";
    echo "Please go back and fix these errors.<br><br>";
    die();
}
?>
