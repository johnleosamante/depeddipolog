<?php
// modules/employees/save/save-membership-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/membership.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$membershipId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$membership = '';
$modalTitle = 'Add Membership in Association / Organization';

if (isset($membershipId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Membership in Association / Organization' : 'Edit Membership in Association / Organization';
    $membershipDataSet = membership($employeeId, $membershipId);

    if (numRows($membershipDataSet) > 0) {
        $membershipData = fetchArray($membershipDataSet);
        $membershipId = $membershipData['no'];
        $membership = $membershipData['organization'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="membership" class="mb-0">Membership in Association / Organization: <?php showAsterisk() ?></label>
                    <input id="membership" type="text" name="membership" class="form-control" title="Required field" value="<?= $membership ?>" required>
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
                <button type="submit" class="btn btn-primary" name="save-membership">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>