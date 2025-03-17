<?php
// modules/employees/tabs/family-background.php

$slast = $sfirst = $sext = $smiddle = $swork = $soffice = $sofficeAddress = $stelephone = $flast = $ffirst = $fext = $fmiddle = $mlast = $mfirst = $mmiddle = null;
$familyMembers = family($employeeId);

if (numRows($familyMembers) > 0) {
    $family = fetchAssoc($familyMembers);
    $slast = $family['slast'];
    $sfirst = $family['sfirst'];
    $sext = $family['sext'];
    $smiddle = $family['smiddle'];
    $swork = $family['swork'];
    $soffice = $family['soffice'];
    $sofficeAddress = $family['soffice_address'];
    $stelephone = $family['stelephone'];
    $flast = $family['flast'];
    $ffirst = $family['ffirst'];
    $fext = $family['fext'];
    $fmiddle = $family['fmiddle'];
    $mlast = $family['mlast'];
    $mfirst = $family['mfirst'];
    $mmiddle = $family['mmiddle'];
}
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'family-background', 'show active') ?>" id="family-background">
    <?php if ($editMode) : ?>
        <form action="" method="POST">
        <?php endif ?>
        <div class="row mt-3">
            <div class="col">
                <div>Spouse's Name</div>

                <hr class="mt-2">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="slast" class="mb-0 small">Last Name</label>
                            <input id="slast" name="slast" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $slast ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-9">
                        <div class="form-group">
                            <label for="sfirst" class="mb-0 small">First Name</label>
                            <input id="sfirst" name="sfirst" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $sfirst ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-1 col-sm-3">
                        <div class="form-group">
                            <label for="sext" class="mb-0 small">Extension</label>
                            <input id="sext" name="sext" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Example: Jr., Sr., III (Leave blank if not applicable)"') ?> value="<?= $sext ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="smiddle" class="mb-0 small">Middle Name</label>
                            <input id="smiddle" name="smiddle" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $smiddle ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="swork" class="mb-0 small">Occupation</label>
                            <input id="swork" name="swork" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $swork ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="sbusiness" class="mb-0 small">Employer/Business Name</label>
                            <input id="sbusiness" name="sbusiness" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $soffice ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="sbusiness-address" class="mb-0 small">Business Address</label>
                            <input id="sbusiness-address" name="sbusiness-address" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $sofficeAddress ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="stelephone" class="mb-0 small">Telephone No.</label>
                            <input id="stelephone" name="stelephone" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $stelephone ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div>Father's Name</div>

                <hr class="mt-2">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="flast" class="mb-0 small">Last Name</label>
                            <input id="flast" name="flast" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $flast ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-9">
                        <div class="form-group">
                            <label for="ffirst" class="mb-0 small">First Name</label>
                            <input id="ffirst" name="ffirst" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $ffirst ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-1 col-sm-3">
                        <div class="form-group">
                            <label for="fext" class="mb-0 small">Extension</label>
                            <input id="fext" name="fext" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Example: Jr., Sr., III (Leave blank if not applicable)"') ?> value="<?= $fext ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="fmiddle" class="mb-0 small">Middle Name</label>
                            <input id="fmiddle" name="fmiddle" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $fmiddle ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div>Mother's Maiden Name</div>

                <hr class="mt-2">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="mlast" class="mb-0 small">Last Name</label>
                            <input id="mlast" name="mlast" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $mlast ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="mfirst" class="mb-0 small">First Name</label>
                            <input id="mfirst" name="mfirst" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $mfirst ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="mmiddle" class="mb-0 small">Middle Name</label>
                            <input id="mmiddle" name="mmiddle" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= $mmiddle ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($editMode) : ?>
            <div class="form-group mb-3">
                <input type="hidden" name="verifier" value="<?= cipher($employeeId) ?>">
                <button class="btn btn-primary btn-block " name="update-family-background"><i class="fas fa-save fa-fw"></i>Update Family Background</button>
            </div>
        </form>
    <?php endif ?>
</div>