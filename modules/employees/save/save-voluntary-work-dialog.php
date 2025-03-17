<?php
// modules/employees/save/save-voluntary-work-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/voluntary-work.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$voluntaryId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$organization = $hours = $position = '';
$from = $to = date('Y-m-d');
$isPresent = false;
$modalTitle = 'Add Voluntary Work';

if (isset($voluntaryId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Voluntary Work' : 'Edit Voluntary Work';
    $voluntaryWorks = voluntaryWork($employeeId, $voluntaryId);

    if (numRows($voluntaryWorks) > 0) {
        $voluntaryWork = fetchArray($voluntaryWorks);
        $voluntaryId = $voluntaryWork['no'];
        $organization = $voluntaryWork['organization'];
        $from = toDate($voluntaryWork['from'], 'Y-m-d');
        $isPresent = $voluntaryWork['ispresent'] ? '1' :
            '0';
        $to = $isPresent ? date('Y-m-d') : toDate($voluntaryWork['to'], 'Y-m-d');
        $hours = $voluntaryWork['hours'];
        $position = $voluntaryWork['position'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="organization" class="mb-0">Name & Address of Organization (Write in full): <?php showAsterisk() ?></label>
                    <textarea id="organization" name="organization" class="form-control" title="Required field" rows="3" required><?= $organization ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from" class="mb-0">Inclusive Dates From: <?php showAsterisk() ?></label>
                            <input id="from" type="date" name="from" class="form-control" title="Required field" value="<?= $from ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="to" class="mb-0">Dates To: <?php showAsterisk() ?></label>
                                </div>
                                <div class="col-6" title="Check if present voluntary work">
                                    <input class="form-check-input" id="is-present" type="checkbox" name="is-present" value="1" <?= setItemChecked($isPresent) ?>>
                                    <label class="form-check-label" for="is-present">Present</label>
                                </div>
                            </div>
                            <input id="to" type="date" name="to" class="form-control" title="Required field" value="<?= $to ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="hours" class="mb-0">Number of Hours:</label>
                    <input id="hours" type="number" name="hours" min="0" step="1" class="form-control" title="Leave blank if not applicable" value="<?= $hours ?>">
                </div>

                <div class="form-group">
                    <label for="position" class="mb-0">Position: <?php showAsterisk() ?></label>
                    <input id="position" type="text" name="position" class="form-control" title="Required field" value="<?= $position ?>" required>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= isset($_GET['e']) ? $_GET['e'] : null ?>">
                <?php
                $verifier = isset($_GET['id']) ? $_GET['id'] : null;
                $verifier = $employeeId === $copiedId ? null : $verifier;
                ?>
                <input type="hidden" name="data-verifier" value="<?= $verifier ?>">
                <button type="submit" class="btn btn-primary" name="save-voluntary-work">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>