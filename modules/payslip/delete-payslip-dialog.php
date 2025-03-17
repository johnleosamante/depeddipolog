<?php
// modules/payslip/delete-payslip-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$employeeId = isset($_GET['e']) ? $_GET['e'] : null;
$fileId = isset($_GET['id']) ? $_GET['id'] : null;

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete Payslip?', 'delete-payslip', $employeeId, $fileId);
