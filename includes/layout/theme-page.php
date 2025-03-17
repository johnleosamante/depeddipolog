<?php
// includes/layout/theme-page.php
require_once('app.php');

$url = isset($_GET['v']) ? sanitize(decode($_GET['v'])) : null;

if (http_response_code() === 200) {
    $page = isset($url) && !empty($url) ? $url . ' | ' . $appTitle : $appTitle;
} else {
    switch (http_response_code()) {
        case 403:
            $page = 'Access Denied';
            break;
        case 404:
            $page = 'Page Not Found';
            break;
        default:
            $page = 'Unexpected Error';
            break;
    }
}

require_once(root() . '/includes/layout/components.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once(root() . '/includes/layout/header.php') ?>
    <?php if ($enableScripts) : ?>
        <link rel="stylesheet" href="<?= uri() ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= uri() ?>/assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
    <?php endif ?>
</head>

<body id="page-top" class="background-cover">
    <div id="layout">
        <div id="layout-content" class="container-xl">
            <div id="main-content" class="row justify-content-center">
                <?php require_once('page.php') ?>
            </div>
        </div>

        <div id="layout-footer">
            <?php require_once(root() . '/includes/layout/footer.php') ?>
        </div>
    </div>

    <?php scrollToTop() ?>

    <script src="<?= uri() ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= uri() ?>/assets/js/sb-admin-2.min.js"></script>

    <?php if ($enableScripts) : ?>
        <script src="<?= uri() ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= uri() ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="<?= uri() ?>/assets/vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= uri() ?>/assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <?php endif ?>

    <script src="<?= uri() ?>/assets/js/script.js?v=1.2"></script>
</body>

</html>