<?php
// modules/employees/delete-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$employeeId = isset($_GET['id']) ? $_GET['id'] : null;

modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this entry?', 'Delete Employee?', 'delete-employee', $employeeId);
