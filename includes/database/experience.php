<?php
// includes/database/experience.php
// work_experience
function experiences($id)
{
    return query("SELECT `No` AS `no`, `From` AS `from`, `To` AS `to`, `ispresent`, `Position_Title` AS `position`, `position_code`, Job_Status AS `status`, Goverment AS isgovernment, Salary_Grade AS sg, Monthly_Salary AS salary, Organization AS organization, `organization_alias`, `leave_dates`, `isseparation`, `separation_date`, `separation_cause`, Emp_ID AS id FROM work_experience WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}

function experience($id, $no)
{
    return query("SELECT `No` AS `no`, `From` AS `from`, `To` AS `to`, `ispresent`, `Position_Title` AS `position`, `position_code`, Job_Status AS `status`, Goverment AS isgovernment, Salary_Grade AS sg, Monthly_Salary AS salary, Organization AS organization, `organization_alias`, `leave_dates`, `isseparation`, `separation_date`, `separation_cause`, Emp_ID AS id FROM work_experience WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createExperience($from, $to, $isPresent, $position, $positionCode, $status, $isGovernment, $sg, $salary, $organization, $organizationAlias, $leaveDates, $isSeparation, $separationDate, $separationCause, $id)
{
    nonQuery("INSERT INTO work_experience (`From`, `To`, ispresent, `Position_Title`, `position_code`, `Job_Status`, Goverment, Salary_Grade, Monthly_Salary, `Organization`,  `organization_alias`, `leave_dates`, `isseparation`, `separation_date`, `separation_cause`, Emp_ID) VALUES ('{$from}', '{$to}', '{$isPresent}', '{$position}', '{$positionCode}', '{$status}', '{$isGovernment}', '{$sg}', '{$salary}', '{$organization}', '{$organizationAlias}', '{$leaveDates}', '{$isSeparation}', '{$separationDate}', '{$separationCause}', '{$id}');");
}

function updateExperience($from, $to, $isPresent, $position, $positionCode, $status, $isGovernment, $sg, $salary, $organization, $organizationAlias, $leaveDates, $isSeparation, $separationDate, $separationCause, $id, $no)
{
    nonQuery("UPDATE work_experience SET `From`='{$from}', `To`='{$to}', ispresent='{$isPresent}', `Position_Title`='{$position}', `position_code`='{$positionCode}', Job_Status='{$status}', Goverment='{$isGovernment}', Salary_Grade='{$sg}', Monthly_Salary='{$salary}', `Organization`='{$organization}', `organization_alias`='{$organizationAlias}', `leave_dates`='{$leaveDates}', `isseparation`='{$isSeparation}', `separation_date`='{$separationDate}', `separation_cause`='{$separationCause}' WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteExperience($id, $no)
{
    nonQuery("DELETE FROM work_experience WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteExperiences($id)
{
    nonQuery("DELETE FROM work_experience WHERE Emp_ID='{$id}';");
}

function governmentService($id)
{
    return query("SELECT `No` AS `no`, `From` AS `from`, `To` AS `to`, `ispresent`, `position_code` AS `position`, `organization_alias` AS `station`, `Salary_Grade` AS `sg`, `Monthly_Salary` AS `salary`, `Job_Status` AS `status`, `Goverment` AS `isgovernment`, `leave_dates`, `isseparation`, `separation_date`, `separation_cause`, `Emp_ID` AS `id` FROM `work_experience` WHERE `Emp_ID`='{$id}' AND `Goverment`='Y' ORDER BY `From` DESC;");
}
