<?php
// includes/database/references.php
// reference
function references($id)
{
    return query("SELECT `No` AS `no`, `Name` AS `name`, `Address` AS `address`, Tel_No AS `telephone`, `Emp_ID` AS `id` FROM reference WHERE Emp_ID='{$id}' ORDER BY `Name`;");
}

function reference($id, $no)
{
    return query("SELECT `No` AS `no`, `Name` AS `name`, `Address` AS `address`, Tel_No AS `telephone`, `Emp_ID` AS `id` FROM reference WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createReference($name, $address, $telephone, $id)
{
    nonQuery("INSERT INTO reference (`Name`, `Address`, Tel_No, Emp_ID) VALUES ('{$name}', '{$address}', '{$telephone}', '{$id}');");
}

function updateReference($name, $address, $telephone, $id, $no)
{
    nonQuery("UPDATE reference SET `Name`='{$name}', `Address`='{$address}', Tel_No='{$telephone}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteReference($id, $no)
{
    nonQuery("DELETE FROM reference WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteReferences($id)
{
    nonQuery("DELETE FROM reference WHERE Emp_ID='{$id}';");
}
