<?php
// export/document-log.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once('../includes/database/database.php');
require_once('../includes/database/document.php');
require_once('../includes/string.php');
require_once('../includes/database/school.php');
require_once('../includes/database/section.php');
require_once('../includes/database/employee.php');
require_once('../includes/database/position.php');
require_once('../includes/database/utility.php');

$documentId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$documents = document($documentId);

$document = fetchAssoc($documents);
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <td colspan="5"><?= $document['id'] ?></td>
        </tr>
        <tr>
            <th>Type</th>
            <td colspan="5"><?= fetchArray(documentType($document['type']))['name'] ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td colspan="5"><?= $document['description'] ?></td>
        </tr>
        <tr>
            <th>Created On</th>
            <td colspan="5"><?= toDate($document['datetime'], 'F d, Y h:i:s A') ?></td>
        </tr>
        <tr>
            <th>From</th>
            <td colspan="5"><?= stationName($document['from']) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td colspan="5"><?= $document['status'] ?></td>
        </tr>
        <tr>
            <th>Datetime</th>
            <th>Station/School</th>
            <th>Processed By</th>
            <th>Position</th>
            <th>Status</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $logs = documentLogs($documentId);
        while ($log = fetchAssoc($logs)) : ?>
            <tr>
                <td><?= date('M d, Y h:i:s A', strtotime($log['datetime'])) ?></td>
                <td><?= stationName($log['from']) ?></td>
                <td><?= userName($log['user']) ?></td>
                <td><?= fetchAssoc(position($log['user']))['position'] ?></td>
                <td><?= $log['status'] ?></td>
                <td><?= $log['details'] ?></td>
            </tr>
        <?php endwhile ?>
    </tbody>
</table>