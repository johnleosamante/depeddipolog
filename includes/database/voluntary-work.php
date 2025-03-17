<?php
// includes/database/voluntary_work.php
// voluntary_work
function voluntaryWorks($id)
{
    return query("SELECT `No` AS `no`, Name_of_Organization AS organization, `From` AS `from`, `To` AS `to`, ispresent, Number_of_Hour AS `hours`, Position AS `position`, Emp_ID AS id FROM voluntary_work WHERE Emp_ID='{$id}' ORDER BY `From` DESC, `To` DESC;");
}

function voluntaryWork($id, $no)
{
    return query("SELECT `No` AS `no`, Name_of_Organization AS organization, `From` AS `from`, `To` AS `to`, ispresent, Number_of_Hour AS `hours`, Position AS `position`, Emp_ID AS id FROM voluntary_work WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $id)
{
    nonQuery("INSERT INTO voluntary_work (Name_of_Organization, `From`, `To`, ispresent, Number_of_Hour, Position, Emp_ID) VALUES ('{$organization}', '{$from}', '{$to}', '{$isPresent}', '{$hours}', '{$position}', '{$id}');");
}

function updateVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $id, $no)
{
    nonQuery("UPDATE voluntary_work SET Name_of_Organization='{$organization}', `From`='{$from}', `To`='{$to}', ispresent='{$isPresent}', Number_of_Hour='{$hours}', Position='{$position}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteVoluntaryWork($id, $no)
{
    nonQuery("DELETE FROM voluntary_work WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteVoluntaryWorks($id)
{
    nonQuery("DELETE FROM voluntary_work WHERE Emp_ID='{$id}';");
}
