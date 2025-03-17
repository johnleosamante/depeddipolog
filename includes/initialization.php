<?php
// include/initialization.php
session_start();
date_default_timezone_set("Asia/Manila");
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '1024M');
ini_set('display_errors', 0);
$fileUploadSizeLimit = 20 * 1024 * 1024;
$imageUploadSizeLimit = 2.5 * 1024 * 1024;

$userId = $_SESSION[alias() . '_userId'] ?? null;
$stationId = $_SESSION[alias() . '_stationId'] ?? null;
$station = $_SESSION[alias() . '_station'] ?? null;
$activeApp = $_SESSION[alias() . '_activeApp'] ?? 'pis';
$activeTab = $_SESSION[alias() . '_activeTab'] ?? null;
$code = $_SESSION[alias() . '_code'] ?? null;
$portal = $_SESSION[alias() . '_portal'] ?? null;
$hasPortal = !empty($portal);
$isSchoolPortal = $portal === 'sch_portal';
$isRecordsPortal = $portal === 'rec_portal';
$isDescriptionEditable = $_SESSION[alias() . '_editableDescription'] ?? false;
$showAlert = false;
$message = null;
$success = true;
$enableScripts = false;
