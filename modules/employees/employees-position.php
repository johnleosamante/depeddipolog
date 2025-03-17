<?php
// modules/employees/employee-positions.php
if (!$isHrmis && !$isHrtdms && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Active Employees') ?>">Employees</a></li>
            <li class="breadcrumb-item active">Positions</li>
        </ol>
    </nav>

    <?php if ($isHrmis) : ?>
        <div class="d-inline-block">
            <?php modalButtonSplit(uri() . '/modules/employees/save-employee-dialog.php', 'Add Employee', 'fa-user-plus') ?>
        </div>
    <?php endif ?>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Employees by Position', uri() . '/hrmis') ?>
    </div>

    <div class="card-body">
        <?php if ($isHrmis || $isDmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <div class="d-inline-block">
                    <?php
                    linkButtonSplit(customUri('export', 'active-employees'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success');

                    if ($isDmis) {
                        linkButtonSplit(customUri('dmis', 'Archived Employees'), 'Archived', 'fa-archive', 'View archived employees', 'danger');
                    }
                    ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="50%">Position</th>
                        <th class="align-middle" width="15%">Male</th>
                        <th class="align-middle" width="15%">Female</th>
                        <th class="align-middle" width="15%">Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    $rows = employeePositions();

                    foreach ($rows as $row) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= $i++ ?></td>
                            <td class="align-middle text-left"><?= $row['position'] ?></td>
                            <td class="align-middle"><?= $row['male'] ?></td>
                            <td class="align-middle"><?= $row['female'] ?></td>
                            <td class="align-middle"><?= $row['total'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class=" align-middle" width="5%">#</th>
                        <th class="align-middle" width="50%">Position</th>
                        <th class="align-middle" width="15%">Male</th>
                        <th class="align-middle" width="15%">Female</th>
                        <th class="align-middle" width="15%">Total</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>