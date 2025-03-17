<?php
// modules/users/view-user-dialog.php
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
$depedEmail = $temporaryPassword = '';

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
    $modalTitle = 'Reset User Password';
    $hasEmployee = true;
    $randomPassword = generateStrongRandomPassword();
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
                    <div class="text-center bg-secondary text-light rounded p-2 h2 mt-3 mb-0"><?= $randomPassword ?></div>
                    <div class="text-center mt-1 small"><em>The user will receive an email containing the above code to be used as the temporary password.</em></div>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasEmployee) : ?>
                    <input type="hidden" name="verifier" value="<?= $_GET['id'] ?>">
                    <input type="hidden" name="data-verifier" value="<?= cipher($randomPassword) ?>">
                    <button class="btn btn-danger" name="reset-user" type="submit">Continue</button>
                <?php endif;

                cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>