<?php
// includes/database/school.php
// tbl_school
// tbl_station
// tbl_district
function schools()
{
    return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias, `Address` AS `address`, Incharg_ID AS `head`, District_code AS district, School_Category AS category, SchoolLogo AS logo FROM tbl_school ORDER BY SchoolName;");
}

function districtSchools($id)
{
    return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias, `Address` AS `address`, Incharg_ID AS `head`, District_code AS district, School_Category AS category, SchoolLogo AS logo FROM tbl_school WHERE District_code='{$id}' ORDER BY SchoolName;");
}

function schoolsExcept($id)
{
    return query("SELECT SchoolID AS id, SchoolName AS `name`, Abraviate AS alias, `Address` AS `address`, Incharg_ID AS `head`, District_code AS district, School_Category AS category, SchoolLogo AS logo FROM tbl_school WHERE SchoolID <> '{$id}' ORDER BY SchoolName;");
}

function schoolByAlias($alias)
{
    return query("SELECT SchoolID AS id, SchoolName AS `name`, Incharg_ID AS `head` FROM tbl_school WHERE Abraviate='{$alias}' LIMIT 1;");
}

function schoolById($id)
{
    return query("SELECT Abraviate AS alias, SchoolName AS `name`, Incharg_ID AS `head` FROM tbl_school WHERE SchoolID='{$id}' LIMIT 1;");
}

function schoolDetailsById($id)
{
    return query("SELECT Abraviate AS alias, SchoolName AS `name`, `Address` AS `address`, Incharg_ID AS `head`, District_code AS `district`, School_Category AS category, SchoolLogo AS `logo`, telephone, email, website, fb_page FROM tbl_school WHERE SchoolID='{$id}' LIMIT 1;");
}

function schoolsByDistrict($district)
{
    return query("SELECT SchoolID AS `id`, SchoolName AS `name` FROM tbl_school WHERE District_code='{$district}' ORDER BY SchoolName;");
}

function updateSchoolHead($schoolId, $headId)
{
    nonQuery("UPDATE tbl_school SET `Incharg_ID`='{$headId}' WHERE `SchoolID`='{$schoolId}';");
}

function schoolEmployeeCount($id = null)
{
    $filter = isset($id) ? " AND tbl_school.SchoolID='{$id}'" : '';
    return query("SELECT tbl_school.SchoolID AS id, SUM(CASE WHEN tbl_job.Job_Category = 'Teaching' AND tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS tmale, SUM(CASE WHEN tbl_job.Job_Category = 'Teaching-Related' AND tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS trmale, SUM(CASE WHEN tbl_job.Job_Category = 'Non-Teaching' AND tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS ntmale, SUM(CASE WHEN tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS male, SUM(CASE WHEN tbl_job.Job_Category = 'Teaching' AND tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) AS tfemale, SUM(CASE WHEN tbl_job.Job_Category = 'Teaching-Related' AND tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) AS trfemale, SUM(CASE WHEN tbl_job.Job_Category = 'Non-Teaching' AND tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) AS ntfemale, SUM(CASE WHEN tbl_employee.Emp_Sex = 'Female' THEN 1 ELSE 0 END) AS female, COUNT(*) AS total FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status='Active' {$filter} GROUP BY tbl_school.SchoolName ORDER BY tbl_district.District_Name, tbl_school.School_Category, tbl_school.SchoolName;");
}

function createSchool($id, $name, $alias, $address, $district, $category, $telephone, $email, $website, $facebook, $logo)
{
    nonQuery("INSERT INTO tbl_school (`SchoolID`, `SchoolName`, `Abraviate`, `Address`, `District_code`, `School_Category`, `telephone`, `email`, `website`, `fb_page`, `SchoolLogo`) VALUES ('{$id}', '{$name}', '{$alias}', '{$address}', '{$district}', '{$category}', '{$telephone}', '{$email}', '{$website}', '{$facebook}', '{$logo}');");
}

function updateSchool($id, $name, $alias, $address, $district, $category, $telephone, $email, $website, $facebook, $logo, $referenceId)
{
    nonQuery("UPDATE tbl_school SET `SchoolID`='{$id}', `SchoolName`='{$name}', `Abraviate`='{$alias}', `Address`='{$address}', `District_code`='{$district}', `School_Category`='{$category}', `telephone`='{$telephone}', `email`='{$email}', `website`='{$website}', `fb_page`='{$facebook}', `SchoolLogo`='{$logo}' WHERE `SchoolID`='{$referenceId}' LIMIT 1;");
}

function deleteSchool($id)
{
    nonQuery("DELETE FROM tbl_school WHERE `SchoolID`='{$id}' LIMIT 1;");
}

function station($id)
{
    return query("SELECT `No`, Emp_Position AS position_id, Emp_Station AS station_id, Emp_DOA AS doa, Emp_ID AS id FROM tbl_station WHERE Emp_ID='{$id}' ORDER BY Emp_DOA DESC LIMIT 1;");
}

function createStation($date, $stationId, $positionId, $id)
{
    nonQuery("INSERT INTO tbl_station (`Emp_DOA`, Emp_Station, Emp_Position, Emp_ID) VALUES ('{$date}', '{$stationId}', '{$positionId}', '{$id}');");
}

function updateStation($date, $stationId, $positionId, $id)
{
    nonQuery("UPDATE tbl_station SET Emp_Position='{$positionId}', Emp_Station='{$stationId}', Emp_DOA='{$date}' WHERE Emp_ID='{$id}';");
}

function deleteStation($id)
{
    nonQuery("DELETE FROM tbl_station WHERE Emp_ID='{$id}';");
}

function updateStationID($newStationId, $oldStationId)
{
    nonQuery("UPDATE tbl_station SET `Emp_Station`='{$newStationId}' WHERE `Emp_Station`='{$oldStationId}';");
}

function district($id)
{
    return query("SELECT District_code AS `id`, District_Name AS `name`, Emp_ID AS `psds` FROM tbl_district WHERE District_code='{$id}' LIMIT 1;");
}

function districts()
{
    return query("SELECT District_code AS `id`, District_Name AS `name`, Emp_ID AS `psds` FROM tbl_district ORDER BY District_Name ASC;");
}

function districtSchoolCount($id)
{
    return query("SELECT SUM(CASE WHEN tbl_school.School_Category='Elementary' THEN 1 ELSE 0 END) AS es, SUM(CASE WHEN tbl_school.School_Category='Secondary' THEN 1 ELSE 0 END) AS hs, SUM(CASE WHEN tbl_school.School_Category='Integrated' THEN 1 ELSE 0 END) AS `is`, COUNT(*) AS `total` FROM tbl_school INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code WHERE tbl_school.District_code='{$id}' LIMIT 1;");
}

function createDistrict($id, $district, $head)
{
    nonQuery("INSERT INTO tbl_district (`District_code`, `District_Name`, `Emp_ID`) VALUES ('{$id}', '{$district}', '{$head}');");
}

function updateDistrict($newCode, $district, $head, $oldCode)
{
    nonQuery("UPDATE tbl_district SET `District_code`='{$newCode}', `District_Name`='{$district}', `Emp_ID`='{$head}' WHERE `District_code`='{$oldCode}' LIMIT 1;");
}

function deleteDistrict($id)
{
    nonQuery("DELETE FROM tbl_district WHERE `District_code`='{$id}' LIMIT 1;");
}
