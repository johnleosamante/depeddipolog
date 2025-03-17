<?php
// modules/schools/save-school-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');

$schoolId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$schools = schoolDetailsById($schoolId);
$school = $schoolName = $address = $category = $districtCode = $alias = $telephone = $email = $website = $facebook = $logo = null;
$modalTitle = 'Add School';
$notFound = true;

if (numRows($schools) > 0) {
    $school = fetchAssoc($schools);
    $schoolName = $school['name'];
    $address = $school['address'];
    $category = $school['category'];
    $districtCode = $school['district'];
    $alias = $school['alias'];
    $telephone = $school['telephone'];
    $email = $school['email'];
    $website = $school['website'];
    $facebook = $school['fb_page'];
    $logo = $school['logo'];
    $modalTitle = 'Edit School';
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="school-id" class="mb-0">School ID <?php showAsterisk() ?></label>
                            <input type="text" id="school-id" name="school-id" class="form-control" value="<?= $schoolId ?>" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="alias" class="mb-0">Alias <?php showAsterisk() ?></label>
                            <input type="text" id="alias" name="alias" class="form-control" value="<?= $alias ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="school-name" class="mb-0">Name <?php showAsterisk() ?></label>
                    <input type="text" id="school-name" name="school-name" class="form-control" value="<?= $schoolName ?>" required>
                </div>

                <div class="form-group">
                    <label for="address" class="mb-0">Address <?php showAsterisk() ?></label>
                    <input type="text" id="address" name="address" class="form-control" value="<?= $address ?>" required>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="district" class="mb-0">District <?php showAsterisk() ?></label>
                            <select id="district" name="district" class="form-control" required>
                                <option value="">Select district...</option>
                                <?php $districts = districts();
                                while ($district = fetchAssoc($districts)) : ?>
                                    <option value="<?= $district['id'] ?>" <?= setOptionSelected($district['id'], $districtCode) ?>><?= $district['name'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="category" class="mb-0">Category <?php showAsterisk() ?></label>
                            <select id="category" name="category" class="form-control" required>
                                <option value="">Select category...</option>
                                <option value="Elementary" <?= setOptionSelected('Elementary', $category) ?>>Elementary</option>
                                <option value="Secondary" <?= setOptionSelected('Secondary', $category) ?>>Secondary</option>
                                <option value="Integrated" <?= setOptionSelected('Integrated', $category) ?>>Integrated</option>
                                <option value="Office" <?= setOptionSelected('Office', $category) ?>>Office</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telephone" class="mb-0">Telephone</label>
                    <input type="text" id="telephone" name="telephone" class="form-control" value="<?= $telephone ?>">
                </div>

                <div class="form-group">
                    <label for="email" class="mb-0">Email <?php showAsterisk() ?></label>
                    <input type="text" id="email" name="email" class="form-control" value="<?= $email ?>" required>
                </div>

                <div class="form-group">
                    <label for="website" class="mb-0">Website</label>
                    <input type="text" id="website" name="website" class="form-control" value="<?= $website ?>">
                </div>

                <div class="form-group">
                    <label for="facebook" class="mb-0">Facebook</label>
                    <input type="text" id="facebook" name="facebook" class="form-control" value="<?= $facebook ?>">
                </div>

                <div class="form-group">
                    <label for="logo-upload" class="mb-0">School Logo</label>
                    <input id="logo-upload" name="logo-upload" type="file" class="w-100">
                </div>

                <?php requiredLegend(0) ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= isset($_GET['id']) ? $_GET['id'] : null ?>">
                <input type="hidden" name="data-verifier" value="<?= isset($_GET['e']) ? $_GET['e'] : null ?>">
                <input type="hidden" name="image-verifier" value="<?= cipher($logo) ?>">
                <button class="btn btn-primary" name="save-school" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>