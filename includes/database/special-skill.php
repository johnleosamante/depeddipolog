<?php
// includes/database/special-skill.php
// tbl_special_skills
function specialSkills($id)
{
    return query("SELECT `No` AS `no`, Special_Skills AS skill, Emp_ID AS id FROM tbl_special_skills WHERE Emp_ID='{$id}' ORDER BY Special_Skills;");
}

function specialSkill($id, $no)
{
    return query("SELECT `No` AS `no`, Special_Skills AS skill, Emp_ID AS id FROM tbl_special_skills WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createSpecialSkill($skill, $id)
{
    nonQuery("INSERT INTO tbl_special_skills (`Special_Skills`, Emp_ID) VALUES ('{$skill}', '{$id}');");
}

function updateSpecialSkill($skill, $id, $no)
{
    nonQuery("UPDATE tbl_special_skills SET Special_Skills='{$skill}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteSpecialSkill($id, $no)
{
    nonQuery("DELETE FROM tbl_special_skills WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteSpecialSkills($id)
{
    nonQuery("DELETE FROM tbl_special_skills WHERE Emp_ID='{$id}';");
}
