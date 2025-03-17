<?php
// includes/database/education.php
// educational_background
function educationalBackgrounds($id)
{
    return query("SELECT `No` AS `no`, `Level` AS `level`, Name_of_School AS school, Course AS course, `From` AS `from`, `To` AS `to`, ispresent, Highest_Level AS highest, Year_Graduated AS year_graduated, Honor_Recieved AS scholarship, Emp_ID AS id FROM educational_background WHERE Emp_ID='{$id}' ORDER BY `From` ASC, `To` ASC;");
}

function educationalBackground($id, $no)
{
    return query("SELECT `No` AS `no`, `Level` AS `level`, Name_of_School AS school, Course AS course, `From` AS `from`, `To` AS `to`, ispresent, Highest_Level AS highest, Year_Graduated AS year_graduated, Honor_Recieved AS scholarship, Emp_ID AS id FROM educational_background WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createEducation($level, $school, $course, $from, $to, $ispresent, $highest, $year, $scholarship, $id)
{
    nonQuery("INSERT INTO educational_background (`Level`, `Name_of_School`, `Course`, `From`, `To`, `ispresent`, Highest_Level, Year_Graduated, Honor_Recieved, Emp_ID) VALUES ('{$level}', '{$school}', '{$course}', '{$from}', '{$to}', '{$ispresent}', '{$highest}', '{$year}', '{$scholarship}', '{$id}');");
}

function updateEducation($level, $school, $course, $from, $to, $ispresent, $highest, $year, $scholarship, $id, $no)
{
    nonQuery("UPDATE educational_background SET `Level`='{$level}', Name_of_School='{$school}', Course='{$course}', `From`='{$from}', `To`='{$to}', `ispresent`='{$ispresent}', Highest_Level='{$highest}', Year_Graduated='{$year}', Honor_Recieved='{$scholarship}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteEducation($id, $no)
{
    nonQuery("DELETE FROM educational_background WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteEducations($id)
{
    nonQuery("DELETE FROM educational_background WHERE Emp_ID='{$id}';");
}
