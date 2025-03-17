<?php
// modules/employees/save/save-education-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/education.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$educationId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$education = $level = $school = $course =  $highestLevel = $yearGraduated = $honorReceived = '';
$from = $to = date('Y');
$isPresent = false;
$modalTitle = 'Add Educational Background';

if (isset($educationId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Educational Background' : 'Edit Educational Background';
    $educationalBackground = educationalBackground($employeeId, $educationId);

    if (numRows($educationalBackground) > 0) {
        $education = fetchArray($educationalBackground);
        $educationId = $education['no'];
        $level = $education['level'];
        $school = $education['school'];
        $course = $education['course'];
        $from = $education['from'];
        $isPresent = $education['ispresent'] === '1';
        $to = $isPresent ? date('Y') : $education['to'];
        $highestLevel = $education['highest'];
        $yearGraduated = $education['year_graduated'];
        $honorReceived = $education['scholarship'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="level" class="mb-0">Level: <?php showAsterisk() ?></label>
                    <select id="level" name="level" class="form-control" title="Select education level..." required>
                        <option value="">Select level...</option>
                        <option value="Elementary" <?= setOptionSelected("Elementary", $level) ?>>Elementary</option>
                        <option value="Secondary" <?= setOptionSelected("Secondary", $level) ?>>Secondary</option>
                        <option value="Vocational" <?= setOptionSelected("Vocational", $level) ?>>Vocational</option>
                        <option value="College" <?= setOptionSelected("College", $level) ?>>College</option>
                        <option value="Graduate Studies" <?= setOptionSelected("Graduate Studies", $level) ?>>Graduate Studies</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="school" class="mb-0">Name of School (Write in full): <?php showAsterisk() ?></label>
                    <input id="school" name="school" type="text" class="form-control" placeholder="Type name..." title="Type name of school..." required value="<?= $school ?>">
                </div>

                <div class="form-group">
                    <label for="course" class="mb-0">Basic Education / Degree / Course (Write in full):</label>
                    <input id="course" name="course" type="text" class="form-control" placeholder="Type basic education / degree / course..." title=" Type basic education / degree / course, Leave blank if not applicable..." value="<?= $course ?>">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from" class="mb-0">Attendance from: <?php showAsterisk() ?></label>
                            <input id="from" name="from" type="number" step="1" min="0" class="form-control" title="Type start attendance year..." value="<?= $from ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-7">
                                    <label for="to" class="mb-0">Attendance to: <?php showAsterisk() ?></label>
                                </div>
                                <div class="col-5">
                                    <div class="form-check" title="Check if present education">
                                        <input class="form-check-input" id="is-present" type="checkbox" name="is-present" value="1" <?= setItemChecked($isPresent) ?>>
                                        <label class="form-check-label" for="is-present">Present</label>
                                    </div>
                                </div>
                            </div>
                            <input id="to" name="to" type="number" step="1" min="0" class="form-control" title="Type end attendance year..." value="<?= $to ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="highest" class="mb-0">Highest Level / Units Earned <br>(if not graduated):</label>
                            <input id="highest" name="highest" type="text" class="form-control" placeholder="Type highest level / units earned..." title="Type highest level / units earned, Leave blank if not applicable..." value="<?= $highestLevel ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year" class="mb-0">Year Graduated:<br>(if graduated)</label>
                            <input id="year" name="year" type="number" step="1" min="0" class="form-control" title="Type year graduated, Leave blank if not applicable..." value="<?= $yearGraduated ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="scholarship" class="mb-0">Scholarship / Academic Honors Received:</label>
                    <input id="scholarship" name="scholarship" type="text" class="form-control" placeholder="Type scholarship / academic honors received..." title="Type scholarship / academic honors received, Leave blank if not applicable..." value="<?= $honorReceived ?>">
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
                <button type="submit" class="btn btn-primary" name="save-education">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>