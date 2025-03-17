<?php
// modules/employees/tabs/government-id.php
$card = $number = $place = $date = 'N/A';

if ($isPis) {
    $date = date('Y-m-d');
    $employeeId = $userId;
}

$employeeIdentifications = employeeIdentification($employeeId);

if (numRows($employeeIdentifications) > 0) {
    $identification = fetchAssoc($employeeIdentifications);
    $cardType = $identification['card'];
    $cardTypes = cardType($identification['card']);
    $card = numRows($cardTypes) > 0 ? fetchAssoc($cardTypes)['name'] : 'N/A';

    $number = $identification['number'];
    $place = $identification['place'];
    $date = toDate($identification['date'], 'Y-m-d');
}
?>

<div class="tab-pane fade" id="government-id">
    <?php if ($isPis) : ?>
        <form class="py-2" action="" method="POST">
        <?php endif ?>
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
                <div class="form-group">
                    <label for="card-type" class="mb-0">Government Issued ID <?php if ($isPis) showAsterisk() ?></label>
                    <?php if ($isPis) : ?>
                        <select class="form-control" id="card-type" name="card-type" required>
                            <option value="">Select...</option>
                            <?php $cardTypes = cardTypes();
                            while ($type = fetchAssoc($cardTypes)) : ?>
                                <option value="<?= $type['id'] ?>" <?= setOptionSelected($type['id'], $cardType) ?>><?= $type['name'] ?></option>
                            <?php endwhile ?>
                        </select>
                    <?php else : ?>
                        <input type="text" class="form-control" id="card-type" name="card-type" value="<?= $card ?>" readonly>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="card-number" class="mb-0">ID/License/Passport No. <?php if ($isPis) showAsterisk() ?></label>
                    <input type="text" class="form-control" id="card-number" name="card-number" value="<?= $number ?>" <?= setActiveNavigation(!$isPis, 'readonly') ?>>
                </div>

                <div class="form-group">
                    <label for="card-date" class="mb-0">Date of Issuance <?php if ($isPis) showAsterisk() ?></label>
                    <input type="<?= $isPis ? 'date' : 'text' ?>" class="form-control" id="card-date" name="card-date" value="<?= $date ?>" <?= setActiveNavigation(!$isPis, 'readonly') ?>>
                </div>

                <div class="form-group">
                    <label for="card-place" class="mb-0">Place of Issuance <?php if ($isPis) showAsterisk() ?></label>
                    <input type="text" class="form-control" id="card-place" name="card-place" value="<?= $place ?>" <?= setActiveNavigation(!$isPis, 'readonly') ?>>
                </div>

                <?php if ($isPis) : ?>
                    <?php requiredLegend() ?>

                    <input name="update-identification" type="submit" value="Update Government Issued ID" class="btn btn-primary btn-block btn-lg">
                <?php endif ?>
            </div>
        </div>
        <?php if ($isPis) : ?>
        </form>
    <?php endif ?>
</div>