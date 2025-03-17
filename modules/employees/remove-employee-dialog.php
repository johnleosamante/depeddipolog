<?php
// modules/employees/remove-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employees = employee($employeeId);
$modalTitle = 'Employee not found';
$hasEmployee = false;

if (numRows($employees) > 0) {
    $employee = fetchAssoc($employees);
    $employeeId = $employee['id'];
    $employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
    $sex = $employee['sex'];
    $status = $employee['status'];
    $positions = fetchAssoc(position($employeeId));
    $stationId = $positions['station_id'];
    $station = $positions['station'];
    $positionId = $positions['position_id'];
    $position = $positions['position'];
    $depedEmail = $employee['email'];
    $picture = uri() . '/' . $employee['picture'];
    $modalTitle = 'Remove Employee';
    $hasEmployee = true;
}
?>

<div class="modal-dialog <?= !$hasEmployee ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST">
            <div class="modal-body">
                <?php if ($hasEmployee) {
                    employeeProfile($picture, $employeeName, $sex, $depedEmail, $position, $station, $status);
                ?>
                    <hr>
                    <div class="form-group">
                        <label for="reason" class="mb-0">Reason <?php showAsterisk() ?></label>
                        <select id="reason" name="reason" class="form-control" title="Select reason of removal..." required>
                            <option value="">Select reason...</option>
                            <option value="Transferred">Transferred</option>
                            <option value="Resigned">Resigned</option>
                            <option value="Retired">Retired</option>
                            <option value="Suspended">Suspended</option>
                            <option value="Dismissed">Dismissed</option>
                            <option value="Deceased">Deceased</option>
                            <option value="Duplicate">Duplicate</option>
                        </select>
                    </div>

                    <?php requiredLegend(0) ?>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasEmployee) : ?>
                    <input type="hidden" name="verifier" value="<?= $_GET['id'] ?>">
                    <button class="btn btn-danger" name="remove-employee" type="submit">Continue</button>
                <?php endif;

                cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>