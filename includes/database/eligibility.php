<?php
// includes/database/eligibility.php
// civil_service
function eligibilities($id)
{
    return query("SELECT `No` AS `no`, Carrer_Service AS eligibility, Rating AS rating, Date_of_Examination AS `date`, Place_of_Examination AS `place`, Number_of_Hour AS `license`, isapplicabledate AS isapplicable, Date_of_Validity AS `validity`, Emp_ID AS `id` FROM civil_service WHERE Emp_ID='{$id}' ORDER BY Date_of_Examination ASC;");
}

function eligibility($id, $no)
{
    return query("SELECT `No` AS `no`, Carrer_Service AS eligibility, Rating AS rating, Date_of_Examination AS `date`, Place_of_Examination AS `place`, Number_of_Hour AS `license`, isapplicabledate AS isapplicable, Date_of_Validity AS `validity`, Emp_ID AS `id` FROM civil_service WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createEligibility($career, $rating, $examDate, $examPlace, $license, $is_applicable, $validity, $id)
{
    nonQuery("INSERT INTO civil_service (`Carrer_Service`, `Rating`, `Date_of_Examination`, `Place_of_Examination`, `Number_of_Hour`, `isapplicabledate`, `Date_of_Validity`, `Emp_ID`) VALUES ('{$career}', '{$rating}', '{$examDate}', '{$examPlace}', '{$license}', '{$is_applicable}', '{$validity}', '{$id}');");
}

function updateEligibility($career, $rating, $examDate, $examPlace, $license, $is_applicable, $validity, $id, $no)
{
    nonQuery("UPDATE civil_service SET `Carrer_Service`='{$career}', `Rating`='{$rating}', `Date_of_Examination`='{$examDate}', `Place_of_Examination`='{$examPlace}', `Number_of_Hour`='{$license}', `isapplicabledate`='{$is_applicable}', `Date_of_Validity`='{$validity}' WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteEligibility($id, $no)
{
    nonQuery("DELETE FROM civil_service WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteEligibilities($id)
{
    nonQuery("DELETE FROM civil_service WHERE Emp_ID='{$id}';");
}
