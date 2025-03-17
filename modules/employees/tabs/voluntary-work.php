<?php
// modules/employees/tabs/voluntary-work.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'voluntary-work', 'show active') ?>" id="voluntary-work">
    <?php if ($editMode) : ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/employees/save/save-voluntary-work-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Voluntary Work', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="45">Name &amp; Address of Organization</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="10%">Number of Hours</th>
                        <th class="align-middle" width="30%">Position / Nature of Work</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $voluntaryWork = voluntaryWorks($employeeId);

                    if (numRows($voluntaryWork) > 0) {
                        while ($voluntary = fetchAssoc($voluntaryWork)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= $voluntary['organization'] ?></td>
                                <td class="align-middle"><?= toDate($voluntary['from']) ?></td>
                                <td class="align-middle"><?= $voluntary['ispresent'] ? 'PRESENT' : toDate($voluntary['to']) ?></td>
                                <td class="align-middle"><?= toHandleNull($voluntary['hours'], 'N/A') ?></td>
                                <td class="align-middle"><?= $voluntary['position'] ?></td>
                                <?php if ($editMode) : ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/employees/save/save-voluntary-work-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($voluntary['no']), 'Edit', 'fa-edit', 'Edit Voluntary Work');
                                                modalDropdownItem(uri() . '/modules/employees/save/save-voluntary-work-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($voluntary['no']), 'Copy', 'fa-copy', 'Copy Voluntary Work') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-voluntary-work-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($voluntary['no']), 'Delete', 'fa-trash', 'Delete Voluntary Work') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endwhile;
                    } else {
                        ?>
                        <tr>
                            <td colspan="<?= $editMode ? '6' : '5' ?>" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="45">Name &amp; Address of Organization</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="10%">Number of Hours</th>
                        <th class="align-middle" width="30%">Position / Nature of Work</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>