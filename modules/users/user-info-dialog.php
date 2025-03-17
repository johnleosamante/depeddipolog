<?php
// modules/users/user-info-dialog.php
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
    $picture = file_exists(root() . '/' . $employee['picture']) ? uri() . '/' . $employee['picture'] : uri() . '/assets/img/user.png';
    $modalTitle = 'Employee Information';
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
                } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>