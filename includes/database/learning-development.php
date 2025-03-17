<?php
// includes/database/learning-development.php
// tbl_seminar
// tbl_seminar_participant
function trainings()
{
    return query("SELECT `Training_Code` AS `no`, Title_of_Training AS `title`, `covered_from` AS `from`, `covered_to` AS `to`, `hours`, `Category` AS `type`, `conducted_by` AS `level`, `sponsor`,`TVenue` AS `venue` FROM tbl_seminar ORDER BY `From` DESC, `To` DESC;");
}

function training($id)
{
    return query("SELECT `Training_code` AS `no`, Title_of_Training AS `title`, `covered_from` AS `from`, `covered_to` AS `to`, `hours`, `Category` AS `type`, `conducted_by` AS `level`, `sponsor`, `functional_division`, `TVenue` AS `venue`, `unconsecutive_date`, `generate_certificate` FROM tbl_seminar WHERE `Training_code`='{$id}' LIMIT 1;");
}

function countTrainings($year)
{
    return numRows(query("SELECT `Training_code` AS `no` FROM tbl_seminar WHERE `Training_code` LIKE '%-{$year}-%';"));
}

function createTraining($no, $title, $from, $to, $hours, $type, $level, $sponsor, $venue, $unconsecutiveDate, $signatory, $hasCertificate, $division)
{
    nonQuery("INSERT INTO tbl_seminar (`Training_Code`, `Title_of_training`, `covered_from`, `covered_to`, `hours`, `Category`, `conducted_by`, `sponsor`, `TVenue`, `signatory`, `unconsecutive_date`, `generate_certificate`, `functional_division`) VALUES ('{$no}', '{$title}', '{$from}', '{$to}', '{$hours}', '{$type}', '{$level}', '{$sponsor}', '{$venue}', '{$signatory}', '{$unconsecutiveDate}', '{$hasCertificate}', '{$division}');");
}

function updateTraining($no, $title, $from, $to, $hours, $type, $level, $sponsor, $venue, $unconsecutiveDate, $signatory, $hasCertificate, $division)
{
    nonQuery("UPDATE tbl_seminar SET Title_of_training='{$title}', covered_from='{$from}', covered_to='{$to}', `hours`='{$hours}', Category='{$type}', conducted_by='{$level}', `sponsor`='{$sponsor}', TVenue='{$venue}', `unconsecutive_date`='{$unconsecutiveDate}', `signatory`='{$signatory}', `generate_certificate`='{$hasCertificate}', `functional_division`='{$division}' WHERE Training_Code='{$no}' LIMIT 1;");
}

function scheduledTrainings()
{
    return query("SELECT `Training_Code` AS `no`, Title_of_Training AS `title`, `covered_from` AS `from`, `covered_to` AS `to`, `hours`, `Category` AS `type`, `conducted_by` AS `level`, `sponsor`, `functional_division`, `TVenue` AS `venue` FROM tbl_seminar WHERE `covered_to` >= CURDATE() ORDER BY `From` DESC, `To` DESC;");
}

function conductedTrainings($from, $to)
{
    return query("SELECT `Training_Code` AS `no`, Title_of_Training AS `title`, `covered_from` AS `from`, `covered_to` AS `to`, `hours`, `Category` AS `type`, `conducted_by` AS `level`, `sponsor`, `functional_division`, `TVenue` AS `venue` FROM tbl_seminar WHERE `covered_to` < CURDATE() AND (`covered_from` BETWEEN '{$from}' AND '{$to}' OR `covered_to` BETWEEN '{$from}' AND DATE(DATE_ADD('{$to}', INTERVAL 1 DAY))) ORDER BY `From` DESC, `To` DESC;");
}

function trainingParticipants($no, $id = null)
{
    $filter = $id === null ? '' : "AND tbl_employee.Emp_ID='{$id}' ";
    return query("SELECT tbl_employee.Emp_ID AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `month`, tbl_employee.Emp_Day AS `day`, tbl_employee.Emp_Year AS `year`, tbl_employee.EmpNo AS agency_id, tbl_station.Emp_Position AS position, tbl_station.Emp_Station AS station, tbl_employee.Picture AS picture, tbl_employee.Emp_Email AS email, tbl_employee.Emp_Status AS status FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_seminar_participant ON tbl_employee.Emp_ID = tbl_seminar_participant.Emp_ID WHERE Training_Code='{$no}' {$filter} ORDER BY tbl_employee.Emp_LName;");
}

function createTrainingParticipant($no, $id, $controlNo)
{
    nonQuery("INSERT INTO tbl_seminar_participant (`Training_Code`, `Emp_ID`, `control_no`) VALUES ('{$no}', '{$id}', '{$controlNo}');");
}

