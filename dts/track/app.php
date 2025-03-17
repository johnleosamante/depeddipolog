<?php
// dts/track/app.php
$page = $appTitle = 'Document Tracking System';
$searchText = '';
$enableScripts = true;

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('dts/track', 'Document Information', sanitize($_POST['primary-search-text'])));
}
