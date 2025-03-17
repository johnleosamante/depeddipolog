<?php
// includes/email.php
$headers = "From: " . SITE_AUTHOR . "<" . SITE_AUTHOR_EMAIL . ">" . PHP_EOL . "Reply-To: " . SITE_AUTHOR . "<" . SITE_AUTHOR_EMAIL . ">" . PHP_EOL . "X-Mailer: PHP/" . phpversion();

function sendMail($to, $subject, $message)
{
    global $headers;
    return mail($to, $subject, $message, $headers);
}
