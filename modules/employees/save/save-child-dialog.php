<?php
// modules/employees/save/save-child-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/family-background.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$childId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$fname = $mname = $lname = $ext = '';
$bdate = date('Y-M-d');
$modalTitle = 'Add Child Name';

if (isset($childId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Child Name' : 'Edit Child Name';
    $children = child($employeeId, $childId);

    if (numRows($children) > 0) {
        $child = fetchArray($children);
        $childId = $child['no'];
        $fname = $child['first'];
        $mname = $child['middle'];
        $lname = $child['last'];
        $ext = $child['ext'];
        $bdate = $child['dob'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="clast" class="mb-0">Last Name <?php showAsterisk() ?></label>
                    <input id="clast" type="text" name="clast" class="form-control" placeholder="ex. DELA CRUZ" title="ex. DELA CRUZ" value="<?= $lname ?>" required>
                </div>

                <div class="form-group">
                    <label for="cfirst" class="mb-0">First Name <?php showAsterisk() ?></label>
                    <input id="cfirst" type="text" name="cfirst" class="form-control" placeholder="ex. JUAN" title="ex. JUAN" value="<?= $fname ?>" required>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="cmiddle" class="mb-0">Middle Name</label>
                            <input id="cmiddle" type="text" name="cmiddle" class="form-control" placeholder="ex. BAUTISTA" title=" ex. BAUTISTA, Leave blank if not applicable" value="<?= $mname ?>">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="cext" class="mb-0">Extension</label>
                            <input id="cext" type="text" name="cext" class="form-control" placeholder="ex. JR., SR., III" title=" ex. JR., SR., III, Leave blank if not applicable" value="<?= $ext ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cdob" class="mb-0">Date of Birth <?php showAsterisk() ?></label>
                    <input id="cdob" type="date" name="cdob" class="form-control" title="Set child date of birth..." value="<?= toDate($bdate, "Y-m-d") ?>" required>
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
                <button type="submit" class="btn btn-primary" name="save-child">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>