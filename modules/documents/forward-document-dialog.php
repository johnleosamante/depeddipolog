<?php
// modules/documents/forward-document-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');

$documentId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$documents = document($documentId);
$description = $destination = $type = $purpose = $details = '';
$modalTitle = 'Document not found';
$hasDocument = false;
$forRelease = false;

if (numRows($documents) > 0) {
    $document = fetchAssoc($documents);
    $documentId = $document['id'];
    $description = $document['description'];
    $type = $document['type'];
    $documentLogs = fetchAssoc(documentLogs($documentId));
    $filename = $documentLogs['attachment'];
    $hasDocument = !str_contains(strtolower($documentLogs['status']), 'complete') && !str_contains(strtolower($documentLogs['status']), 'cancel') && $documentLogs['from'] === $station && $documentLogs['to'] === '-';
    $modalTitle = $hasDocument ? 'Forward Document' : $modalTitle;

    if (strtolower($document['status']) === 'for release' && $portal === 'rec_portal') {
        $forRelease = true;
        $destination = $document['from'];
        $purpose = $document['status'];
        $details = $document['details'];
    }
}
?>

<div class="modal-dialog <?= !$hasDocument ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <?php if ($hasDocument) { ?>
                    <div class="form-group">
                        <label for="code" class="mb-0">Code</label>
                        <input id="code" type="text" value="<?= $documentId ?>" class="form-control text-uppercase" disabled>
                    </div>

                    <div class="form-group">
                        <label for="type" class="mb-0">Type</label>
                        <input id="type" class="form-control text-uppercase" value="<?= fetchArray(documentType($type))['name'] ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="description" class="mb-0">Description</label>
                        <textarea id="description" class="form-control text-uppercase" rows="3" disabled><?= $description ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="destination" class="mb-0">Destination <?php showAsterisk() ?></label>
                        <?php if (!$forRelease) { ?>
                            <select id="destination" name="destination" class="form-control" title="Select document destination..." required>
                                <option value="">Select destination...</option>
                                <?php
                                $divisions = functionalDivisions();
                                while ($division = fetchAssoc($divisions)) : ?>
                                    <optgroup label="<?= $division['name'] ?>">
                                        <?php
                                        $sections = sections($division['id']);
                                        while ($section = fetchAssoc($sections)) {
                                            if ($section['id'] !== $station) { ?>
                                                <option value="<?= $section['id'] ?>"><?= $section['name'] ?></option>
                                        <?php
                                            }
                                        } ?>
                                    </optgroup>
                                <?php endwhile ?>
                            </select>
                        <?php } else {
                            $schools = schoolByAlias($destination);
                            $school = '';

                            if (numRows($schools) > 0) {
                                $school = fetchAssoc($schools)['name'];
                            }
                        ?>
                            <input id="destination" class="form-control" type="text" value="<?= $school ?>" disabled>
                            <input name="destination" class="form-control" type="hidden" value="<?= $destination ?>" required>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="purpose" class="mb-0">Purpose <?php showAsterisk() ?></label>
                        <?php if (!$forRelease) : ?>
                            <select id="purpose" name="purpose" class="form-control" title="Select document purpose..." required>
                                <option value="">Select purpose...</option>
                                <?php
                                $documentPurpose = documentPurpose();
                                while ($purpose = fetchArray($documentPurpose)) : ?>
                                    <option value="<?= $purpose['purpose'] ?>"><?= $purpose['purpose'] ?></option>
                                <?php endwhile ?>
                            </select>
                        <?php else : ?>
                            <input id="purpose" name="purpose" class="form-control" type="text" value="<?= $purpose ?>" required readonly>
                        <?php endif ?>
                    </div>

                    <div class="form-group">
                        <label for="details" class="mb-0">Additional details</label>
                        <textarea id="details" name="details" class="form-control" rows="2" placeholder="Type additional details..." title="Type document additional details..."><?= $details ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="mb-0" for="file-upload">Attachment</label>
                        <input id="file-upload" name="file-upload" type="file" class="w-100">
                    </div>

                    <?php requiredLegend(0) ?>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasDocument) : ?>
                    <input type="hidden" name="verifier" value="<?= $_GET['id'] ?>">
                    <input type="hidden" name="file-verifier" value="<?= cipher($filename) ?>">
                    <button class="btn btn-primary" name="forward-document" type="submit">Continue</button>
                <?php endif ?>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>