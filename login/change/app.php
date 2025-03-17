<?php
// login/change/app.php
if (!isset($_SESSION[alias() . '_change_password']) || $_SESSION[alias() . '_change_password'] !== true) {
    redirect(uri() . '/login');
}

$appTitle = $page = 'Change Password';
$email = isset($_SESSION[alias() . '_email']) ? $_SESSION[alias() . '_email'] : '';
$oldPassword = $password = $passwordConfirm = $generatePassword = null;

if (isset($_POST['change-password'])) {
    $showAlert = true;
    $success = false;
    $password = sanitize($_POST['password']);
    $passwordConfirm = sanitize($_POST['password-confirm']);

    if (empty($password) || empty($passwordConfirm)) {
        $message = 'All fields in asterisk (*) are required.';
        return;
    }

    if ($password !== $passwordConfirm) {
        $message = 'The new password you entered do not match.';
        return;
    }

    if (!checkPasswordStrength($passwordConfirm)) {
        $message = 'The new password you entered does not meet the requirements specified above.';
        return;
    }

    updateAccountPassword($userId, hashPassword($passwordConfirm), 'Changed');

    if (affectedRows()) {
        $message = 'Your password has been updated successfully.';
        $success = true;
        $oldPassword = $password = $passwordConfirm = $generatePassword = null;
        createSystemLog($stationId, $userId, 'Updated password', $userId, clientIp());
        unset($_SESSION[alias() . '_change_password']);
        redirect(uri() . '/login');
    } else {
        $message = 'No changes have been made to your password.';
    }
}
