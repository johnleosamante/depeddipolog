<?php
// modules/employees/tabs/membership.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'membership', 'show active') ?>" id="membership">
    <?php if ($editMode) : ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/employees/save/save-membership-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Membership', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="100%">Membership in Association / Organization</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $organizations = memberships($employeeId);

                    if (numRows($organizations) > 0) {
                        while ($membership = fetchAssoc($organizations)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= $membership['organization'] ?></td>
                                <?php if ($editMode) : ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/employees/save/save-membership-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($membership['no']), 'Edit', 'fa-edit', 'Edit Membership');
                                                modalDropdownItem(uri() . '/modules/employees/save/save-membership-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($membership['no']), 'Copy', 'fa-copy', 'Copy Membership') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-membership-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($membership['no']), 'Delete', 'fa-trash', 'Delete Membership') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endwhile;
                    } else { ?>
                        <tr>
                            <td class="align-middle" colspan="<?= $editMode ? '2' : '1' ?>">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="100%">Membership in Association / Organization</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>