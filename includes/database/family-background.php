<?php
// includes/database/family-background.php
// tbl_family_background
// family_background
function family($id)
{
    return query("SELECT Emp_ID AS id, SpouseLast AS slast, SpouseFirst AS sfirst, SpouseMiddle AS smiddle, SpouseExtension AS sext, SpouseOccupation AS swork, SpouseBusiness AS soffice, SpouseBusinessAddress AS soffice_address, SpouseTelephone AS stelephone, FatherLast AS flast, FatherFirst AS ffirst, FatherExtension AS fext, FatherMiddle AS fmiddle, MotherLast AS mlast, MotherFirst AS mfirst, MotherMiddle AS mmiddle FROM tbl_family_background WHERE Emp_id='{$id}' LIMIT 1;");
}

function createFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $id)
{
    nonQuery("INSERT INTO tbl_family_background (Emp_ID, SpouseLast, SpouseFirst, SpouseMiddle, SpouseExtension, SpouseOccupation, SpouseBusiness, SpouseBusinessAddress, SpouseTelephone, FatherLast, FatherFirst, FatherExtension, FatherMiddle, MotherLast, MotherFirst, MotherMiddle) VALUES ('{$id}', '{$slast}', '{$sfirst}', '{$smiddle}', '{$sext}', '{$swork}', '{$sbusiness}', '{$sbusinessAddress}', '{$stelephone}', '{$flast}', '{$ffirst}', '{$fext}', '{$fmiddle}', '{$mlast}', '{$mfirst}', '{$mmiddle}');");
}

function updateFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $id)
{
    nonQuery("UPDATE tbl_family_background SET SpouseLast='{$slast}', SpouseFirst='{$sfirst}', SpouseExtension='{$sext}', SpouseMiddle='{$smiddle}', SpouseOccupation='{$swork}', SpouseBusiness='{$sbusiness}', SpouseBusinessAddress='{$sbusinessAddress}', SpouseTelephone='{$stelephone}', FatherLast='{$flast}', FatherFirst='{$ffirst}', FatherExtension='{$fext}', FatherMiddle='{$fmiddle}', MotherLast='{$mlast}', MotherFirst='{$mfirst}', MotherMiddle='{$mmiddle}' WHERE Emp_ID='{$id}' LIMIT 1;");
}

function deleteFamily($id)
{
    nonQuery("DELETE FROM tbl_family_background WHERE Emp_ID='{$id}';");
}

function children($id)
{
    return query("SELECT `No` AS `no`, Family_Name AS `last`, First_Name AS `first`, Name_Extension AS ext, Middle_Name AS middle, Birthdate AS dob, Emp_ID AS id FROM family_background WHERE Emp_ID='{$id}' ORDER BY Birthdate ASC;");
}

function child($id, $no)
{
    return query("SELECT `No` AS `no`, Family_Name AS `last`, First_Name AS `first`, Name_Extension AS ext, Middle_Name AS middle, Birthdate AS dob, Emp_ID AS id FROM family_background WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createChild($lname, $fname, $ext, $mname, $dob, $id)
{
    nonQuery("INSERT INTO family_background (Family_Name, First_Name, Name_Extension, Middle_Name, Birthdate, Emp_ID) VALUES ('{$lname}', '{$fname}', '{$ext}', '{$mname}', '{$dob}', '{$id}');");
}

function updateChild($lname, $fname, $ext, $mname, $dob, $id, $no)
{
    nonQuery("UPDATE family_background SET Family_Name='{$lname}', First_Name='{$fname}', Name_Extension='{$ext}', Middle_Name='{$mname}', Birthdate='{$dob}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteChild($id, $no)
{
    nonQuery("DELETE FROM family_background WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteChildren($id)
{
    nonQuery("DELETE FROM family_background WHERE Emp_ID='{$id}';");
}
