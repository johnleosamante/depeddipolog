<?php
// modules/employees/employee-tabs.php
?>

<div class="row">
    <?php
    cardMini('Employee Information', customUri('hrmis', 'Employee Information', $employeeId), 'fa-user-tie', 'primary');
    cardMini('Service Record', customUri('hrmis', 'Service Record', $employeeId), 'fa-file-alt', 'success');
    cardMini('201 Files', customUri('hrmis', '201 Files', $employeeId), 'fa-folder-open', 'info');
    cardMini('Trainings', customUri('hrmis', 'Trainings', $employeeId), 'fa-chalkboard-teacher', 'warning');
    cardMiniModal('PSIPOP', uri() . '/modules/psipop/save-psipop-dialog.php?id=' . cipher($employeeId), 'fa-file-contract', 'danger');
    cardMini('Edit History', customUri('hrmis', 'Edit History', $employeeId), 'fa-history', 'secondary');
    ?>
</div>