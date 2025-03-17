<?php
// modules/trainings/training-participants.php
if (!$isHrtdms) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$trainingId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$trainings = training($trainingId);
$employees = employees();

if (numRows($trainings) > 0) {
    $training = fetchAssoc($trainings);
    $trainingId = $training['no'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Add Training Participants', customUri('hrtdms', 'Training Details', $trainingId)) ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table cellspacing="0">
                <tr>
                    <th class="align-top pr-5" scope="row">Code</th>
                    <td class="text-uppercase"><?= $training['no'] ?></td>
                </tr>
                <tr>
                    <th class="align-top pr-5" scope="row">Title</th>
                    <td class="text-uppercase"><?= $training['title'] ?></td>
                </tr>
                <tr>
                    <th class="pr-5" scope="row">Date</th>
                    <td class="text-uppercase"><?= empty($training['unconsecutive_date']) ? toLongDate($training['from']) . ' - ' . toLongDate($training['to']) : $training['unconsecutive_date'] ?></td>
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
                    <td class="text-uppercase"><?= numRows(trainingParticipants($trainingId)) ?></td>
                </tr>
            </table>
        </div>

        <form action="" method="POST">
            <div class="table-responsive my-3">
                <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="3%"></th>
                            <th class="align-middle" width="5%">Photo</th>
                            <th class="align-middle" width="37%">Name</th>
                            <th class="align-mdille" width="10%">Status</th>
                            <th class="align-middle" width="20%">Position</th>
                            <th class="align-middle" width="25%">Station</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        while ($row = fetchArray($employees)) {
                            if (!isTrainingParticipant($trainingId, $row['id'])) {
                                $employeeName =  toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
                                $photo = uri() . '/' . $row['picture'];
                        ?>
                                <tr class="text-uppercase">
                                    <td class="align-middle">
                                        <input type="checkbox" class="form-control" name="participants[]" value="<?= cipher($row['id']) ?>">
                                    </td>
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
                                </tr>
                        <?php }
                        } ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th width="3%"></th>
                            <th class="align-middle" width="5%">Photo</th>
                            <th class="align-middle" width="37%">Name</th>
                            <th class="align-mdille" width="10%">Status</th>
                            <th class="align-middle" width="20%">Position</th>
                            <th class="align-middle" width="25%">Station</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <input type="hidden" name="verifier" value="<?= cipher($trainingId) ?>">
            <button class="btn btn-primary btn-block" name="add-participants">
                <i class="fas fa-plus fa-fw"></i>
                Add Participants
            </button>
        </form>
    </div>
</div>