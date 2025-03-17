<?php
// dts/track/page.php
?>
<div class="col-12">
    <div class="mt-5 mb-4 text-center">
        <?php displayLogo(120, 120, '0', uri(), title()) ?>
        <h1 class="my-2"><?= $appTitle ?></h1>
    </div>

    <?php
    if (!isset($url) || $url === 'track-document') {
        require_once('track-document.php');
    } else {
        $file = '';

        switch ($url) {
            case 'Document Information':
                $file = 'document-information.php';
                break;
            default:
                $file = 'track-document.php';
                break;
        }
        require_once("{$file}");
    }
    ?>

    <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/login' ?>" title="Go to login page">Already have an account? Login instead</a>
</div>