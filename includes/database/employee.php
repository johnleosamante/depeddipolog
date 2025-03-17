<?php
// includes/database/employee.php
// tbl_employee
// tbl_station
// tbl_district
// tbl_school
// tbl_job
function employee($id)
{
    return query("SELECT Emp_ID AS id, Emp_LName AS lname, Emp_FName AS fname, Emp_MName AS mname, Emp_Extension AS ext, Emp_Month AS `month`, Emp_Day AS `day`, Emp_Year AS `year`, Emp_place_of_birth AS `pob`, Emp_Sex AS sex, Emp_Res_Lot AS rlot, Emp_Res_Street AS rstreet, Emp_Res_Subdivision AS rsubdivision, Emp_Res_Barangay AS rbarangay, Emp_Res_City AS rcity, Emp_Address AS rprovince, Emp_Res_ZIP AS rzip, Emp_Per_Lot AS plot, Emp_Per_Street AS pstreet, Emp_Per_Subdivision AS psubdivision, Emp_Per_Barangay AS pbarangay, Emp_Per_City AS pcity, Emp_Per_Province AS pprovince, Emp_Per_ZIP AS pzip, Emp_Telephone AS telephone, Emp_CS AS civil_status, Emp_CS_Others AS civil_status_specify, Emp_Citizen AS citizenship, Emp_Dual_Citizenship AS dual_citizenship, Emp_Country AS country, Emp_Height AS height, Emp_Weight AS `weight`, Emp_Blood_type AS blood_type, Emp_GSIS AS crn, Emp_GSIS_BP AS bp, Emp_PAGIBIG AS pagibig, Emp_PHILHEALTH AS philhealth, Emp_SSS AS sss, Emp_Cell_No AS mobile, Emp_Email AS email, Picture AS picture, Emp_TIN AS tin, Emp_Status AS `status`, beforeTitle AS btitle, afterTitle AS atitle, EmpNo AS agency_id FROM tbl_employee WHERE Emp_ID='{$id}' LIMIT 1;");
}

function employees()
{
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Status AS status FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Status <> 'Duplicate' ORDER BY tbl_employee.Emp_LName;");
}
function employeeName($lname, $fname, $mname, $ext)
{
    return query("SELECT Emp_ID AS id, Emp_LName AS lname, Emp_FName AS fname, Emp_MName AS mname, Emp_Extension AS ext FROM tbl_employee WHERE Emp_LName='{$lname}' AND Emp_FName='{$fname}' AND Emp_MName='{$mname}' AND Emp_Extension='{$ext}' LIMIT 1;");
}

function employeeContactDetails($id)
{
    return query("SELECT Emp_ID AS id, Emp_Email AS email, Emp_Alternate_Email AS alternate_email, Emp_Telephone AS telephone, Emp_Cell_No AS mobile, Emp_Alternate_Cell_No AS alternate_mobile FROM tbl_employee WHERE Emp_ID='{$id}' LIMIT 1;");
}

function updateEmployeeContactDetails($mobile, $email, $id)
{
    nonQuery("UPDATE tbl_employee SET Emp_Alternate_Cell_No='{$mobile}', Emp_Alternate_Email='{$email}' WHERE Emp_ID='{$id}' LIMIT 1;");
}

function districtSupervisors()
{
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_station.Emp_Position AS position FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' AND (tbl_station.Emp_Position='PSDS' OR tbl_station.Emp_Position='SDS') ORDER BY tbl_employee.Emp_LName ASC;");
}

function activeEmployees($station = null)
{
    $filter = $station === null ? '' : " AND tbl_station.Emp_Station='{$station}'";
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `month`, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, tbl_employee.EmpNo AS agency_id, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Email AS email, tbl_employee.Emp_Cell_No AS mobile FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' {$filter} ORDER BY tbl_employee.Emp_LName ASC;");
}

function retirableEmployees($station = null)
{
    $filter = $station === null ? '' : " AND station='{$station}'";
    return query("SELECT * FROM (SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `month`, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, tbl_employee.EmpNo AS agency_id, YEAR(CURRENT_DATE) - CONVERT(tbl_employee.Emp_Year, DECIMAL) AS year_age, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active') AS employee WHERE year_age >= 60 {$filter} ORDER BY lname ASC;");
}

function archivedEmployees()
{
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS month, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, tbl_employee.EmpNo AS agency_id, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Status AS `status`  FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE (tbl_employee.Emp_Status NOT LIKE 'Active' AND tbl_employee.Emp_Status NOT LIKE 'Registered') ORDER BY tbl_employee.Emp_LName ASC;");
}

