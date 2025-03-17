<?php
// modules/settings/app.php
$oldPassword = $password = $passwordConfirm = $generatePassword = null;

if (isset($_POST['update-password'])) {
    $showAlert = true;
    $success = false;
    $oldPassword = sanitize($_POST['old-password']);
    $password = sanitize($_POST['password']);
    $passwordConfirm = sanitize($_POST['password-confirm']);
    $generatePassword = sanitize($_POST['generate-password']);

    if (empty($oldPassword) || empty($password) || empty($passwordConfirm)) {
        $message = 'All fields in asterisk (*) are required.';
        return;
    }

    if (numRows(accountPassword($userId, hashPassword($oldPassword))) === 0) {
        $message = 'You have entered an incorrect old password.';
        $oldPassword = $password = $passwordConfirm = $generatePassword = null;
        return;
    }

    if ($password !== $passwordConfirm) {
        $message = 'The new password you entered do not match.';
        return;
    }

    if (!checkPasswordStrength($passwordConfirm)) {
        $message = 'The new password you entered does not meet the recommendations specified below.';
        return;
    }

    if ($passwordConfirm === $oldPassword) {
        $message = 'The new password you entered matches your old password.';
        return;
    }

    updateAccountPassword($userId, hashPassword($passwordConfirm), 'Changed');

    if (affectedRows()) {
        $message = 'Your password has been updated successfully.';
        $success = true;
        $oldPassword = $password = $passwordConfirm = $generatePassword = null;
        createSystemLog($stationId, $userId, 'Updated password', $userId, clientIp());
    } else {
        $message = 'No changes have been made to your password.';
    }
}

if (isset($_POST['update-contact-details'])) {
    $alternateEmail = sanitize($_POST['alternate-email']);
    $alternateMobile = sanitize($_POST['alternate-mobile']);

    updateEmployeeContactDetails($alternateMobile, $alternateEmail, $userId);

    $showAlert = true;

    if (affectedRows()) {
        $message = 'Your contact details have been updated successfully.';
        createSystemLog($stationId, $userId, 'Updated contact details', $userId, clientIp());
    } else {
        $message = 'No changes have been made to your contact details.';
        $success = false;
    }
}

if (isset($_POST['update-professional-titles'])) {
    $before = sanitize($_POST['before-title']);
    $after = sanitize($_POST['after-title']);

    updateProfessionalTitles($before, $after, $userId);

    $showAlert = true;

    if (affectedRows()) {
        $message = 'Your professional title have been updated successfully.';
        createSystemLog($stationId, $userId, 'Updated professional titles', $userId, clientIp());
    } else {
        $message = 'No changes have been made to your professional title.';
        $success = false;
    }
}

if (isset($_POST['update-profile-photo'])) {
    $employeePhoto = isset($_POST['image-verifier']) ? sanitize(decipher($_POST['image-verifier'])) : '';
    $employeeId = $userId;

    if (is_uploaded_file($_FILES['image-upload']['tmp_name'])) {
        $temp = $_FILES['image-upload']['tmp_name'];

        if ($_FILES['image-upload']['size'] > $imageUploadSizeLimit) {
            $message = 'The chosen file exceeds the upload file limit (2.5 MB). No changes have been made to personal information.';
            return;
        }

        $mimeType = mime_content_type($temp);
        $allowedFileTypes = ['image/png', 'image/jpeg'];

        if (!in_array($mimeType, $allowedFileTypes)) {
            $message = 'The chosen file is not an image file. No changes have been made to personal information.';
            return;
        }

        $ext = pathinfo($_FILES['image-upload']['name'], PATHINFO_EXTENSION);

        if (!empty($employeePhoto) && file_exists(root() . '/' . $employeePhoto) && basename(root() . '/' . $employeePhoto) !== 'user.png') {
            unlink(root() . '/' . $employeePhoto);
        }

        $uploadDate = date('YmdHis');

        $employeePhoto = "uploads/images/{$employeeId}/{$employeeId}{$uploadDate}.{$ext}";

        move_uploaded_file($temp, '../' . $employeePhoto);
    }

    updateProfilePhoto($employeePhoto, $employeeId);

    $showAlert = true;

    if (!affectedRows()) {
        $message = 'No changes have been made to profile photo.';
        $success = false;
        return;
    }

    $message = 'Profile photo has been updated successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Updated your profile photo', $userId, clientIp());
}
