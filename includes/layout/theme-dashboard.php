<?php
// includes/layout/header.php
require_once('app.php');

$url = isset($_GET['v']) ? sanitize(decode($_GET['v'])) : null;
$page = isset($url) && !empty($url) ? $url . ' | ' . $appTitle : $appTitle;
$isPis = $activeApp === 'pis';
$isDts = $activeApp === 'dts';
$isHrmis = $activeApp === 'hrmis';
$isHrtdms = $activeApp === 'hrtdms';
$isDmis = $activeApp === 'dmis';

require_once(root() . '/includes/layout/components.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once(root() . '/includes/layout/header.php') ?>
    <link rel="stylesheet" href="<?= uri() ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= uri() ?>/assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <div class="sidebar-brand d-flex align-items-center justify-content-center">
                <a href="<?= uri() ?>" title="<?= title() ?>">
                    <img class="sidebar-brand-icon" src="<?= uri() ?>/uploads/division/division.png" alt="<?= title() ?>" width="60">
                </a>
            </div>

            <?php
            sidebarDivider();
            sidebarMenuItem(uri() . '/' . $activeApp, 'Dashboard', 'fa-tachometer-alt', !isset($url));
            require_once('sidebar-menu.php');
            sidebarDivider('3', true);
            sidebarToggle();
            ?>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require_once(root() . '/includes/layout/header-menu.php') ?>

                <div class="container-fluid my-4">
                    <?php require_once(root() . '/includes/layout/content.php') ?>
                </div>
            </div>

            <?php require_once(root() . '/includes/layout/footer.php') ?>
        </div>
    </div>

    <?php
    scrollToTop();
    modal();
    ?>

    <script src="<?= uri() ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= uri() ?>/assets/js/sb-admin-2.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= uri() ?>/assets/js/script.js?v=1.2.2"></script>
</body>

</html>