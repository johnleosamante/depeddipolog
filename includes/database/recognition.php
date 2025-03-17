<?php
// includes/database/recognition.php
// tbl_recognition
function recognitions($id)
{
    return query("SELECT `No` AS `no`, Recognition AS `recognition`, Emp_ID AS id FROM tbl_recognition WHERE Emp_ID='{$id}' ORDER BY Recognition;");
}

function recognition($id, $no)
{
    return query("SELECT `No` AS `no`, Recognition AS `recognition`, Emp_ID AS id FROM tbl_recognition WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createRecognition($recognition, $id)
{
    nonQuery("INSERT INTO tbl_recognition (`Recognition`, Emp_ID) VALUES ('{$recognition}', '{$id}');");
}

function updateRecognition($recognition, $id, $no)
{
    nonQuery("UPDATE tbl_recognition SET Recognition='{$recognition}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteRecognition($id, $no)
{
    nonQuery("DELETE FROM tbl_recognition WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteRecognitions($id)
{
    nonQuery("DELETE FROM tbl_recognition WHERE Emp_ID='{$id}';");
}
