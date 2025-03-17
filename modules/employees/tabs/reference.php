<?php
// modules/employees/tabs/reference.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'reference', 'show active') ?>" id="reference">
    <?php if ($editMode) : ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/employees/save/save-reference-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Reference', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="40%">Name</th>
                        <th class="align-middle" width="45%">Address</th>
                        <th class="align-middle" width="15%">Contact Number</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $references = references($employeeId);

                    if (numRows($references) > 0) {
                        while ($reference = fetchAssoc($references)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= $reference['name'] ?></td>
                                <td class="align-middle"><?= toHandleNull($reference['address'], 'N/A') ?></td>
                                <td class="align-middle"><?= toHandleNull($reference['telephone'], 'N/A') ?></td>
                                <?php if ($editMode) : ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/employees/save/save-reference-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($reference['no']), 'Edit', 'fa-edit', 'Edit Reference');
                                                modalDropdownItem(uri() . '/modules/employees/save/save-reference-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($reference['no']), 'Copy', 'fa-copy', 'Copy Reference') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-reference-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($reference['no']), 'Delete', 'fa-trash', 'Delete Reference') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php
                        endwhile;
                    } else { ?>
                        <tr>
                            <td colspan="<?= $editMode ? '4' : '3' ?>" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="40%">Name</th>
                        <th class="align-middle" width="45%">Address</th>
                        <th class="align-middle" width="15%">Contact Number</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>