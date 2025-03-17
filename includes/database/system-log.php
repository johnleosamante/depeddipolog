<?php
// includes/database/system-log.php
// tbl_employee
// tbl_system_logs
function userLog($id)
{
    return query("SELECT `Time_Log` AS `datetime`, `Status` AS `activity`, `target_id` AS `target`, `IPAddress` AS `ip` FROM tbl_system_logs WHERE Emp_ID='{$id}' ORDER BY `Time_Log` DESC;");
}

function systemLogs($from, $to)
{
    return query("SELECT `Time_log` AS `datetime`, `Status` AS `activity`, `Emp_ID` AS `target`, `IPAddress` AS `ip` FROM tbl_system_logs WHERE `Status` NOT LIKE '%document%' AND `Time_Log` BETWEEN '{$from}' AND DATE(DATE_ADD('{$to}', INTERVAL 1 DAY)) ORDER BY `Time_Log` DESC;");
}

function createSystemLog($stationId, $id, $status, $targetId, $ip)
{
    nonQuery("INSERT INTO tbl_system_logs (`SchoolID`, `Emp_ID`, `Time_Log`, `Status`, `target_id`, `IPAddress`) VALUES ('{$stationId}', '{$id}', NOW(), '{$status}', '{$targetId}', '{$ip}');");
}

function employeeEditHistory($id)
{
    return query("SELECT `Time_log` AS `datetime`, `Status` AS `activity`, `Emp_ID` AS `editor`, `IPAddress` AS `ip` FROM tbl_system_logs WHERE `target_id`='{$id}' AND `Status` NOT LIKE '%logged%' ORDER BY `Time_Log` DESC;");
}
