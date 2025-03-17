<?php
// modules/trainings/save-training-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/layout/components.php');

$trainingId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employeeId = isset($_GET['p']) ? sanitize(decipher($_GET['p'])) : null;

$trainings = training($trainingId);
$modalTitle = 'Training not found';
$numberOfParticipants = 0;
$notFound  = true;
$trainingParticipants = null;

if (numRows($trainings) > 0) {
    $modalTitle = isset($employeeId) ? 'Email Participant' : 'Email All Participants';
    $training = fetchAssoc($trainings);
    $trainingId = $training['no'];
    $notFound = false;
}
?>

<div class="modal-dialog <?= $notFound ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <div class="modal-body">
            <?php if (!$notFound) {
                $trainingParticipants = trainingParticipants($trainingId, $employeeId);
                $numberOfParticipants = numRows($trainingParticipants);
                if ($numberOfParticipants > 0) {
                    if ($numberOfParticipants === 1) {
                        echo 'Are you sure you want to continue to send email to this participant?';
                    } else {
                        echo "Are you sure you want to continue to send email to all {$numberOfParticipants} participants?";
                    } ?>

                    <div class="mt-2 p-2 text-light bg-secondary rounded">
                        <?php if ($numberOfParticipants > 1) : ?>
                            <ol class="mb-0">
                                <?php while ($participant = fetchAssoc($trainingParticipants)) : ?>
                                    <li><?= strtoupper(toName($participant['lname'], $participant['fname'], $participant['mname'], $participant['ext'])) ?></li>
                                <?php endwhile ?>
                            </ol>
                        <?php else : ?>
                            <?php while ($participant = fetchAssoc($trainingParticipants)) : ?>
                                <div class="m-0 pl-3"><?= strtoupper(toName($participant['lname'], $participant['fname'], $participant['mname'], $participant['ext'])) ?></div>
                            <?php endwhile ?>
                        <?php endif ?>
                    </div>
            <?php }
            } else {
                missingAlert($modalTitle);
            } ?>
        </div>

        <div class="modal-footer">
            <?php if (!$notFound) : ?>
                <form action="" method="POST">
                    <input type="hidden" name="verifier" value="<?= isset($_GET['id']) ? $_GET['id'] : null ?>">
                    <?php if (isset($_GET['p'])) : ?>
                        <input type="hidden" name="data-verifier" value="<?= $_GET['p'] ?>">
                    <?php endif ?>
                    <button class="btn btn-primary" name="email-participants" type="submit">Yes, Continue</button>
                <?php endif;
            cancelModalButton();
            if (!$notFound) : ?>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>