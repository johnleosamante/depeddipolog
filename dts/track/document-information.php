<?php
// dts/track/document-information.php
$documentId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$documents = document($documentId);

if (numRows($documents) > 0) {
    $document = fetchAssoc($documents);
    $documentId = $document['id'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}
?>

<form class="mx-auto mb-4" method="POST" action="">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
            <div class="input-group">
                <input type="text" class="form-control small" placeholder="Search document..." aria-label="Search" name="primary-search-text" value="<?= $documentId ?>" autofocus required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="primary-search-button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle("Document Information: " . strtoupper($documentId)) ?>
    </div>

    <div class="card-body">
        <table cellspacing="0">
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
                    <?= strlen($document['details']) === 0 ? $document['status'] : $document['status'] . ' - ' . $document['details']
                    ?>
                </td>
            </tr>
        </table>

        <div class="mt-5 timeline">
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
                                <div class="mb-3">
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
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>