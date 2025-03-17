<?php
// modules/employees/tabs/recognition.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'recognition', 'show active') ?>" id="recognition">
    <?php if ($editMode) : ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/employees/save/save-recognition-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Recogntion', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="90%">Non-Academic Distinctions / Recognition</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $recognitions = recognitions($employee['id']);

                    if (numRows($recognitions) > 0) {
                        while ($recognition = fetchAssoc($recognitions)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= $recognition['recognition'] ?></td>
                                <?php if ($editMode) : ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/employees/save/save-recognition-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($recognition['no']), 'Edit', 'fa-edit', 'Edit Recognition');
                                                modalDropdownItem(uri() . '/modules/employees/save/save-recognition-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($recognition['no']), 'Copy', 'fa-copy', 'Copy Recognition') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-recognition-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($recognition['no']), 'Delete', 'fa-trash', 'Delete Recognition') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endwhile;
                    } else { ?>
                        <tr>
                            <td colspan="<?= $editMode ? '2' : '1' ?>" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="90%">Non-Academic Distinctions / Recognition</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>