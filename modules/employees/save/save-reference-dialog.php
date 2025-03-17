<?php
// modules/employees/save/save-reference-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/references.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$referenceId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$name = $address = $contact = '';
$modalTitle = 'Add Reference';

if (isset($referenceId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Reference' : 'Edit Reference';
    $references = reference($employeeId, $referenceId);

    if (numRows($references) > 0) {
        $reference = fetchArray($references);
        $referenceId = $reference['no'];
        $name = $reference['name'];
        $address = $reference['address'];
        $contact = $reference['telephone'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="mb-0">Name: <?php showAsterisk() ?></label>
                    <input type="text" id="name" name="name" class="form-control" title="Required field" value="<?= $name ?>" required>
                </div>

                <div class="form-group">
                    <label for="address" class="mb-0">Address: <?php showAsterisk() ?></label>
                    <input type="text" id="address" name="address" class="form-control" title="Required field" value="<?= $address ?>" required>
                </div>

                <div class="form-group">
                    <label for="telephone" class="mb-0">Contact Number: <?php showAsterisk() ?></label>
                    <input type="text" id="telephone" name="telephone" class="form-control" title="Required field" value="<?= $contact ?>" required>
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
                <button type="submit" class="btn btn-primary" name="save-reference">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>