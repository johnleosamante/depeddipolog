<?php
// modules/payslip/save-payslip-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/payslip.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$payslipId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$description = $filename = null;
$modalTitle = 'Add Payslip';

if (isset($payslipId)) {
    $modalTitle = 'Edit Payslip';
    $payslips = payslip($employeeId, $payslipId);

    if (numRows($payslips) > 0) {
        $payslip = fetchAssoc($payslips);
        $payslipId = $payslip['id'];
        $description = $payslip['description'];
        $filename = $payslip['filename'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <input id="file-upload" name="file-upload" type="file" class="w-100">
                </div>

                <div class="form-group">
                    <label for="description" class="mb-0">Description <?php showAsterisk() ?></label>
                    <textarea id="description" name="description" class="form-control" placeholder="Type description..." title="Type payslip description..." rows="3" required><?= $description ?></textarea>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= isset($_GET['e']) ? $_GET['e'] : null ?>">
                <?php
                $verifier = isset($_GET['id']) ? $_GET['id'] : null;
                $filename = !isset($_GET['c']) ? $filename : null;
                ?>
                <input type="hidden" name="data-verifier" value="<?= $verifier ?>">
                <input type="hidden" name="file-verifier" value="<?= cipher($filename) ?>">
                <button type="submit" class="btn btn-primary" name="save-payslip">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>