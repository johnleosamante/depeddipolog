<?php
// modules/employees/save/save-recognition-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$recognitionId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$recognition = '';
$modalTitle = 'Add Recognition';

if (isset($recognitionId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Recognition' : 'Edit Recognition';
    $recognitionDataSet = recognition($employeeId, $recognitionId);

    if (numRows($recognitionDataSet) > 0) {
        $recognitionData = fetchArray($recognitionDataSet);
        $recognitionId = $recognitionData['no'];
        $recognition = $recognitionData['recognition'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="recognition" class="mb-0">Non-Academic Distinction / Recognition: <?php showAsterisk() ?></label>
                    <input id="recognition" type="text" name="recognition" class="form-control" title="Required field" value="<?= $recognition ?>" required>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= isset($_GET['e']) ? $_GET['e'] : null ?>">
                <?php
                $verifier = isset($_GET['id']) ? $_GET['id'] : null;
                $verifier = $employeeId === $copiedId ? null : $verifier;
                ?>
                <input type="hidden" name="data-verifier" value="<?= $verifier ?>">
                <button type="submit" class="btn btn-primary" name="save-recognition">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>