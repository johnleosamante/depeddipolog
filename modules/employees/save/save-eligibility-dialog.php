<?php
// modules/employees/save/save-eligibility-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/eligibility.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$eligibilityId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$career = $rating = $examPlace = $license = '';
$examDate = $validity = date('Y-m-d');
$isApplicable = true;
$modalTitle = 'Add Civil Service Eligibility';

if (isset($eligibilityId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Civil Service Eligibility' : 'Edit Civil Service Eligibility';
    $eligibilities = eligibility($employeeId, $eligibilityId);

    if (numRows($eligibilities) > 0) {
        $eligibility = fetchArray($eligibilities);
        $eligibilityId = $eligibility['no'];
        $career = $eligibility['eligibility'];
        $rating = $eligibility['rating'];
        $examDate = toDate($eligibility['date'], 'Y-m-d');
        $examPlace = $eligibility['place'];
        $license = $eligibility['license'];
        $isApplicable = $eligibility['isapplicable'] === 'y';
        $validity = $isApplicable ? toDate($eligibility['validity'], 'Y-m-d') : date('Y-m-d');
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="career" class="mb-0">Career Service / RA 1080 (Board/Bar) / Under Special Laws / CES / CSEE / Barangay Eligibility / Driver's License: <?php showAsterisk() ?></label>
                    <input id="career" name="career" type="text" class="form-control" title="Required field" value="<?= $career ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rating" class="mb-0">Rating <br>(if applicable):</label>
                            <input id="rating" name="rating" type="number" class="form-control" min="0" step="0.01" title="Leave blank if not applicable" value="<?= $rating ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exam-date" class="mb-0">Date of Examination / Conferment: <?php showAsterisk() ?></label>
                            <input id="exam-date" name="exam-date" type="date" class="form-control" title="Required field" value="<?= $examDate ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exam-place" class="mb-0">Place of Examination / Conferment: <?php showAsterisk() ?></label>
                    <input id="exam-place" name="exam-place" type="text" class="form-control" title="Required field" value="<?= $examPlace ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="license" class="mb-0">License No. (if applicable):</label>
                            <input id="license" type="text" name="license" class="form-control" title="Leave blank if not applicable" value="<?= $license ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="validity" class="mb-0">Validity:</label>
                                </div>
                                <div class="col-6">
                                    <div class="form-check" title="Check if validity is applicable">
                                        <input class="form-check-input" id="is-applicable" type="checkbox" name="is-applicable" value="1" <?= setItemChecked($isApplicable) ?>>
                                        <label class="form-check-label" for="is-applicable">Applicable</label>
                                    </div>
                                </div>
                            </div>
                            <input id="validity" name="validity" type="date" class="form-control" value="<?= $validity ?>">
                        </div>
                    </div>
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
                <button type="submit" class="btn btn-primary" name="save-eligibility">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>