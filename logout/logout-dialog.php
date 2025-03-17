<?php
// logout/logout-dialog.php
require_once('../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$modalTitle = 'Logout';
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
        </div>

        <div class="modal-footer">
            <a class="btn btn-danger" href="<?= uri() . '/logout' ?>">Continue</a>
            <?php cancelModalButton() ?>
        </div>
    </div>
</div>