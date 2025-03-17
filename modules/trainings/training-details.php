<?php
// modules/trainings/training-details.php
if (!$isHrtdms) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$trainingId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$trainings = training($trainingId);
$participants = trainingParticipants($trainingId);
$participantsCount = numRows($participants);

if (numRows($trainings) > 0) {
    $training = fetchAssoc($trainings);
    $trainingId = $training['no'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item">
                <?php if (strtotime($training['from']) < strtotime(date('Y-m-d'))) : ?>
                    <a href="<?= customUri('hrtdms', 'Conducted Trainings') ?>">Conducted Trainings</a>
                <?php else : ?>
                    <a href="<?= customUri('hrtdms', 'Scheduled Trainings') ?>">Scheduled Trainings</a>
                <?php endif ?>
            </li>
            <li class="breadcrumb-item active">HRTD-24-0005</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithModal('Training Details', uri() . '/modules/trainings/save-training-dialog.php?id=' . cipher($training['no']), 'Edit', 'fa-edit') ?>
    </div>

    <div class="card-body">
        <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
            <div class="d-inline-block">
                <?php linkButtonSplit(customUri('export', 'training-details', $training['no']), 'Export', 'fa-file-excel', 'Export as Excel file', 'success'); ?>
            </div>
        </div>

        <div class="table-responsive mb-3">
            <table cellspacing="0">
                <tr>
                    <th class="pr-5" scope="row">Code</th>
                    <td class="text-uppercase"><?= $training['no'] ?></td>
                </tr>
                <tr>
                    <th class="align-top pr-5" scope="row">Title</th>
                    <td class="text-uppercase"><?= $training['title'] ?></td>
                </tr>
                <tr>
                    <th class="pr-5" scope="row">Date</th>
                    <td class="text-uppercase">
                        <?= empty($training['unconsecutive_date']) ? toDateRange($training['from'], $training['to']) : toHandleEncoding($training['unconsecutive_date']) ?>
                    </td>
                </tr>
                <?php if (!empty($training['hours'])) : ?>
                    <tr>
                        <th class="pr-5" scope="row">Hours</th>
                        <td class="text-uppercase"><?= $training['hours'] ?></td>
                    </tr>
                <?php endif ?>
                <tr>
                    <th class="pr-5" scope="row">Type</th>
                    <td class="text-uppercase"><?= trainingType($training['type']) ?></td>
                </tr>
                <tr>
                    <th class="pr-5" scope="row">Level</th>
                    <?php
                    $functional_division = $training['functional_division'];
                    $functional_divisions = functionalDivision($functional_division);
                    $training_functional_division = '';
                    if (numRows($functional_divisions) > 0) {
                        $training_functional_division = fetchAssoc($functional_divisions)['name'];
                    }
                    $functional_division = (!empty($functional_division) && strtolower($functional_division) !== 'n/a') ? ' (' . $training_functional_division . ')' : '';
                    ?>
                    <td class="text-uppercase"><?= trainingSponsor($training['level']) . $functional_division ?></td>
                </tr>
                <?php if (!empty($training['sponsor'])) : ?>
                    <tr>
                        <th class="align-top pr-5" scope="row">Sponsor</th>
                        <td class="text-uppercase"><?= $training['sponsor'] ?></td>
                    </tr>
                <?php endif ?>
                <?php if (!empty($training['venue'])) : ?>
                    <tr>
                        <th class="align-top pr-5" scope="row">Venue</th>
                        <td class="text-uppercase"><?= $training['venue'] ?></td>
                    </tr>
                <?php endif ?>
                <tr>
                    <th class="align-top pr-5" scope="row">Participants</th>
                    <td class="text-uppercase"><?= numRows($participants) ?></td>
                </tr>
            </table>
        </div>

        <?php if (isConductedTraining($trainingId)) : ?>
            <div class="d-flex align-items-center flex-row-reverse mt-2">
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('hrtdms', 'Add Training Participants', $trainingId), 'Add Participants', 'fa-user-plus') ?>
                </div>
            </div>
        <?php endif ?>

        <div class="table-responsive mt-2">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="35%">Name</th>
                        <th class="align-mdille" width="10%">Status</th>
                        <th class="align-middle" width="20%">Position</th>
                        <th class="align-middle" width="25%">Station</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($row = fetchArray($participants)) :
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
                            <td class="align-middle text-left">
                                <?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['id']), $employeeName) ?>
                            </td>
                            <td class="align-middle">
                                <?php
                                $status = strtolower($row['status']);
                                roundPill($status);
                                ?>
                            </td>
                            <td class="align-middle"><?= fetchAssoc(positions($row['position']))['position'] ?></td>
                            <td class="align-middle"><?= fetchAssoc(schoolById($row['station']))['name'] ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php
                                        if ($training['generate_certificate']) :
                                            linkDropdownItem(customUri('print', 'Certificate of Participation', $training['no']) . '&p=' . encode($row['id']), 'Certificate', 'fa-certificate', 'View Certificate of Participation', true) ?>
                                        <?php endif;
                                        linkDropdownItem(customUri('print', 'Certificate of Appearance', $training['no']) . '&p=' . encode($row['id']), 'Appearance', 'fa-stamp', 'View Certificate of Appearance', true);
                                        modalDropDownItem(uri() . '/modules/trainings/email-training-participants-dialog.php?id=' . cipher($training['no']) . '&p=' . encode($row['id']), 'Email', 'fa-envelope', 'Send Email to Participant') ?>
                                        <div class="dropdown-divider"></div>
                                        <?php modalDropdownItem(uri() . '/modules/trainings/remove-participant-dialog.php?e=' . cipher($row['id']) . '&id=' . cipher($trainingId), 'Remove', 'fa-trash', 'Remove Participant') ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="35%">Name</th>
                        <th class="align-mdille" width="10%">Status</th>
                        <th class="align-middle" width="20%">Position</th>
                        <th class="align-middle" width="25%">Station</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>