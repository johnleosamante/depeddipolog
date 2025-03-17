<?php
// modules/employees/tabs/special-skills.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'special-skills', 'show active') ?>" id="special-skills">
    <?php if ($editMode) : ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/employees/save/save-special-skill-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Special Skill / Hobby', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="100%">Special Skills &amp; Hobbies</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $skills = specialSkills($employeeId);

                    if (numRows($skills) > 0) {
                        while ($skill = fetchAssoc($skills)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= $skill['skill'] ?></td>
                                <?php if ($editMode) : ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/employees/save/save-special-skill-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($skill['no']), 'Edit', 'fa-edit', 'Edit Special Skill / Hobby');
                                                modalDropdownItem(uri() . '/modules/employees/save/save-special-skill-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($skill['no']), 'Copy', 'fa-copy', 'Copy Special Skill / Hobby') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-special-skill-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($skill['no']), 'Delete', 'fa-trash', 'Delete Special Skill / Hobby') ?>
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
                        <th class="align-middle" width="100%">Special Skills &amp; Hobbies</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>