function deleteTrainingParticipant($no, $id)
{
    nonQuery("DELETE FROM tbl_seminar_participant WHERE `Training_Code`='{$no}' AND `Emp_ID`='{$id}';");
}

function deleteParticipantTrainings($id)
{
    nonQuery("DELETE FROM tbl_seminar_participant WHERE `Emp_ID`='{$id}';");
}

function isConductedTraining($no)
{
    return numRows(query("SELECT `Training_Code` AS `no` FROM tbl_seminar WHERE `Training_Code`='{$no}' AND `covered_to` < CURDATE() LIMIT 1;")) > 0;
}

function isTrainingParticipant($no, $id)
{
    return numRows(query("SELECT `Training_Code` AS `no`, `Emp_ID` AS `id` FROM tbl_seminar_participant WHERE `Training_Code`='{$no}' AND `Emp_ID`='{$id}' LIMIT 1;")) > 0;
}

function trainingTypes()
{
    return query("SELECT `id`, `type` FROM tbl_training_type;");
}

function trainingType($id)
{
    $types = query("SELECT `type` FROM tbl_training_type WHERE `id`='{$id}';");
    return numRows($types) > 0 ? fetchAssoc($types)['type'] : '';
}

function trainingSponsors()
{
    return query("SELECT `id`, `sponsor` FROM tbl_training_sponsor;");
}

function trainingSponsor($id)
{
    $sponsors = query("SELECT `sponsor` FROM tbl_training_sponsor WHERE `id`='{$id}';");
    return numRows($sponsors) > 0 ? fetchAssoc($sponsors)['sponsor'] : '';
}

function attendedTrainings($id)
{
    return query("SELECT `tbl_seminar`.`Training_Code` AS `no`, `tbl_seminar`.`Title_of_training` AS `title`, `tbl_seminar`.`covered_from` AS `from`, `tbl_seminar`.`covered_to` AS `to`, `tbl_training_sponsor`.`sponsor` AS `level`, `tbl_seminar`.`sponsor`, `tbl_seminar`.`TVenue` AS `venue`, `tbl_training_type`.`type`, `tbl_seminar`.`hours`, `tbl_seminar`.`unconsecutive_date`, `tbl_seminar`.`signatory`, `tbl_seminar`.`generate_certificate`, `tbl_seminar_participant`.`Emp_ID` AS `id` FROM `tbl_seminar` INNER JOIN `tbl_seminar_participant` ON `tbl_seminar`.`Training_Code`=`tbl_seminar_participant`.`Training_Code` INNER JOIN `tbl_training_type` ON `tbl_seminar`.`Category`=`tbl_training_type`.`id` INNER JOIN `tbl_training_sponsor` ON `tbl_seminar`.`conducted_by`=`tbl_training_sponsor`.`id` WHERE `tbl_seminar_participant`.`Emp_ID`='{$id}' ORDER BY `tbl_seminar`.`covered_to` DESC;");
}

function attendedTraining($no, $id)
{
    return query("SELECT `tbl_seminar`.`Training_Code` AS `no`, `tbl_seminar`.`Title_of_training` AS `title`, `tbl_seminar`.`covered_from` AS `from`, `tbl_seminar`.`covered_to` AS `to`, `tbl_training_sponsor`.`sponsor` AS `level`, `tbl_seminar`.`sponsor`, `tbl_seminar`.`TVenue` AS `venue`, `tbl_training_type`.`type`, `tbl_seminar`.`hours`, `tbl_seminar`.`unconsecutive_date`, `tbl_seminar`.`signatory`, `tbl_seminar`.`generate_certificate`, `tbl_seminar_participant`.`Emp_ID`, tbl_seminar_participant.control_no FROM `tbl_seminar` INNER JOIN `tbl_seminar_participant` ON `tbl_seminar`.`Training_Code`=`tbl_seminar_participant`.`Training_Code` INNER JOIN `tbl_training_type` ON `tbl_seminar`.`Category`=`tbl_training_type`.`id` INNER JOIN `tbl_training_sponsor` ON `tbl_seminar`.`conducted_by`=`tbl_training_sponsor`.`id` WHERE `tbl_seminar`.`Training_Code`='{$no}' AND `tbl_seminar_participant`.`Emp_ID`='{$id}' LIMIT 1;");
}

function conductedTrainingsByYear()
{
    return query("SELECT YEAR(`covered_to`) AS `name`, COUNT(*) as `count` FROM `tbl_seminar` GROUP BY YEAR(`covered_to`);");
}

function trainedEmployeesByYear()
{
    return query("SELECT YEAR(`covered_to`) AS `name`, COUNT(DISTINCT Emp_ID) AS `count` FROM `tbl_seminar` INNER JOIN `tbl_seminar_participant` ON `tbl_seminar`.`Training_Code`=`tbl_seminar_participant`.`Training_Code` GROUP BY YEAR(`covered_to`);");
}
