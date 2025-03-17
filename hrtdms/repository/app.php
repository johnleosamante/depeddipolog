<?php
// hrtdms/repository/app.php
$page = $appTitle = 'Division Training Certificate Finder';
$enableScripts = true;

$fromDate = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$toDate = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
    $fromDate = date('Y-m-d', strtotime($_POST['date-from']));
    $toDate = date('Y-m-d', strtotime($_POST['date-to']));
    redirect(customUri('hrtdms/repository', sanitize(decipher($_GET['v']))) . '&from=' . $fromDate . '&to=' . $toDate);
}
