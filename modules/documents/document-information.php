<?php
// modules/documents/document-information.php
if (!$isDts) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$documentId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$documents = document($documentId);
$documentType = 'Ongoing Documents';

messageAlert($showAlert, $message, $success);

if (numRows($documents) > 0) {
    $document = fetchAssoc($documents);
    $documentId = $document['id'];

    if (isIncomingDocument($documentId, $station)) {
        $documentType = 'Incoming Documents';
    } elseif (isPendingDocument($documentId, $station)) {
        $documentType = 'Pending Documents';
    } elseif (isOutgoingDocument($documentId, $station)) {
        $documentType = 'Outgoing Documents';
    } elseif (isCompletedDocument($documentId, $station)) {
        $documentType = 'Completed Documents';
    } elseif (isReceivedDocument($documentId, $station)) {
        $documentType = 'Received Documents';
    } elseif (isCanceledDocument($documentId, $station)) {
        $documentType = 'Canceled Documents';
    }
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item">
                <a href="<?= customUri('dts', $documentType) ?>"><?= trim($documentType, ' Documents') ?></a>
            </li>
            <li class="breadcrumb-item active"><?= $documentId ?></li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle("Document Information: " . strtoupper($documentId)) ?>
    </div>

    <div class="card-body">
        <table cellspacing="0">
            <tr>
                <th class="align-top pr-3" scope="row">Type:</th>
                <td class="text-uppercase"><?= fetchArray(documentType($document['type']))['name'] ?></td>
            </tr>
            <tr>
                <th class="align-top pr-3" scope="row">Description:</th>
                <td class="text-uppercase"><?= $document['description'] ?></td>
            </tr>
            <tr>
                <th class="align-top pr-3" scope="row">Created on:</th>
                <td class="text-uppercase"><?= toDate($document['datetime'], 'F d, Y h:i:s A') ?></td>
            </tr>
            <tr>
                <th class="align-top pr-3" scope="row">From:</th>
                <td class="text-uppercase"><?= stationName($document['from']) ?></td>
            </tr>
            <tr>
                <th class="align-top pr-3" scope="row">Status:</th>
                <td class="text-uppercase">
                    <?= $document['status'] ?>
                </td>
            </tr>
        </table>

        <div class="d-flex align-items-center flex-row-reverse mt-2 mb-3">
            <div class="d-inline-block">
                <?php
                $hasSuccess = false;

                if ($station === $document['from'] || $isRecordsPortal) {
                    linkButtonSplit(customUri('print', 'Document Tracking Slip', $documentId), 'Print', 'fa-print', 'Print Document Tracking Slip', 'primary', true);
                }

                switch ($documentType) {
                    case 'Incoming Documents':
                        if (!isDocument($documentId, 'Cancel')) {
                            modalButtonSplit(uri() . '/modules/documents/receive-document-dialog.php?id=' . cipher($documentId), 'Receive', 'fa-hand-holding-medical', 'Receive Document', 'success');
                            $hasSuccess = true;
                        }
                        break;
                    case 'Pending Documents':
                        if (!$isSchoolPortal) {
                            modalButtonSplit(uri() . '/modules/documents/forward-document-dialog.php?id=' . cipher($documentId), 'Forward', 'fa-share', 'Forward Document', 'info');
                        }
                        if (isDocument($documentId, 'Restored')) break;
                        modalButtonSplit(uri() . '/modules/documents/complete-document-dialog.php?id=' . cipher($documentId), 'Mark Completed', 'fa-check-circle', 'Mark Complete Document', 'success');
                        break;
                    case 'Outgoing Documents':
                        if (!isDocument($documentId, 'Complete') && !isDocument($documentId, 'Cancel')) {
                            modalButtonSplit(uri() . '/modules/documents/save-document-dialog.php?id=' . cipher($documentId), 'Edit', 'fa-edit', 'Edit Document', 'info');
                        }
                        break;
                    case 'Completed Documents':
                        if (isDocumentFrom($documentId, $station) && $document['from'] === $station && isDocument($documentId, 'Completed')) {
                            modalButtonSplit(uri() . '/modules/documents/incomplete-document-dialog.php?id=' . cipher($documentId), 'Mark Incomplete', 'fa-minus-square', 'Mark Incomplete Document', 'danger');
                        }
                        break;
                    case 'Canceled Documents':
                        if (isDocumentFrom($documentId, $station) && $document['from'] === $station && isDocument($documentId, 'Canceled')) {
                            modalButtonSplit(uri() . '/modules/documents/restore-document-dialog.php?id=' . cipher($documentId), 'Restore', 'fa-undo', 'Restore Document', 'success');
                            $hasSuccess = true;
                        }
                        break;
                    default:
                        break;
                }

                switch ($documentType) {
                    case 'Pending Documents':
                        if ($isSchoolPortal) {
                            break;
                        }

                        $hasSuccess = true;

                        if (isDocumentFrom($documentId, $station) && $document['from'] === $station && !isDocument($documentId, 'Cancel')) {
                            modalButtonSplit(uri() . '/modules/documents/cancel-document-dialog.php?id=' . cipher($documentId), 'Cancel', 'fa-trash-alt', 'Cancel Document', 'danger');
                        }
                        break;
                    case 'Outgoing Documents':
                        if (isDocumentFrom($documentId, $station) && $document['from'] === $station && !isDocument($documentId, 'Cancel')) {
                            modalButtonSplit(uri() . '/modules/documents/cancel-document-dialog.php?id=' . cipher($documentId), 'Cancel', 'fa-trash-alt', 'Cancel Document', 'danger');
                        }
                        break;
                    default:
                        break;
                }

                if ($station === $document['from']) {
                    linkButtonSplit(customUri('export', 'document-log', $documentId), 'Export', 'fa-file-excel', 'Export as Excel file', $hasSuccess ? 'warning' : 'success');
                }
                ?>
            </div>
        </div>

        <div class="timeline">
            <?php
            $logs = documentLogs($documentId);
            $totalLogs = numRows($logs);
            $logCount = 0;

            while ($log = fetchAssoc($logs)) {
                $logCount++;
                $from = stationName($log['from']);
                $to = stationName($log['to']);
                $displayName = userName($log['user']);
                $user = fetchAssoc(employee($log['user']));
                $displayPhoto = file_exists(root() . '/' . $user['picture']) ? uri() . '/' . $user['picture'] : uri() . '/assets/img/user.png';
                $icon = 'flag';
                $hasDestination = !empty($to) && $to !== '-';
                $status = $log['status'];
                $details = $log['details'];
                $attachment = $log['attachment'];
                $isCompleted = str_contains(strtolower($status), 'complete');
                $isCanceled = str_contains(strtolower($status), 'cancel');
                $bgColor = '';

                if ($logCount === 1) {
                    $bgColor = 'bg-success';
                }

                if ($logCount === 1 && $hasDestination) {
                    $icon = 'truck';
                }

                if ($logCount > 1 && $hasDestination) {
                    $icon = 'flag';
                }

                if ($logCount >= 1  && !$hasDestination) {
                    $icon = 'check';
                }

                if ($logCount === 1 && $isCompleted) {
                    $icon = 'trophy';
                }

                if ($logCount === 1 && $isCanceled) {
                    $icon = 'times';
                    $bgColor = 'bg-danger';
                }
            ?>
                <div class="timeline-item">
                    <div class="timeline-item-marker">
                        <div class="timeline-item-marker-text text-uppercase">
                            <?= date('M d, Y', strtotime($log['datetime'])) . '<br>' . date('h:i:s A', strtotime($log['datetime'])) ?>
                        </div>
                        <div class="timeline-item-marker-indicator <?= $bgColor ?>">
                            <i class="fas fa-<?= $icon ?>"></i>
                        </div>
                    </div>
                    <div class="timeline-item-content pt-0">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="timeline-item-content-header-text font-weight-bold text-uppercase mb-0">
                                    <?= $from ?>
                                </h5>
                            </div>

                            <div class="card-body">
                                <div>
                                    <span class="d-inline-block img-profile rounded-circle justify-content-center align-middle overflow-hidden">
                                        <img src="<?= $displayPhoto ?>" alt="<?= $displayName ?>" height="40px" width="40px">
                                    </span>

                                    <div class="ml-2 d-inline-block align-middle">
                                        <div class="text-uppercase"><?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($log['user']), $displayName) ?></div>

                                        <div class="text-uppercase text-xs"><?= fetchAssoc(position($log['user']))['position'] ?></div>
                                    </div>
                                </div>

                                <?= $hasDestination ? '<div class="mb-3">Forwarded to ' . strtoupper($to) . '</div>' : '' ?>

                                <div class="font-weight-bold text-lg"><?= $status ?></div>

                                <?php if (!empty($details)) : ?>
                                    <div class="alert alert-warning d-inline-block px-2 py-1 mt-3 mb-0"><?= $details ?></div>
                                <?php endif ?>
                            </div>

                            <?php if (!empty($attachment) && file_exists(root() . '/' . $attachment)) : ?>
                                <div class="card-footer">
                                    <?php linkButtonSplit(uri() . '/' . $attachment, 'View Attachment', 'fa-eye', 'View Attachment', 'info', true) ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>