<?php
// modules/employees/tabs/civil-service-eligibility.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'civil-service-eligibility', 'show active') ?>" id="civil-service-eligibility">
    <?php if ($editMode) : ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/employees/save/save-eligibility-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Civil Service Eligibility', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="35%">Career Services / RA 1080 (Board / Bar) Under Special Laws / CES / CSEE Barangay Eligibility / Driver's License</th>
                        <th class="align-middle" width="5%">Rating</th>
                        <th class="align-middle" width="10%">Date of Examination / Conferment</th>
                        <th class="align-middle" width="30%">Place of Examination / Conferment</th>
                        <th class="align-middle" width="10%">License Number</th>
                        <th class="align-middle" width="10%">Date of Validity</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $eligibilities = eligibilities($employee['id']);

                    if (numRows($eligibilities) > 0) {
                        while ($eligibility = fetchAssoc($eligibilities)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= $eligibility['eligibility'] ?></td>
                                <td class="align-middle"><?= toHandleNull($eligibility['rating'], 'N/A') ?></td>
                                <td class="align-middle"><?= toDate($eligibility['date']) ?></td>
                                <td class="align-middle"><?= $eligibility['place'] ?></td>
                                <td class="align-middle"><?= toHandleNull($eligibility['license'], 'N/A') ?></td>
                                <td class="align-middle">
                                    <?php
                                    echo $eligibility['isapplicable'] ? toDate($eligibility['validity'], 'm/d/Y', 'N/A') : 'N/A';
                                    ?>
                                </td>
                                <?php if ($editMode) : ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/employees/save/save-eligibility-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($eligibility['no']), 'Edit', 'fa-edit', 'Edit Eligibility');
                                                modalDropdownItem(uri() . '/modules/employees/save/save-eligibility-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($eligibility['no']), 'Copy', 'fa-copy', 'Copy Eligibility') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-eligibility-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($eligibility['no']), 'Delete', 'fa-trash', 'Delete Eligibility') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endwhile;
                    } else { ?>
                        <tr>
                            <td colspan="<?= $editMode ? '7' : '6' ?>" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="35%">Career Services / RA 1080 (Board / Bar) Under Special Laws / CES / CSEE Barangay Eligibility / Driver's License</th>
                        <th class="align-middle" width="10%">Rating</th>
                        <th class="align-middle" width="10%">Date of Examination / Conferment</th>
                        <th class="align-middle" width="25%">Place of Examination / Conferment</th>
                        <th class="align-middle" width="10%">License Number</th>
                        <th class="align-middle" width="10%">Date of Validity</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>