function employeeSearch($text)
{
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `month`, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, tbl_employee.EmpNo AS agency_id, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Status AS `status`  FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_ID='{$text}' OR tbl_employee.Emp_LName LIKE '%{$text}%' OR tbl_employee.Emp_FName LIKE '%{$text}%' OR tbl_employee.Emp_MName LIKE '%{$text}%' OR tbl_employee.Emp_GSIS='{$text}' OR tbl_employee.Emp_PAGIBIG='{$text}' OR tbl_employee.Emp_PHILHEALTH='{$text}' OR tbl_employee.Emp_SSS='{$text}' OR tbl_employee.Emp_TIN='{$text}' OR tbl_employee.EmpNo='{$text}' ORDER BY tbl_employee.Emp_LName ASC, tbl_employee.Emp_FName ASC, tbl_employee.Emp_MName ASC;");
}

function employeeGender()
{
    return query("SELECT Emp_Sex AS `name`, COUNT(*) AS `count` FROM tbl_employee WHERE Emp_Status='Active' GROUP BY Emp_Sex ORDER BY Emp_Sex DESC;");
}

function employeeStation()
{
    return query("SELECT tbl_school.SchoolName AS `name`, COUNT(*) AS `count` FROM tbl_station INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_school.SchoolName ORDER BY tbl_district.District_Name, tbl_school.SchoolName;");
}

function employeePosition()
{
    return query("SELECT tbl_job.Job_description AS `name`, COUNT(*) AS `count` FROM tbl_station INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_job.Job_description ORDER BY tbl_job.Salary_Grade DESC, tbl_job.Job_description ASC;");
}

function districtEmployee()
{
    return query("SELECT tbl_district.District_Name AS name, COUNT(*) AS count FROM tbl_station INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_district ON tbl_school.District_code=tbl_district.District_code WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_district.District_Name ORDER BY tbl_district.District_Name;");
}

function employeeCategory()
{
    return query("SELECT tbl_job.Job_Category AS name, COUNT(*) AS count FROM tbl_job INNER JOIN tbl_station ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_job.Job_Category ORDER BY tbl_job.Job_Category;");
}

function employeeGenderCategory()
{
    return query("SELECT tbl_job.Job_Category AS `name`, COUNT(CASE WHEN tbl_employee.Emp_Sex='Male' THEN 1 END) AS male, COUNT(CASE WHEN tbl_employee.Emp_Sex='Female' THEN 1 END) AS female FROM tbl_job INNER JOIN tbl_station ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active' GROUP BY tbl_job.Job_Category ORDER BY tbl_job.Job_Category;");
}

function celebrantEmployees($month, $station = null)
{
    $filter = $station === null ? '' : " AND station_code='{$station}'";
    return query("SELECT * FROM (SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `month`, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, tbl_employee.EmpNo AS agency_id, YEAR(CURRENT_DATE) - CONVERT(tbl_employee.Emp_Year, DECIMAL) AS year_age, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_station.Emp_Station AS station_code, tbl_employee.Picture AS picture FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Status='Active') AS employee WHERE `month`='{$month}' {$filter} ORDER BY `day` ASC;");
}

function createEmployee($id, $lname, $fname, $mname, $ext, $sex, $bmonth, $bday, $byear, $email, $mobile, $image, $status)
{
    nonQuery("INSERT INTO tbl_employee (Emp_ID, Emp_LName, Emp_FName, Emp_MName, Emp_Extension, Emp_Sex, Emp_Month, Emp_Day, Emp_Year, Emp_Email, Emp_Cell_No, Picture, Emp_Status) VALUES ('{$id}', '{$lname}', '{$fname}', '{$mname}', '{$ext}', '{$sex}', '{$bmonth}', '{$bday}', '{$byear}', '{$email}', '{$mobile}', '{$image}', '{$status}');");
}

