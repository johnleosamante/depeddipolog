<?php
// includes/database/card-type.php
// tbl_card_type
// tbl_valid_id
function cardTypes()
{
	return query("SELECT `id`, `card` AS `name` FROM tbl_card_type ORDER BY `card`;");
}

function cardType($id)
{
	return query("SELECT `card` AS `name` FROM tbl_card_type WHERE `id`='{$id}' LIMIT 1;");
}

function employeeIdentification($id)
{
	return query("SELECT `Government` AS `card`, `ID_Number` AS `number`, `Place_issued` AS `place`, `Date_issued` AS `date`, `Emp_ID` AS `id` FROM tbl_valid_id WHERE Emp_ID='{$id}';");
}

function createIdentification($card, $no, $place, $date, $id)
{
	nonQuery("INSERT INTO tbl_valid_id (`Government`, `ID_Number`, `Place_issued`, `Date_issued`, `Emp_ID`) VALUES ('{$card}', '{$no}', '{$place}', '{$date}', '{$id}');");
}

function updateIdentification($card, $no, $place, $date, $id)
{
	nonQuery("UPDATE tbl_valid_id SET `Government`='{$card}', `ID_Number`='{$no}', `Place_issued`='{$place}', `Date_issued`='{$date}' WHERE `Emp_ID`='{$id}';");
}
