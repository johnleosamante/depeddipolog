<?php
// modules/settings/index.php
require_once('app.php');
messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('Settings') ?>
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link text-secondary active" href="#profile-photo" data-toggle="tab">Profile Photo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#contact-details" data-toggle="tab">Contact Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#professional-title" data-toggle="tab">Professional Title</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#password-change" data-toggle="tab">Password Change</a>
            </li>
        </ul>

        <div class="tab-content pt-2 px-2">
            <?php
            require_once('profile-photo.php');
            require_once('contacts.php');
            require_once('professional-title.php');
            require_once('password.php');
            ?>
        </div>
    </div>
</div>