<?php
// modules/districts/page.php
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
            <li class="breadcrumb-item active">Districts</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isDmis) {
            contentTitleWithModal('Districts', uri() . '/modules/districts/save-district-dialog.php', 'Add', 'fa-plus');
        } else {
            contentTitle('Districts');
        } ?>
    </div>

    <div class="card-body">
        <?php if ($isDmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'districts'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="30%">District</th>
                        <th class="align-middle" width="45%">Supervisor</th>
                        <th class="align-middle" title="Elementary Schools" width="5%">ES</th>
                        <th class="align-middle" title="High Schools" width="5%">HS</th>
                        <th class="align-middle" title="Integrated Schools" width="5%">IS</th>
                        <th class="align-middle" width="5%">Total</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = districts();
                    while ($row = fetchAssoc(($query))) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle text-center"><?php linkItem(customUri($activeApp, 'District Information', $row['id']), $row['name']) ?></td>
                            <td class="align-middle">
                                <div>
                                    <?php if ($isHrmis) {
                                        linkItem(customUri('hrmis', 'Employee Information', $row['psds']), userName($row['psds']));
                                    } else {
                                        modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['psds']), userName($row['psds']));
                                    } ?>
                                </div>
                                <div class="small"><?= fetchAssoc(position($row['psds']))['position'] ?></div>
                            </td>
                            <?php
                            $schoolCount = districtSchoolCount($row['id']);
                            $es = $hs = $is = $total = 0;

                            if (numRows($schoolCount) > 0) {
                                $count = fetchAssoc($schoolCount);
                                $es = $count['es'];
                                $hs = $count['hs'];
                                $is = $count['is'];
                                $total = $count['total'];
                            }
                            ?>
                            <td class="align-middle"><?= toHandleNull($es, '0') ?></td>
                            <td class="align-middle"><?= toHandleNull($hs, '0') ?></td>
                            <td class="align-middle"><?= toHandleNull($is, '0') ?></td>
                            <td class="align-middle"><?= $total ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php
                                        linkDropdownItem(customUri($activeApp, 'District Information', $row['id']), 'View', 'fa-eye', 'View District');
                                        if ($isDmis) {
                                            modalDropdownItem(uri() . '/modules/districts/save-district-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit District');
                                            if ((int)$total === 0) { ?>
                                                <div class="dropdown-divider"></div>
                                        <?php
                                                modalDropdownItem(uri() . '/modules/districts/delete-district-dialog.php?id=' . cipher($row['id']), 'Delete', 'fa-trash', 'Delete District');
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="30%">District</th>
                        <th class="align-middle" width="45%">Supervisor</th>
                        <th class="align-middle" title="Elementary Schools" width="5%">ES</th>
                        <th class="align-middle" title="High Schools" width="5%">HS</th>
                        <th class="align-middle" title="Integrated Schools" width="5%">IS</th>
                        <th class="align-middle" width="5%">Total</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>