<?php
// modules/sections/section-information.php
if (!$isHrmis && !$isHrtdms && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$sectionId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$sections = section($sectionId);
$section = $sectionName = $head = null;

messageAlert($showAlert, $message, $success);

if (numRows($sections) > 0) {
    $section = fetchAssoc($sections);
    $sectionName = $section['name'];
    $head = $section['head'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$query = sectionUsers($sectionId);
$personnel = numRows($query);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri($activeApp, 'Sections') ?>">Sections</a></li>
            <li class="breadcrumb-item active"><?= $sectionName ?></li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($activeApp === 'dmis') {
            contentTitleWithModal('Section Information: ' . strtoupper($sectionName), uri() . '/modules/sections/save-section-dialog.php?id=' . cipher($sectionId), 'Edit', 'fa-edit');
        } else {
            contentTitleWithLink('Section Information: ' . strtoupper($sectionName), customUri($activeApp, 'Sections'));
        } ?>
    </div>

    <div class="card-body">
        <div class="table-responsive pb-3">
            <table cellspacing="0">
                <tr>
                    <th class="pr-5 align-top" scope="row">Section</th>
                    <td class="text-uppercase"><?= $sectionName ?></td>
                </tr>
                <tr>
                    <th class="pr-5 align-top" scope="row">Section Head</th>
                    <td class="text-uppercase">
                        <div>
                            <?php if ($isHrmis) {
                                linkItem(customUri('hrmis', 'Employee Information', $head), userName($head));
                            } else {
                                modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($head), userName($head));
                            } ?>
                        </div>
                        <div class="small"><?= fetchAssoc(position($head))['position'] ?></div>
                    </td>
                </tr>
                <tr>
                    <th class="pr-5 align-top" scoper="row">Personnel</th>
                    <td class="text-lowercase"><?= $personnel ?></td>
                </tr>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="5%">Employee Number</th>
                        <th class="align-middle" width="25%">Name</th>
                        <th class="align-middle" width="15%">Date of Birth</th>
                        <th class="align-middle" width="5%">Age</th>
                        <th class="align-middle" width="20%">Position</th>
                        <?php if (!$isHrtdms) : ?>
                            <th class="align-middle" width="15%">Email Address</th>
                        <?php else : ?>
                            <th class="align-middle" width="15%">Attended Trainings</th>
                        <?php endif ?>
                        <?php if ($isHrmis) : ?>
                            <th class="align-middel" width="10%">Progress</th>
                        <?php else : ?>
                            <?php if (!$isHrtdms) : ?>
                                <th class="align-middle" width="10%">Contact #</th>
                            <?php endif ?>
                        <?php endif ?>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($row = fetchArray($query)) :
                        $employeeName =  toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
                        $photo = uri() . '/' . $row['picture'];
                    ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div class="image-container">
                                    <span class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                                        <img height="100%" src="<?= $photo ?>" alt="<?= $employeeName ?>">
                                    </span>
                                    <div class="sex-sign"><?php sex($row['sex']) ?></div>
                                </div>
                            </td>
                            <td class="align-middle"><?= toHandleNull($row['agency_id'], 'N/A') ?></td>
                            <td class="align-middle text-left">
                                <?php if ($isHrmis) {
                                    linkItem(customUri('hrmis', 'Employee Information', $row['id']), $employeeName);
                                } elseif ($isDmis) {
                                    modalItem(uri() . '/modules/users/edit-user-dialog.php?id=' . cipher($row['id']), $employeeName);
                                } else {
                                    modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['id']), $employeeName);
                                } ?>
                            </td>
                            <td class="align-middle"><?= toDate($row['month'] . '/' . $row['day'] . '/' . $row['year'], 'F j, Y') ?></td>
                            <td class="align-middle"><?= getDateDifference($row['year'], $row['month'], $row['day']) ?></td>
                            <td class="align-middle"><?= fetchAssoc(positions($row['position']))['position'] ?></td>
                            <?php if (!$isHrtdms) : ?>
                                <td class="align-middle text-lowercase"><?= $row['email'] ?></td>
                            <?php else : ?>
                                <td class="align-middle text-lowercase">
                                    <?php
                                    $count = numRows(attendedTrainings($row['id']));
                                    if ($count > 0) {
                                        echo $count;
                                    } else { ?>
                                        <span class="text-danger font-weight-bold"><?= $count ?></span>
                                    <?php } ?>
                                </td>
                            <?php endif ?>
                            <?php if ($isHrmis) { ?>
                                <td class="align-middle"><?php progressBar(pdsProgress($row['id'])) ?></td>
                            <?php } else { ?>
                                <?php if (!$isHrtdms) : ?>
                                    <td class="align-middle"><?= $row['mobile'] ?></td>
                                <?php endif ?>
                            <?php } ?>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php if ($isHrmis) {
                                            linkDropdownItem(customUri('hrmis', 'Employee Information', $row['id']), 'View', 'fa-eye', 'View Employee', true);
                                            modalDropdownItem(uri() . '/modules/employees/reassign-employee-dialog.php?id=' . cipher($row['id']), 'Reassign', 'fa-share', 'Reassign Employee');
                                            modalDropdownItem(uri() . '/modules/employees/promote-employee-dialog.php?id=' . cipher($row['id']), 'Promote', 'fa-thumbs-up', 'Promote Employee');
                                            modalDropdownItem(uri() . '/modules/schools/assign-section-head-dialog.php?e=' . cipher($sectionId) . '&id=' . cipher($row['id']), 'Set Head', 'fa-user-tie', 'Set Section Head') ?>
                                            <div class="dropdown-divider"></div>
                                        <?php modalDropdownItem(uri() . '/modules/employees/remove-employee-dialog.php?id=' . cipher($row['id']), 'Remove', 'fa-trash', 'Remove Employee');
                                        } elseif ($isDmis) {
                                            modalDropdownItem(uri() . '/modules/users/edit-user-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit User');
                                        } elseif ($isHrtdms) {
                                            linkDropdownItem(customUri('hrtdms', 'Trainings', $row['id']), 'Trainings', 'fa-chalkboard-teacher');
                                        } else {
                                            modalDropdownItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['id']), 'View', 'fa-eye', 'View Employee');
                                        } ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="5%">Employee Number</th>
                        <th class="align-middle" width="25%">Name</th>
                        <th class="align-middle" width="15%">Date of Birth</th>
                        <th class="align-middle" width="5%">Age</th>
                        <th class="align-middle" width="20%">Position</th>
                        <?php if (!$isHrtdms) : ?>
                            <th class="align-middle" width="15%">Email Address</th>
                        <?php else : ?>
                            <th class="align-middle" width="15%">Attended Trainings</th>
                        <?php endif ?>
                        <?php if ($isHrmis) : ?>
                            <th class="align-middel" width="10%">Progress</th>
                        <?php else : ?>
                            <?php if (!$isHrtdms) : ?>
                                <th class="align-middle" width="10%">Contact #</th>
                            <?php endif ?>
                        <?php endif ?>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>