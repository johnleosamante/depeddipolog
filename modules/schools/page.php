<?php
// modules/schools/page.php
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
            <li class="breadcrumb-item active">Schools</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($activeApp === 'dmis') {
            contentTitleWithModal('Schools', uri() . '/modules/schools/save-school-dialog.php', 'Add', 'fa-plus');
        } else {
            contentTitle('Schools');
        }
        ?>
    </div>

    <div class="card-body">
        <?php if ($isHrmis || $isDmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'schools'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">Logo</th>
                        <th class="align-middle" width="25%">School Name / Alias / ID / Address</th>
                        <th class="align-middle" width="10%">District</th>
                        <th class="align-middle" width="10%">Category</th>
                        <th class="align-middle" width="20%">Head of Office</th>
                        <th class="align-middle text-mars" width="5%"><i class="fa fa-user fw"></i> Male</th>
                        <th class="align-middle text-venus" width="5%"><i class="fa fa-user fw"></i> Female</th>
                        <th class="align-middle" width="5%" title="Total Personnel"><i class="fa fa-user-friends fw"></i> Total</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = schools();
                    while ($row = fetchArray($query)) :
                        $logo = !empty($row['logo']) ? uri() . '/' . $row['logo'] : uri() . '/uploads/division/division.png';
                        $schoolName = $row['name'];
                    ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div class="image-container">
                                    <span class="d-flex justify-content-center align-middle school-logo overflow-hidden">
                                        <img height="100%" src="<?= $logo ?>" alt="<?= $schoolName ?>">
                                    </span>
                                </div>
                            </td>
                            <td class="align-middle text-left">
                                <div><?php linkItem(customUri($activeApp, 'School Information', $row['id']), $schoolName . ' (' . $row['alias'] . ')') ?></div>
                                <div class="small"><?= $row['id'] . ' | ' . $row['address'] ?></div>
                            </td>
                            <td class="align-middle">
                                <?php linkItem(customUri($activeApp, 'District Information', $row['district']), fetchAssoc(district($row['district']))['name']) ?>
                            </td>
                            <td class="align-middle"><?= $row['category'] ?></td>
                            <td class="align-middle">
                                <?php if (!empty($row['head'])) : ?>
                                    <div>
                                        <?php if ($isHrmis) {
                                            linkItem(customUri('hrmis', 'Employee Information', $row['head']), userName($row['head']));
                                        } else {
                                            modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['head']), userName($row['head']));
                                        } ?>
                                    </div>
                                <?php
                                    $positions = position($row['head']);
                                    echo numRows($positions) > 0 ? '<div class="small">' . fetchAssoc($positions)['position'] . '</div>' : '';
                                else :
                                    echo 'To be assigned';
                                endif ?>
                            </td>

                            <?php
                            $employeeCount = schoolEmployeeCount($row['id']);
                            $male = $female = $total = 0;

                            if (numRows($employeeCount) > 0) {
                                $count = fetchAssoc($employeeCount);
                                $male = $count['male'];
                                $female = $count['female'];
                                $total = $count['total'];
                            }
                            ?>

                            <td class="align-middle text-mars"><strong><?= $male ?></strong></td>
                            <td class="align-middle text-venus"><strong><?= $female ?></strong></td>
                            <td class="align-middle"><strong><?= $total ?></strong></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php linkDropdownItem(customUri($activeApp, 'School Information', $row['id']), 'View', 'fa-eye', 'View School');

                                        if ($isDmis) {
                                            modalDropdownItem(uri() . '/modules/schools/save-school-dialog.php?id=' . cipher($row['id']) . '&e=' . cipher($row['alias']), 'Edit', 'fa-edit', 'Edit School');
                                            if ((int)$total === 0) { ?>
                                                <div class="dropdown-divider"></div>
                                        <?php
                                                modalDropdownItem(uri() . '/modules/schools/delete-school-dialog.php?id=' . cipher($row['id']), 'Delete', 'fa-trash', 'Delete School');
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
                        <th class="align-middle" width="5%">Logo</th>
                        <th class="align-middle" width="25%">School Name / Alias / ID / Address</th>
                        <th class="align-middle" width="10%">District</th>
                        <th class="align-middle" width="10%">Category</th>
                        <th class="align-middle" width="20%">Head of Office</th>
                        <th class="align-middle text-mars" width="5%">Male</th>
                        <th class="align-middle text-venus" width="5%">Female</th>
                        <th class="align-middle" width="5%" title="Total Personnel">Total</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>