<?php
// hrtdms/repository/page.php
?>

<div class="col-12">
    <div class="mt-5 mb-4 text-center">
        <?php displayLogo(120, 120, '0', uri(), title()) ?>
        <h1 class="my-2"><?= $appTitle ?></h1>
    </div>

    <div class="card mt-3 mb-4 mx-auto">
        <?php
        if (!isset($url) || $url === 'conducted-trainings') {
            require_once('conducted-trainings.php');
        } else {
            $file = '';

            switch ($url) {
                case 'Training Details':
                    $file = 'training-details.php';
                    break;
                case '404':
                default:
                    $file = 'conducted-trainings.php';
                    break;
            }

            require_once("{$file}");
        }
        ?>
    </div>

    <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/login' ?>" title="Go to login page">Already have an account? Login instead</a>
</div>