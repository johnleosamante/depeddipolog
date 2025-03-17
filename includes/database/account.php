<?php
// includes/database/account.php
// tbl_employee
// tbl_teacher_account
// tbl_user
function account($email)
{
    return query("SELECT `Emp_ID` AS `id`, `Emp_Email` AS `email` FROM `tbl_employee` WHERE `Emp_Status`='Active' AND `Emp_Email`='{$email}' LIMIT 1;");
}

function accountPassword($id, $password)
{
    return query("SELECT `Teacher_TIN` AS `id`, `Pass_status` AS `status` FROM tbl_teacher_account WHERE `Teacher_TIN`='{$id}' AND Teacher_Password='{$password}';");
}

function createAccount($id, $password)
{
    nonQuery("INSERT INTO tbl_teacher_account (`Teacher_TIN`, `Teacher_Password`, `Pass_status`) VALUES ('{$id}', '{$password}', 'Default');");
}

function deleteAccount($id)
{
    nonQuery("DELETE FROM tbl_teacher_account WHERE `Teacher_TIN`='{$id}';");
}

function updateAccountPassword($id, $password, $status = null)
{
    $filter = !empty($status) ? ", Pass_status='{$status}'" : '';
    nonQuery("UPDATE tbl_teacher_account SET Teacher_Password='{$password}'{$filter} WHERE Teacher_TIN='{$id}' LIMIT 1;");
}

function user($id)
{
    return query("SELECT tbl_user.usercode AS id, tbl_user.Station AS code, tbl_station.Emp_Station AS station_id, tbl_user.Link AS portal FROM tbl_user INNER JOIN tbl_station ON tbl_user.usercode=tbl_station.Emp_ID WHERE usercode='{$id}' LIMIT 1;");
}

function userRole($id, $station)
{
    return query("SELECT usercode AS id FROM tbl_user WHERE usercode='{$id}' AND Station='{$station}' LIMIT 1;");
}

function users()
{
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Email AS email, tbl_user.Station AS code, tbl_user.Link AS portal, tbl_user.Station AS `station`, tbl_station.Emp_Station AS `assignment`, tbl_station.Emp_Position AS position, tbl_employee.Picture AS picture, tbl_employee.Emp_Status AS `status` FROM tbl_employee INNER JOIN tbl_user ON tbl_employee.Emp_ID=tbl_user.usercode INNER JOIN tbl_station ON tbl_user.usercode=tbl_station.Emp_ID GROUP BY tbl_user.usercode ORDER BY tbl_employee.Emp_LName ASC;");
}

function dtsUser($id)
{
    return query("SELECT `id`, `Station` AS `station`, `Link` AS `portal` FROM tbl_user WHERE usercode='{$id}' AND Link <> '';");
}

function isStationUser($id, $station)
{
    return numRows(query("SELECT `id` FROM tbl_user WHERE usercode='$id' AND Station='$station';")) > 0;
}

function createUserRole($id, $role, $station, $portal = null)
{
    nonQuery("INSERT INTO tbl_user (`usercode`, `position`, `Station`, `Link`) VALUES ('$id', '$role', '$station', '$portal');");
}

function updateUserRole($id, $station, $portal = null)
{
    $filter = !empty($portal) ? ", Link='{$portal}'" : '';
    nonQuery("UPDATE tbl_user SET Station='{$station}'{$filter} WHERE usercode='$id' AND Link LIKE '%_portal%';");
}

function deleteUserRole($id, $station)
{
    nonQuery("DELETE FROM tbl_user WHERE usercode='$id' AND Station='$station' LIMIT 1;");
}

function deleteUserRoles($id)
{
    nonQuery("DELETE FROM tbl_user WHERE usercode='$id';");
}

function sectionUsers($id)
{
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `month`, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, tbl_employee.EmpNo AS agency_id, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Email AS email, tbl_employee.Emp_Cell_No AS mobile FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_user ON tbl_employee.Emp_ID=tbl_user.usercode WHERE tbl_employee.Emp_Status='Active' AND tbl_user.Station='{$id}' ORDER BY tbl_employee.Emp_LName ASC;");
}

function portalUsers($id, $from, $to)
{
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Picture AS picture, tbl_station.Emp_Position AS position FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_transactions_log ON tbl_employee.Emp_ID = tbl_transactions_log.Recieved_by WHERE tbl_transactions_log.From_office='{$id}' AND tbl_transactions_log.Date_recieved BETWEEN '{$from}' AND DATE(DATE_ADD('{$to}', INTERVAL 1 DAY)) GROUP BY tbl_employee.Emp_ID ORDER BY tbl_employee.Emp_LName ASC;");
}

function updateUsersStation($newStation, $oldStation, $link = null)
{
    $filter = !empty($link) ? ", Link='{$link}'" : '';
    nonQuery("UPDATE tbl_user SET Station='{$newStation}'{$filter} WHERE Station='{$oldStation}';");
}
