<?php
// tbl_201_file
function fileAttachments($id)
{
    return query("SELECT `No` AS `no`, `DateUpload` AS `datetime`, `description`, `filename`, `ext` FROM tbl_201_file WHERE `Emp_ID`='{$id}' ORDER BY `datetime` DESC;");
}

function fileAttachment($id, $no)
{
    return query("SELECT `No` AS `no`, `DateUpload` AS `datetime`, `description`, `filename`, `ext` FROM tbl_201_file WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function createFileAttachment($description, $filename, $ext, $id)
{
    nonQuery("INSERT INTO tbl_201_file (`DateUpload`, `description`, `filename`, `ext`, `Emp_ID`) VALUES (NOW(), '{$description}', '{$filename}', '{$ext}', '{$id}');");
}

function updateFileAttachment($description, $filename, $ext, $id, $no)
{
    nonQuery("UPDATE tbl_201_file SET `DateUpload`=NOW(), `description`='{$description}', `filename`='{$filename}', `ext`='{$ext}' WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteFileAttachment($id, $no)
{
    nonQuery("DELETE FROM tbl_201_file WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function deleteFileAttachments($id)
{
    nonQuery("DELETE FROM tbl_201_file WHERE Emp_ID='{$id}';");
}
