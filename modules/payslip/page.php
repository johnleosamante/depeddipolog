<?php
// modules/payslip/page.php
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employeeId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;

if ($isPis && $userId !== $employeeId) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$employees = employee($employeeId);

if (numRows($employees) > 0) {
    $employee = fetchAssoc($employees);
    $employeeId = $employee['id'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);

$uploadDirectory = root() . '/uploads/payslip/' . $employeeId;

if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Payslip</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithModal('Payslip : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), uri() . '/modules/payslip/save-payslip-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus') ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="25%">Uploaded on</th>
                        <th class="align-middle" width="75%">Description</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $payslips = payslips($employeeId);

                    while ($payslip = fetchAssoc($payslips)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= toDateTime($payslip['updated_at']) ?></td>
                            <td class="align-middle text-left"><?= $payslip['description'] ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-righ shadow animated--fade-in">
                                        <?php
                                        previewLinkDropdownItem(uri() . '/' . $payslip['filename'], 'Preview', 'fa-eye', 'Preview ' . $payslip['description']);
                                        downloadLinkDropdownItem(uri() . '/' . $payslip['filename'], 'Download', 'fa-download', 'Download ' . $payslip['description'], $payslip['description'] . '.' . $payslip['ext'], true);
                                        modalDropdownItem(uri() . '/modules/payslip/save-payslip-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($payslip['id']), 'Edit', 'fa-edit', 'Edit Payslip') ?>
                                        <div class="dropdown-divider"></div>
                                        <?php modalDropdownItem(uri() . '/modules/payslip/delete-payslip-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($payslip['id']), 'Delete', 'fa-trash', 'Delete Payslip');
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="25%">Uploaded on</th>
                        <th class="align-middle" width="75%">Description</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>