<?php
// includes/database/membership.php
// tbl_membership
function memberships($id)
{
    return query("SELECT `No` AS `no`, Organization AS `organization`, Emp_ID AS id FROM tbl_membership WHERE Emp_ID='{$id}' ORDER BY Organization;");
}

function membership($id, $no)
{
    return query("SELECT `No` AS `no`, Organization AS `organization`, Emp_ID AS id FROM tbl_membership WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createMembership($membership, $id)
{
    nonQuery("INSERT INTO tbl_membership (`Organization`, `Emp_ID`) VALUES ('{$membership}', '{$id}');");
}

function updateMembership($membership, $id, $no)
{
    nonQuery("UPDATE tbl_membership SET Organization='{$membership}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteMembership($id, $no)
{
    nonQuery("DELETE FROM tbl_membership WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteMemberships($id)
{
    nonQuery("DELETE FROM tbl_membership WHERE Emp_ID='{$id}';");
}
