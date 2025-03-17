<?php
// login/reset/app.php
$userEmail = null;

if (isset($_POST['reset-password'])) {
    $showAlert = true;
    $success = false;
    $userEmail = sanitize($_POST['email']);

    if (empty($userEmail)) {
        $message = 'Email address is required.';
        return;
    }

    if (!isValidEmail($userEmail, 'deped.gov.ph')) {
        $message = 'Please use your DepEd Email Address.';
        return;
    }

    $accounts = account($userEmail);

    if (numRows($accounts) === 0) {
        $message = 'Sorry, we do not recognize the email address that you have given. Check for misspelled words and try again.';
        return;
    }

    $employeeId = fetchAssoc($accounts)['id'];

    $temporaryPassword = sanitize(generateStrongRandomPassword());

    updateAccountPassword($employeeId, hashPassword($temporaryPassword), 'Default');

    if (affectedRows()) {
        $emailMessage = 'Good day! You request for password reset has been approved!' . PHP_EOL . PHP_EOL . 'Your temporary password is: ' . $temporaryPassword . PHP_EOL . PHP_EOL . 'Please login to: ' . uri() . '/login to confirm.' . PHP_EOL . PHP_EOL . 'If you did not request this change please contact us for assistance. Thank you.';

        if (sendMail($userEmail, 'Employee Password Reset', $emailMessage)) {
            $message = 'An email has been sent successfully to [' . $userEmail . '].';
            $userEmail = null;
            $success = true;
            return;
        }
    }

    $message = 'An email to [' . $userEmail . '] was not sent successfully. Please contact the administrator instead.';
}
