<?php
// includes/database/section.php
// tbl_div_section
// tbl_functional_division
function functionalDivisions()
{
    return query("SELECT Div_Code AS id, Division_Name AS `name` FROM tbl_division ORDER BY `name` ASC;");
}

function functionalDivision($id)
{
    return query("SELECT Div_Code AS id, Division_Name AS `name` FROM tbl_division WHERE Div_Code='{$id}' LIMIT 1;");
}

function sectionsExcept($id)
{
    return query("SELECT Section_Code AS id, Section_Incharge AS `head`, Section_Office AS `name`, functional_division AS division FROM tbl_div_section WHERE Section_Code <> '{$id}' ORDER BY Section_Office ASC;");
}

function sections($division = null)
{
    $filter = empty($division) ? '' : "WHERE tbl_div_section.functional_division='{$division}'";
    return query("SELECT tbl_div_section.Section_Code AS id, tbl_div_section.Section_Incharge AS `head`, tbl_div_section.Section_Office AS `name`, tbl_division.Division_Name AS `division` FROM tbl_div_section INNER JOIN tbl_division ON tbl_div_section.functional_division=tbl_division.Div_Code {$filter} ORDER BY Section_Office ASC;");
}

function section($id)
{
    return query("SELECT Section_Code AS id, Section_Incharge AS `head`, Section_Office AS `name`, functional_division AS division FROM tbl_div_section WHERE Section_Code='{$id}' LIMIT 1;");
}

function sectionEmployeeCount($id)
{
    return query("SELECT SUM(CASE WHEN tbl_employee.Emp_Sex = 'Male' THEN 1 ELSE 0 END) AS male, SUM(CASE WHEN tbl_employee.Emp_Sex='Female' THEN 1 ELSE 0 END) AS female, COUNT(*) AS `total` FROM tbl_employee INNER JOIN tbl_user ON tbl_employee.Emp_ID=tbl_user.usercode INNER JOIN tbl_div_section ON tbl_user.Station=tbl_div_section.Section_Code WHERE tbl_employee.Emp_Status='Active' AND tbl_user.Station='{$id}' GROUP BY tbl_div_section.Section_Office;");
}

function createSection($alias, $head, $name, $division)
{
    nonQuery("INSERT INTO tbl_div_section (`Section_Code`, `Section_Incharge`, `Section_Office`, `functional_division`) VALUES ('{$alias}', '{$head}', '{$name}', '{$division}');");
}

function updateSection($newAlias, $head, $name, $division, $oldAlias)
{
    nonQuery("UPDATE tbl_div_section SET `Section_Code`='{$newAlias}', `Section_Incharge`='{$head}', `Section_office`='{$name}', `functional_division`='{$division}' WHERE `Section_Code`='{$oldAlias}' LIMIT 1;");
}
