<?php
// modules/settings/contacts.php
$primaryEmail = $alternateEmail = $telephone = $mobileNo = $alternateMobile = '';
$employeeDetails = employeeContactDetails($userId);

if (numRows($employeeDetails) > 0) {
    $contact = fetchAssoc($employeeDetails);
    $primaryEmail = $contact['email'];
    $alternateEmail = $contact['alternate_email'];
    $telephone = $contact['telephone'];
    $mobileNo = $contact['mobile'];
    $alternateMobile = $contact['alternate_mobile'];
}
?>
<div class="tab-pane fade" id="contact-details">
    <form class="py-2" action="" method="POST">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="primary-email" class="mb-0">DepEd Email Address</label>
                    <input type="email" id="primary-email" class="form-control" autocomplete="false" value="<?= $primaryEmail ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="telephone" class="mb-0">Telephone Number</label>
                    <input type="text" id="telephone" class="form-control" value="<?= $telephone ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="mobile" class="mb-0">Mobile Number</label>
                    <input type="text" id="mobile" class="form-control" value="<?= $mobileNo ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="alternate-email" class="mb-0">Alternate Email Address <?php showAsterisk() ?></label>
                    <input type="email" id="alternate-email" name="alternate-email" class="form-control" autocomplete="false" value="<?= $alternateEmail ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="alternate-mobile" class="mb-0">Alternate Mobile Number <?php showAsterisk() ?></label>
                    <input type="text" id="alternate-mobile" name="alternate-mobile" class="form-control" value="<?= $alternateMobile ?>" required>
                </div>
            </div>
        </div>

        <?php requiredLegend() ?>

        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <input name="update-contact-details" type="submit" value="Update Contact Details" class="btn btn-primary btn-block btn-lg">
            </div>
        </div>
    </form>
</div>