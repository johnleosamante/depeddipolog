<?php
// modules/sections/page.php
if (!$isHrmis && !$isHrtdms && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?php echo uri() . '/' . $activeApp; ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Sections</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isDmis) {
            contentTitleWithModal('Sections', uri() . '/modules/sections/save-section-dialog.php', 'Add', 'fa-plus');
        } else {
            contentTitle('Sections');
        } ?>
    </div>

    <div class="card-body">
        <?php if ($isDmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'sections'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success'); ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="25%">Section</th>
                        <th class="align-middle" width="25%">Functional Division</th>
                        <th class="align-middle" width="30%">Section Head</th>
                        <th class="align-middle text-mars" width="5%"><i class="fa fa-user fw"></i> Male</th>
                        <th class="align-middle text-venus" width="5%"><i class="fa fa-user fw"></i> Female</th>
                        <th class="align-middle" width="5%"><i class="fa fa-user-friends fw"></i> Total</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = sections();
                    while ($row = fetchAssoc($query)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle text-center"><?php linkItem(customUri($activeApp, 'Section Information', $row['id']), $row['name']); ?></td>
                            <td class="align-middle text-center"><?php echo $row['division']; ?></td>
                            <td class="align-middle">
                                <div>
                                    <?php if ($isHrmis) {
                                        linkItem(customUri('hrmis', 'Employee Information', $row['head']), userName($row['head']));
                                    } else {
                                        modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['head']), userName($row['head']));
                                    } ?>
                                </div>
                                <div class="small"><?php echo fetchAssoc(position($row['head']))['position']; ?></div>
                            </td>
                            <?php
                            $sectionCount = sectionEmployeeCount($row['id']);
                            $male = $female = $total = 0;

                            if (numRows($sectionCount) > 0) {
                                $count = fetchAssoc($sectionCount);
                                $male = $count['male'];
                                $female = $count['female'];
                                $total = $count['total'];
                            }
                            ?>
                            <td class="align-middle text-mars"><?php echo $male; ?></td>
                            <td class="align-middle text-venus"><?php echo $female; ?></td>
                            <td class="align-middle"><?php echo $total; ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis(); ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php
                                        linkDropdownItem(customUri($activeApp, 'Section Information', $row['id']), 'View', 'fa-eye', 'View Section');
                                        if ($isDmis) {
                                            modalDropdownItem(uri() . '/modules/sections/save-section-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit Section');
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="25%">Section</th>
                        <th class="align-middle" width="25%">Functional Division</th>
                        <th class="align-middle" width="30%">Section Head</th>
                        <th class="align-middle text-mars" width="5%">Male</th>
                        <th class="align-middle text-venus" width="5%">Female</th>
                        <th class="align-middle" width="5%">Total</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>