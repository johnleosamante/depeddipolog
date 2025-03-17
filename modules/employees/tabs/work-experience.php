<?php
// modules/employees/tabs/work-experience.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'work-experience', 'show active') ?>" id="work-experience">
    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="18%">Position Title</th>
                        <th class="align-middle" width="27%">Department / Agency / Office / Company</th>
                        <th class="align-middle" width="10%">Monthly Salary</th>
                        <th class="align-middle" width="10%">Salary / Job / Pay Grade &amp; Step Increment</th>
                        <th class="align-middle" width="10%">Status of Appointment</th>
                        <th class="align-middle" width="10%">Government Service</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Actions</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $experiences = experiences($employeeId);

                    if (numRows($experiences) > 0) {
                        while ($experience = fetchAssoc($experiences)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= toDate($experience['from']) ?></td>
                                <td class="align-middle"><?= $experience['ispresent'] ? 'PRESENT' : toDate($experience['to']) ?></td>
                                <td class="align-middle"><?= $experience['position'] ?></td>
                                <td class="align-middle"><?= $experience['organization'] ?></td>
                                <td class="align-middle"><?= !empty($experience['salary']) ? toCurrency($experience['salary']) : 'N/A' ?></td>
                                <td class="align-middle"><?= toHandleNull($experience['sg'], 'N/A') ?></td>
                                <td class="align-middle"><?= $experience['status'] ?></td>
                                <td class="align-middle"><?= $experience['isgovernment'] ?></td>
                                <?php if ($editMode) : ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($experience['no']), 'Edit', 'fa-edit', 'Edit Service Record');
                                                modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($experience['no']), 'Copy', 'fa-copy', 'Copy Service Record') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/service-record/delete-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($experience['no']), 'Delete', 'fa-trash', 'Delete Service Record') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endwhile;
                    } else { ?>
                        <tr>
                            <td colspan="<?= $editMode ? '8' : '7' ?>" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="18%">Position Title</th>
                        <th class="align-middle" width="27%">Department / Agency / Office / Company</th>
                        <th class="align-middle" width="10%">Monthly Salary</th>
                        <th class="align-middle" width="10%">Salary / Job / Pay Grade &amp; Step Increment</th>
                        <th class="align-middle" width="10%">Status of Appointment</th>
                        <th class="align-middle" width="10%">Government Service</th>
                        <?php if ($editMode) : ?>
                            <th class="align-middle" width="5%">Actions</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>