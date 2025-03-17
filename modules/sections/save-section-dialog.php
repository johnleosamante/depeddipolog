<?php
// modules/sections/save-section-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/layout/components.php');

$sectionAlias = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$sections = section($sectionAlias);
$section = $sectionName = $sectionHead = $sectionDivision = null;
$modalTitle = 'New Section';
$notFound = true;

if (numRows($sections) > 0) {
    $section = fetchAssoc($sections);
    $sectionName = $section['name'];
    $sectionHead = $section['head'];
    $sectionDivision = $section['division'];
    $modalTitle = 'Edit Section';
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle); ?>

        <form action="" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="alias" class="mb-0">Alias <?php showAsterisk(); ?></label>
                    <input type="text" id="alias" name="alias" class="form-control" minlength="3" maxlength="3" value="<?php echo $sectionAlias; ?>" required>
                </div>
                <div class="form-group">
                    <label for="section" class="mb-0">Name <?php showAsterisk(); ?></label>
                    <input type="text" id="section" name="section" class="form-control" value="<?php echo $sectionName; ?>" required>
                </div>
                <div class="form-group">
                    <label for="division" class="mb-0">Functional Division <?php showAsterisk(); ?></label>
                    <select id="division" name="division" class="form-control" required>
                        <option value="">Select functional division...</option>
                        <?php $divisions = functionalDivisions();
                        while ($division = fetchAssoc($divisions)) : ?>
                            <option value="<?php echo $division['id']; ?>" <?php echo setOptionSelected($division['id'], $sectionDivision); ?>><?php echo $division['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="head" class="mb-0">Section Head <?php showAsterisk(); ?></label>
                    <select id="head" name="head" class="form-control" required>
                        <option value="">Select section head...</option>
                        <?php $employees = activeEmployees(divisionId());
                        while ($employee = fetchAssoc($employees)) : ?>
                            <option value="<?php echo $employee['id']; ?>" title="<?php echo fetchAssoc(position($employee['id']))['position']; ?>" <?php echo setOptionSelected($employee['id'], $sectionHead); ?>>
                                <?php echo userName($employee['id']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <?php requiredLegend(0); ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>">
                <button class="btn btn-primary" name="save-section" type="submit">Continue</button>
                <?php cancelModalButton(); ?>
            </div>
        </form>
    </div>
</div>