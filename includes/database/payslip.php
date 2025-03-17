<?php
// payslips
function payslips($employeeId)
{
    return query("SELECT `id`, `employee_id`, `description`, `filename`, `ext`, `created_at`, `updated_at`, `created_by`, `updated_by` FROM `payslips` WHERE `employee_id`='{$employeeId}' ORDER BY `updated_at` DESC;");
}

function payslip($employeeId, $id)
{
    return query("SELECT `id`, `employee_id`, `description`, `filename`, `ext`, `created_at`, `updated_at`, `created_by`, `updated_by` FROM `payslips` WHERE `employee_id`='{$employeeId}' AND `id`='{$id}' LIMIT 1;");
}

function createPayslip($description, $filename, $ext, $employeeId)
{
    nonQuery("INSERT INTO `payslips` (`employee_id`, `description`, `filename`, `ext`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ('{$employeeId}', '{$description}', '{$filename}', '{$ext}', NOW(), NOW(), '{$employeeId}', '{$employeeId}');");
}

function updatePayslip($description, $filename, $ext, $employeeId, $id)
{
    nonQuery("UPDATE `payslips` SET `description`='{$description}', `filename`='{$filename}', `ext`='{$ext}', `updated_at`=NOW(), `updated_by`='{$employeeId}' WHERE `employee_id`='{$employeeId}' AND `id`='{$id}' LIMIT 1;");
}

function deletePayslip($employeeId, $id)
{
    nonQuery("DELETE FROM `payslips` WHERE `employee_id`='{$employeeId}' AND `id`='{$id}' LIMIT 1;");
}

function deletePayslips($employeeId)
{
    nonQuery("DELETE FROM `payslips` WHERE `employee_id`='{$employeeId}'");
}
