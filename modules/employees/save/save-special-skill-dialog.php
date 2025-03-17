<?php
// modules/employees/save/save-special-skill-dialog.php
require_once('../../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/special-skill.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['e']) ? sanitize(decipher($_GET['e'])) : null;
$skillId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$copiedId = isset($_GET['c']) ? sanitize(decipher($_GET['c'])) : null;
$skill = '';
$modalTitle = 'Add Special Skill / Hobby';

if (isset($skillId)) {
    $modalTitle = $employeeId === $copiedId ? 'Copy Special Skill / Hobby' : 'Edit Special Skill / Hobby';
    $specialSkills = specialSkill($employeeId, $skillId);

    if (numRows($specialSkills) > 0) {
        $specialSkill = fetchArray($specialSkills);
        $skillId = $specialSkill['no'];
        $skill = $specialSkill['skill'];
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="skill" class="mb-0">Special Skill / Hobby: <?php showAsterisk() ?></label>
                    <input id="skill" type="text" name="skill" class="form-control" title="Required field" value="<?= $skill ?>" required>
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
                <button type="submit" class="btn btn-primary" name="save-special-skill">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>