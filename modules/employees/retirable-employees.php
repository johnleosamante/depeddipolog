<?php
// modules/employees/active-employees.php
if (!$isHrmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Retirable</li>
        </ol>
    </nav>

    <div class="d-inline-block">
        <?php modalButtonSplit(uri() . '/modules/employees/save-employee-dialog.php', 'Add Employee', 'fa-user-plus') ?>
    </div>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Retirable Employees', uri() . '/hrmis') ?>
    </div>

    <div class="card-body">
        <?php if ($isHrmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'retirable-employees'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="25%">Name</th>
                        <th class="align-middle" width="15%">Date of Birth</th>
                        <th class="align-middle" width="5%">Age</th>
                        <th class="align-middle" width="20%">Position</th>
                        <th class="align-middle" width="25%">Station</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = retirableEmployees();
                    while ($row = fetchArray($query)) :
                        $employeeName =  toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
                        $photo = file_exists(root() . '/' . $row['picture']) ? uri() . '/' . $row['picture'] : uri() . '/assets/img/user.png';
                    ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div class="image-container">
                                    <span class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                                        <img height="100%" src="<?= $photo ?>" alt="<?= $employeeName ?>">
                                    </span>
                                    <div class="sex-sign"><?php sex($row['sex']) ?></div>
                                </div>
                            </td>
                            <td class="align-middle text-left"><?php linkItem(customUri('hrmis', 'Employee Information', $row['id']), $employeeName) ?></td>
                            <td class="align-middle"><?= toDate($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F j, Y') ?></td>
                            <td class="align-middle">
                                <?= getDateDifference($row['year'], $row['month'], $row['day']) ?>
                            </td>
                            <td class="align-middle"><?= fetchAssoc(positions($row['position']))['position'] ?></td>
                            <td class="align-middle">
                                <?php linkItem(customUri($activeApp, 'School Information', $row['station']), fetchAssoc(schoolById($row['station']))['name']) ?>
                            </td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php
                                        linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'Employee Information', 'fa-user', 'Employee Information');
                                        linkDropdownItem(customUri('hrmis', 'Service Record', $row['id']), 'Service Record', 'fa-file-alt', 'Service Record');
                                        linkDropdownItem(customUri('hrmis', '201 Files', $row['id']), '201 Files', 'fa-folder-open', '201 Files');
                                        linkDropdownItem(customUri('hrmis', 'Trainings', $row['id']), 'Trainings', 'fa-chalkboard-teacher', 'Trainings');
                                        modalDropdownItem(uri() . '/modules/psipop/save-psipop-dialog.php?id=' . cipher($row['id']), 'PSIPOP', 'fa-file-contract', 'Personal Services Itemization &amp; Plantilla of Personnel');
                                        ?>
                                        <div class="dropdown-divider"></div>
                                        <?php linkDropdownItem(customUri('hrmis', 'Edit History', $row['id']), 'Edit History', 'fa-history', 'Edit History') ?>
                                        <div class="dropdown-divider"></div>
                                        <?php modalDropdownItem(uri() . '/modules/employees/reassign-employee-dialog.php?id=' . cipher($row['id']), 'Reassign', 'fa-share', 'Reassign Employee');
                                        modalDropdownItem(uri() . '/modules/employees/promote-employee-dialog.php?id=' . cipher($row['id']), 'Promote', 'fa-thumbs-up', 'Promote Employee');
                                        modalDropdownItem(uri() . '/modules/employees/remove-employee-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Remove Employee') ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="25%">Name</th>
                        <th class="align-middle" width="15%">Date of Birth</th>
                        <th class="align-middle" width="5%">Age</th>
                        <th class="align-middle" width="20%">Position</th>
                        <th class="align-middle" width="25%">Station</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>