function updateEmployee($lname, $fname, $mname, $ext, $bmonth, $bday, $byear, $pob, $sex, $civilStatus, $civilStatusSpecify, $citizenship, $dualCitizenship, $country, $rlot, $rstreet, $rsubdivision, $rbarangay, $rcity, $rprovince, $rzip, $plot, $pstreet, $psubdivision, $pbarangay, $pcity, $pprovince, $pzip, $height, $weight, $bloodType, $crn, $bp, $pagibig, $philhealth, $sss, $telephone, $mobile, $email, $tin, $agencyId, $photo, $id)
{
    nonQuery("UPDATE tbl_employee SET Emp_LName='{$lname}', Emp_FName='{$fname}', Emp_MName='{$mname}', Emp_Extension='{$ext}', Emp_Month='{$bmonth}', Emp_Day='{$bday}', Emp_Year='{$byear}', Emp_place_of_birth='{$pob}', Emp_Sex='{$sex}', Emp_CS='{$civilStatus}', Emp_CS_Others='{$civilStatusSpecify}', Emp_Citizen='{$citizenship}', Emp_Dual_Citizenship='{$dualCitizenship}', Emp_Country='{$country}', Emp_Res_Lot='{$rlot}', Emp_Res_Street='{$rstreet}', Emp_Res_Subdivision='{$rsubdivision}', Emp_Res_Barangay='{$rbarangay}', Emp_Res_City='{$rcity}', Emp_Address='{$rprovince}', Emp_Res_ZIP='{$rzip}', Emp_Per_Lot='{$plot}', Emp_Per_Street='{$pstreet}', Emp_Per_Subdivision='{$psubdivision}', Emp_Per_Barangay='{$pbarangay}', Emp_Per_City='{$pcity}', Emp_Per_Province='{$pprovince}', Emp_Per_ZIP='{$pzip}', Emp_Height='{$height}', Emp_Weight='{$weight}', Emp_Blood_type='{$bloodType}', Emp_GSIS='{$crn}', Emp_GSIS_BP='{$bp}', Emp_PAGIBIG='{$pagibig}', Emp_PHILHEALTH='{$philhealth}', Emp_SSS='{$sss}', Emp_Telephone='{$telephone}', Emp_Cell_No='{$mobile}', Emp_Email='{$email}', Emp_TIN='{$tin}', EmpNo='{$agencyId}', Picture='{$photo}' WHERE Emp_ID='{$id}' LIMIT 1;");
}

function isDuplicateEmployee($id)
{
    $duplicate = query("SELECT `Emp_ID` FROM tbl_employee WHERE `Emp_ID`='{$id}' AND `Emp_Status`='duplicate' LIMIT 1;");
    return numRows($duplicate) === 1;
}

function deleteEmployee($id)
{
    nonQuery("DELETE FROM tbl_employee WHERE `Emp_ID`='{$id}';");
}

function updateEmployeeStatus($status, $id)
{
    nonQuery("UPDATE tbl_employee SET Emp_Status='{$status}' WHERE Emp_ID='{$id}' LIMIT 1;");
}

function updateProfessionalTitles($before, $after, $id)
{
    nonQuery("UPDATE tbl_employee SET beforeTitle='{$before}', afterTitle='{$after}' WHERE Emp_ID='{$id}' LIMIT 1;");
}

function updateProfilePhoto($photo, $id)
{
    nonQuery("UPDATE tbl_employee SET Picture='{$photo}' WHERE Emp_ID='{$id}' LIMIT 1;");
}

function employeeStepIncrement()
{
    return query("SELECT * FROM (SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Picture AS picture, tbl_station.Emp_Position AS position, tbl_job.Salary_Grade AS sg, tbl_station.Emp_Station AS station, tbl_step_increment.Date_last_step AS last_step_date, tbl_step_increment.Step_No AS step, TIMESTAMPDIFF(YEAR, Date_last_step, NOW()) AS years_active FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_step_increment ON tbl_employee.Emp_ID=tbl_step_increment.Emp_ID WHERE tbl_employee.Emp_Status='Active' ORDER BY Date_last_step) AS service_years WHERE years_active >= 3 AND step < 8;");
}

function employeeLoyaltyAward()
{
    return query("SELECT * FROM (SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Picture AS picture, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, psipop.Original_Appointment AS original_appointment, tbl_loyalty_award.last_awarded_on, TIMESTAMPDIFF(YEAR, psipop.Original_Appointment, NOW()) AS years_active, TIMESTAMPDIFF(YEAR, tbl_loyalty_award.last_awarded_on, NOW()) AS last_awarded FROM tbl_employee INNER JOIN psipop ON tbl_employee.Emp_ID=psipop.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_loyalty_award ON tbl_employee.Emp_ID=tbl_loyalty_award.employee_id WHERE tbl_employee.Emp_Status='Active' ORDER BY tbl_loyalty_award.last_awarded_on) AS service_years WHERE years_active >= 10 AND last_awarded >= 5;");
}

function employeePositions()
{
    return query("SELECT `tbl_job`.`Job_description` AS `position`, COUNT(CASE WHEN `tbl_employee`.`Emp_Sex`='Male' THEN 1 END) AS `male`, COUNT(CASE WHEN `tbl_employee`.`Emp_Sex`='Female' THEN 1 END) AS `female`, COUNT(`tbl_station`.`Emp_Position`) AS `total` FROM `tbl_employee` INNER JOIN `tbl_station` ON `tbl_employee`.`Emp_ID`=`tbl_station`.`Emp_ID` INNER JOIN `tbl_job` ON `tbl_station`.`Emp_Position`=`tbl_job`.`Job_code` WHERE `tbl_employee`.`Emp_Status`='Active' GROUP BY `tbl_station`.`Emp_Position` ORDER BY `tbl_job`.`Salary_Grade` DESC;");
}
