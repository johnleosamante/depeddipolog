<?php
// modules/psipop/save-psipop-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/psipop.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employees = employee($employeeId);
$modalTitle = 'Employee not found';
$hasEmployee = false;
$empStatus = $item = $salaryGrade = $step = $status = $eligibility = null;
$doa = $dlp = date('Y-m-d');

if (numRows($employees) > 0) {
  $employee = fetchAssoc($employees);
  $employeeId = $employee['id'];
  $employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
  $sex = $employee['sex'];
  $dob = $employee['month'] . '/' . $employee['day'] . '/' . $employee['year'];
  $empStatus = $employee['status'];
  $positions = fetchAssoc(position($employeeId));
  $stationId = $positions['station_id'];
  $station = $positions['station'];
  $positionId = $positions['position_id'];
  $salaryGrade = fetchAssoc(positions($positionId))['salary_grade'];
  $employeeStep = getEmployeeStepIncrement($employee['id']);
  $step = numRows($employeeStep) > 0 ? fetchAssoc($employeeStep)['step'] : '1';
  $position = $positions['position'];
  $depedEmail = $employee['email'];
  $tin = $employee['tin'];
  $picture = uri() . '/' . $employee['picture'];
  $modalTitle = 'Employee PSIPOP Information';
  $hasEmployee = true;

  $psipops = psipop($employeeId);

  if (numRows($psipops) > 0) {
    $psipop = fetchAssoc($psipops);
    $item = $psipop['item'];
    $status = $psipop['status'];
    $doa = $psipop['original_appointment'] ?? date('Y-m-d');
    $dlp = $psipop['date_promoted'] ?? date('Y-m-d');
    $eligibility = $psipop['eligibility'];
  }
}
?>

<div class="modal-dialog <?= !$hasEmployee ? 'modal-sm' : '' ?>">
  <div class="modal-content">
    <?php modalHeader($modalTitle) ?>

    <form action="" method="POST">
      <div class="modal-body">
        <?php if ($hasEmployee) {
          employeeProfile($picture, $employeeName, $sex, $depedEmail, $position, $station, $empStatus) ?>
          <hr>

          <div class="form-group">
            <label for="item" class="mb-0">Item Number <?php showAsterisk() ?></label>
            <input type="text" id="item" name="item" class="form-control" placeholder="Type item number..." title="Type employee PSIPOP item number..." value="<?= $item ?>" required>
          </div>

          <div class="form-group">
            <label for="position" class="mb-0">Position</label>
            <input type="text" id="position" class="form-control" value="<?= $position ?>" readonly>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="salary-grade" class="mb-0">Salary Grade</label>
                <input type="text" id="salary-grade" class="form-control" value="<?= $salaryGrade ?>" readonly>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="step" class="mb-0">Step Increment</label>
                <input type="text" id="step" class="form-control" value="<?= $step ?>" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="dob" class="mb-0">Date of Birth</label>
                <input type="text" id="dob" class="form-control" value="<?= $dob ?>" readonly>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="tin" class="mb-0">Tax Identification Number</label>
                <input type="text" id="tin" class="form-control" value="<?= $tin ?>" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="doa" class="mb-0">Date of Original<br>Appointment <?php showAsterisk() ?></label>
                <input type="date" id="doa" name="doa" class="form-control" title="Set date of original appointment..." value="<?= $doa ?>" required>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="dlp" class="mb-0">Date of Last<br>Promotion <?php showAsterisk() ?></label>
                <input type="date" id="dlp" name="dlp" class="form-control" title="Set date of last promotion..." value="<?= $dlp ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="status" class="mb-0">Employment Status <?php showAsterisk() ?></label>
                <select name="status" id="status" class="form-control" title="Select employment status..." required>
                  <option value="Permanent" <?= setOptionSelected("Permanent", $status) ?>>Permanent</option>
                  <option value="Temporary" <?= setOptionSelected("Temporary", $status) ?>>Temporary</option>
                  <option value="Coterminus" <?= setOptionSelected("Coterminus", $status) ?>>Coterminus</option>
                  <option value="Fixed Term" <?= setOptionSelected("Fixed Term", $status) ?>>Fixed Term</option>
                  <option value="Contractual" <?= setOptionSelected("Contractual", $status) ?>>Contractual</option>
                  <option value="Substitute" <?= setOptionSelected("Substitute", $status) ?>>Substitute</option>
                  <option value="Provisional" <?= setOptionSelected("Provisional", $status) ?>>Provisional</option>
                  <option value="Volunteer" <?= setOptionSelected("Volunteer", $status) ?>>Volunteer</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="eligibility" class="mb-0">Eligibility <?php showAsterisk() ?></label>
                <input type="text" id="eligibility" name="eligibility" class="form-control" placeholder="Type eligibility..." title="Type employee eligibility..." value="<?= $eligibility ?>" required>
              </div>
            </div>
          </div>

          <?php requiredLegend(0) ?>
        <?php
        } else {
          missingAlert($modalTitle);
        } ?>
      </div>
      <div class="modal-footer">
        <?php if ($hasEmployee) : ?>
          <input type="hidden" name="verifier" value="<?= isset($_GET['id']) ? $_GET['id'] : null ?>">
          <button class="btn btn-primary" name="save-psipop" type="submit">Continue</button>
        <?php
        endif;
        cancelModalButton();
        ?>
      </div>
    </form>
  </div>
</div>