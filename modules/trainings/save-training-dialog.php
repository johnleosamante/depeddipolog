<?php
// modules/trainings/save-training-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/layout/components.php');

$trainingId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$trainings = training($trainingId);
$title = $hours = $trainingType = $trainingLevel = $sponsorName =  $venue = $unconsecutiveDates = $functionalDivisionId = '';
$dateFrom = $dateTo = date('Y-m-d');
$generateCertificate = false;
$modalTitle = 'Add Training';
$notFound  = true;

if (numRows($trainings) > 0) {
    $training = fetchAssoc($trainings);
    $trainingId = $training['no'];
    $title = $training['title'];
    $dateFrom = $training['from'];
    $dateTo = $training['to'];
    $hours = $training['hours'];
    $trainingType = $training['type'];
    $trainingLevel = $training['level'];
    $sponsorName = $training['sponsor'];
    $functionalDivisionId = empty($training['functional_division']) ? null : $training['functional_division'];
    $venue = $training['venue'];
    $unconsecutiveDates = $training['unconsecutive_date'];
    $generateCertificate = $training['generate_certificate'] === '1';
    $modalTitle = 'Edit Training';
    $notFound = false;
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST">
            <div class="modal-body">
                <?php if (!$notFound) : ?>
                    <div class="form-group">
                        <label for="code" class="mb-0">Code <?php showAsterisk() ?></label>
                        <input type="text" id="code" class="form-control text-uppercase" value="<?= $trainingId ?>" disabled>
                    </div>
                <?php endif ?>

                <div class="form-group">
                    <label for="title" class="mb-0">Title <?php showAsterisk() ?></label>
                    <textarea id="title" name="title" class="form-control" rows="3" placeholder="Type title..." title="Type training title..."><?= $title ?></textarea>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="from" class="mb-0">Date from <?php showAsterisk() ?></label>
                            <input type="date" name="from" id="from" class="form-control" title="Set training start date..." value="<?= $dateFrom ?>" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="from" class="mb-0">Date to <?php showAsterisk() ?></label>
                            <input type="date" name="to" id="to" class="form-control" title="Set training end date..." value="<?= $dateTo ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="unconsecutive-dates" class="mb-0">For non-consecutive days, please specify</label>
                    <input type="text" name="unconsecutive-dates" id="unconsecutive-dates" placeholder="Type non-consecutive days..." title="Type training date for non-consecutive days, Leave blank if not applicable..." class="form-control" value="<?= $unconsecutiveDates ?>">
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="hours" class="mb-0">Number of hours <?php showAsterisk() ?></label>
                            <input type="number" name="hours" id="hours" class="form-control" title="Set training number of hours..." value="<?= $hours ?>" required>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="form-group">
                            <label for="type" class="mb-0">Type <?php showAsterisk() ?></label>
                            <select id="type" name="type" class="form-control" title="Select training type..." required>
                                <option value="">Select type...</option>
                                <?php
                                $types = trainingTypes();
                                while ($type = fetchAssoc($types)) : ?>
                                    <option value="<?= $type['id'] ?>" <?= setOptionSelected($type['id'], $trainingType) ?>><?= $type['type'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="level" class="mb-0">Level <?php showAsterisk() ?></label>
                            <select id="level" name="level" class="form-control" title="Select training level..." required>
                                <option value="">Select level...</option>
                                <?php
                                $sponsors = trainingSponsors();
                                while ($sponsor = fetchAssoc($sponsors)) : ?>
                                    <option value="<?= $sponsor['id'] ?>" <?= setOptionSelected($sponsor['id'], $trainingLevel) ?>><?= $sponsor['sponsor'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="form-group">
                            <label for="sponsor" class="mb-0">Sponsor <?php showAsterisk() ?></label>
                            <input type="text" id="sponsor" name="sponsor" class="form-control" placeholder="Type sponsor..." title="Type training sponsor..." value="<?= $sponsorName ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="functional-division" class="mb-0">Functional Division <?php showAsterisk() ?></label>
                    <select id="functional-division" name="functional-division" class="form-control" title="Select training functional division..." required>
                        <option value="">Select functional division...</option>
                        <?php
                        $functionalDivisions = functionalDivisions();
                        while ($functionalDivision = fetchAssoc($functionalDivisions)) : ?>
                            <option value="<?= $functionalDivision['id'] ?>" <?= setOptionSelected($functionalDivision['id'], $functionalDivisionId) ?>><?= $functionalDivision['name'] ?></option>
                        <?php endwhile ?>
                        <option values="n/a">Not applicable</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="venue" class="mb-0">Venue <?php showAsterisk() ?></label>
                    <input id="venue" name="venue" type="text" class="form-control" placeholder="Type venue..." title="Type training venue..." value="<?= $venue ?>" required>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" id="has-certificate" type="checkbox" name="has-certificate" value="1" <?= setItemChecked($generateCertificate) ?>>
                    <label class="form-check-label" for="has-certificate">Generate certificate</label>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= isset($_GET['id']) ? $_GET['id'] : null ?>">
                <button class="btn btn-primary" name="save-training" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>