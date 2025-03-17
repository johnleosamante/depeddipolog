<?php
// modules/employee/save-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/layout/components.php');
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Add Employee') ?>

        <form action="" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="lname" class="mb-0">Last Name <?php showAsterisk() ?></label>
                    <input id="lname" name="lname" class="form-control" type="text" placeholder="ex. DELA CRUZ" title="ex. DELA CRUZ" required>
                </div>

                <div class="form-group">
                    <label for="fname" class="mb-0">First Name <?php showAsterisk() ?></label>
                    <input id="fname" name="fname" class="form-control" type="text" placeholder="ex. JUAN" title="ex. JUAN" required>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="mname" class="mb-0">Middle Name</label>
                            <input id="mname" name="mname" class="form-control" placeholder="ex. BAUTISTA" title="ex. BAUTISTA, Leave blank if not applicable" type="text">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="ext" class="mb-0">Extension</label>
                            <input id="ext" name="ext" class="form-control" placeholder="ex. JR., SR., III" title="ex. JR., SR., III, Leave blank if not applicable" type="text">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="sex" class="mb-0">Sex <?php showAsterisk() ?></label>
                            <select name="sex" class="form-control" id="sex" title="Select employee sex..." required>
                                <option value="">Select sex...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-7">
                        <div class="form-group">
                            <label for="bdate" class="mb-0">Date of Birth <?php showAsterisk() ?></label>
                            <input type="date" id="bdate" name="bdate" value="<?= date('Y-m-d') ?>" class="form-control" title="Set employee date of birth..." required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="mb-0">DepEd Email Address <?php showAsterisk() ?></label>
                    <input id="email" name="email" class="form-control" type="email" title="ex. juan.delacruz@deped.gov.ph" pattern="[a-z0-9._%+\-]+@deped.gov.ph" placeholder="ex. juan.delacruz@deped.gov.ph" title="ex. juan.delacruz@deped.gov.ph" required>
                </div>

                <div class="form-group">
                    <label for="mobile" class="mb-0">Mobile Number <?php showAsterisk() ?></label>
                    <input id="mobile" name="mobile" class="form-control" type="text" placeholder="ex. 09XX-XXX-XXXX" title="ex. 09XX-XXX-XXXX" pattern="\d{4}[\-]\d{3}[\-]\d{4}" required>
                </div>

                <div class="form-group">
                    <label for="position" class="mb-0">Position <?php showAsterisk() ?></label>
                    <select id="position" name="position" class="form-control" title="Select employee position..." required>
                        <option value="">Select position...</option>
                        <?php
                        $categories = positionCategories();
                        while ($category = fetchAssoc($categories)) : ?>
                            <optgroup label="<?= $category['category'] ?>">
                                <?php $jobPositions = positionsByCategory($category['category']);
                                while ($jobPosition = fetchArray($jobPositions)) : ?>
                                    <option value="<?= $jobPosition['id'] ?>"><?= $jobPosition['position'] ?></option>
                                <?php endwhile ?>
                            </optgroup>
                        <?php endwhile ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="station" class="mb-0">Station <?php showAsterisk() ?></label>
                    <select id="station" name="station" class="form-control" title="Select employee station..." required>
                        <option value="">Select station...</option>
                        <?php
                        $districts = districts();
                        while ($district = fetchAssoc($districts)) : ?>
                            <optgroup label="<?= $district['name'] ?>">
                                <?php
                                $currentStation = isset($_GET['s']) ? sanitize(decode($_GET['s'])) : '';
                                $schools = schoolsByDistrict($district['id']);
                                while ($school = fetchAssoc($schools)) : ?>
                                    <option value="<?= $school['id'] ?>" <?= setOptionSelected($school['id'], $currentStation) ?>><?= $school['name'] ?></option>
                                <?php endwhile ?>
                            </optgroup>
                        <?php endwhile ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="mb-0">Status <?php showAsterisk() ?></label>
                    <select id="status" name="status" class="form-control" title="Select employee status..." required>
                        <option value="">Select status...</option>
                        <option value="Active">Active</option>
                        <option value="Transferred">Transferred</option>
                        <option value="Resigned">Resigned</option>
                        <option value="Retired">Retired</option>
                        <option value="Suspended">Suspended</option>
                        <option value="Dismissed">Dismissed</option>
                        <option value="Deceased">Deceased</option>
                    </select>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" name="add-employee" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>