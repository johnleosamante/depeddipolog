<?php
// includes/database/document.php
// tbl_transactions
// tbl_transactions_log
// tbl_document_purpose
function documentPurpose()
{
    return query("SELECT `purpose` FROM tbl_document_purpose;");
}

function documentTypes($for_school = false)
{
    $filter = $for_school ? "`for_school`='1' AND" : '';
    return query("SELECT `id`, `name` FROM `document_types` WHERE {$filter} `id` NOT LIKE '1' ORDER BY `name`;");
}

function documentType($id)
{
    return query("SELECT `name` FROM `document_types` WHERE `id`='{$id}';");
}

function document($id)
{
    return query("SELECT TransCode AS id, Title AS `description`, `type`, `type`, Date_time AS `datetime`, Trans_from AS `from`, Trans_Stats AS `status`, details FROM tbl_transactions WHERE TransCode='{$id}' LIMIT 1;");
}

function isDocument($id, $status)
{
    return numRows(query("SELECT TransCode AS id FROM tbl_transactions WHERE TransCode='{$id}' AND Trans_Stats LIKE '%{$status}%';")) > 0;
}

function countDocumentsFrom($station, $year, $code)
{
    return numRows(query("SELECT TransCode AS id FROM tbl_transactions WHERE Trans_from='{$station}' AND TransCode LIKE '%{$code}-{$year}-%';"));
}

function documentFrom($id, $station)
{
    return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, `type`, tbl_transactions.Date_time AS `datetime`, tbl_transactions.Trans_from AS `from`, tbl_transactions.Trans_Stats AS `status`, tbl_transactions.details FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE (tbl_transactions_log.From_office='{$station}' OR tbl_transactions_log.Forwarded_to='{$station}') AND tbl_transactions_log.Transaction_code='{$id}';");
}

function documentOrigin($id)
{
    return query("SELECT tbl_transactions.TransCode AS `id`, tbl_transactions.Title AS `description`, `type`, tbl_transactions.Trans_Stats AS `status`, tbl_transactions.Date_time AS `datetime`, tbl_transactions.SchoolID AS `head`, tbl_transactions_log.Recieved_by AS `user`, tbl_transactions_log.From_office AS `from` FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' ORDER BY tbl_transactions_log.Date_recieved ASC LIMIT 1;");
}

function isDocumentFrom($id, $station, $status = 'New')
{
    return numRows(query("SELECT Transaction_code AS id FROM tbl_transactions_log WHERE From_office='{$station}' AND `Status`='{$status}' AND Transaction_code='{$id}';"));
}

function createDocument($id, $description, $type, $station, $purpose, $headId, $details = '')
{
    nonQuery("INSERT INTO tbl_transactions (TransCode, Title, `type`, Date_time, Trans_from, Trans_Stats, `Status`, `SchoolID`, details) VALUES ('{$id}', '{$description}', '{$type}', NOW(), '{$station}', '{$purpose}', 'Unread', '{$headId}', '{$details}');");
}

function updateDocument($id, $description, $type, $purpose, $details = '', $updateDescription = true)
{
    $description_column = $updateDescription ? " Title='{$description}', `type`='{$type}', " : ' ';
    nonQuery("UPDATE tbl_transactions SET $description_column Trans_Stats='{$purpose}', details='{$details}' WHERE TransCode='{$id}' LIMIT 1;");
}

function incomingDocuments($station)
{
    return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.From_office AS `from`, tbl_transactions_log.Date_recieved AS `datetime`, tbl_transactions.Trans_Stats AS purpose, tbl_transactions.Trans_from AS station FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions_log.Forwarded_to='{$station}' AND tbl_transactions_log.Status='New' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function isIncomingDocument($id, $station)
{
    return numRows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions_log.Forwarded_to='{$station}' AND  tbl_transactions_log.Status='New' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function pendingDocuments($station)
{
    return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.Recieved_by AS user, tbl_transactions_log.Date_recieved AS `datetime`, tbl_transactions.Trans_from AS station FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to='-' AND tbl_transactions_log.Status='New' AND tbl_transactions.Trans_Stats NOT LIKE '%Complete%' AND tbl_transactions.Trans_Stats NOT LIKE '%Cancel%' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function isPendingDocument($id, $station)
{
    return numRows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to='-' AND tbl_transactions_log.Status='New' AND tbl_transactions.Trans_Stats NOT LIKE '%Complete%' AND tbl_transactions.Trans_Stats NOT LIKE '%Cancel%' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function outgoingDocuments($station)
{
    return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.Forwarded_to AS `to`, tbl_transactions_log.Recieved_by AS user, tbl_transactions_log.Date_recieved AS `datetime`, tbl_transactions.Trans_from AS station FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_Stats NOT LIKE '%Complete%' AND tbl_transactions.Trans_Stats NOT LIKE '%Cancel%' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to <> '' AND tbl_transactions_log.Forwarded_to <> '-' AND tbl_transactions_log.Status='New' ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function isOutgoingDocument($id, $station)
{
    return numRows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.Trans_Stats NOT LIKE '%Complete%' AND tbl_transactions.Trans_Stats NOT LIKE '%Cancel%' AND tbl_transactions.TransCode='{$id}' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to <> '' AND tbl_transactions_log.Forwarded_to <> '-' AND tbl_transactions_log.Status='New' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function ongoingDocuments($station)
{
    return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, tbl_transactions_log.Forwarded_to AS `to`, tbl_transactions.Date_time AS `datetime`, tbl_transactions.Trans_Stats AS `status`, tbl_transactions.Trans_from AS station FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats NOT LIKE '%Complete%' AND tbl_transactions_log.Trans_status NOT LIKE '%Complete%' AND tbl_transactions.Trans_Stats NOT LIKE '%Cancel%' AND tbl_transactions_log.Trans_status NOT LIKE '%Cancel%' GROUP BY tbl_transactions.TransCode ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function isOngoingDocument($id, $station)
{
    return numRows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats NOT LIKE '%Complete%' AND tbl_transactions_log.Trans_status NOT LIKE '%Complete%' AND tbl_transactions.Trans_Stats NOT LIKE '%Cancel%' AND tbl_transactions_log.Trans_status NOT LIKE '%Cancel%' GROUP BY tbl_transactions.TransCode ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function completedDocuments($station, $from, $to)
{
    return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, `type`, tbl_transactions.Date_time AS `postedon`, tbl_transactions_log.Date_recieved AS completedon, tbl_transactions.Trans_from AS station FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats LIKE '%Complete%' AND tbl_transactions_log.Trans_status LIKE '%Complete%' AND Date_recieved BETWEEN '{$from}' AND DATE(DATE_ADD('{$to}', INTERVAL 1 DAY)) ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function isCompletedDocument($id, $station)
{
    return numRows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats LIKE '%Complete%' AND tbl_transactions_log.Trans_status LIKE '%Complete%' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function wasDocumentCompleted($id, $station)
{
    return numRows(query("SELECT Transaction_code AS id FROM tbl_transactions_log WHERE Transaction_code='{$id}' AND From_office='{}' Trans_status='Completed'")) > 0;
}

function receivedDocuments($station, $from, $to)
{
    return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, `type`, tbl_transactions_log.Date_recieved AS `datetime`, tbl_transactions_log.Recieved_by AS `receiver`, tbl_transactions.Trans_from AS station FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_from <> '{$station}' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to='-' AND (tbl_transactions_log.Trans_status LIKE '%Received%' OR tbl_transactions_log.Trans_status LIKE '%On Process%') AND tbl_transactions_log.Status='Done' AND Date_recieved BETWEEN '{$from}' AND DATE(DATE_ADD('{$to}', INTERVAL 1 DAY)) ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function isReceivedDocument($id, $station)
{
    return numRows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions.Trans_from <> '{$station}' AND tbl_transactions_log.From_office='{$station}' AND tbl_transactions_log.Forwarded_to='-' AND (tbl_transactions_log.Trans_status LIKE '%Received%' OR tbl_transactions_log.Trans_status LIKE '%On Process%') AND tbl_transactions_log.Status='Done' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function canceledDocuments($station, $from, $to)
{
    return query("SELECT tbl_transactions.TransCode AS id, tbl_transactions.Title AS `description`, `type`, tbl_transactions.Date_time AS `postedon`, tbl_transactions_log.Date_recieved AS `canceledon`, tbl_transactions.Trans_from AS station FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats LIKE '%Cancel%' AND tbl_transactions_log.Trans_status LIKE '%Cancel%' AND Date_recieved BETWEEN '{$from}' AND DATE(DATE_ADD('{$to}', INTERVAL 1 DAY)) ORDER BY tbl_transactions_log.Date_recieved DESC;");
}

function isCanceledDocument($id, $station)
{
    return numRows(query("SELECT tbl_transactions.TransCode AS id FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code = tbl_transactions.TransCode WHERE tbl_transactions.TransCode='{$id}' AND tbl_transactions.Trans_from='{$station}' AND tbl_transactions.Trans_Stats LIKE '%Cancel%' AND tbl_transactions_log.Trans_status LIKE '%Cancel%' ORDER BY tbl_transactions_log.Date_recieved DESC LIMIT 1;")) > 0;
}

function documentLog($id)
{
    return query("SELECT `tbl_transactions`.`TransCode` AS `id`, `tbl_transactions`.`Title` AS `description`, `type`, `tbl_transactions`.`Trans_from` AS `from`, `tbl_transactions_log`.`Date_recieved` AS `datetime`, `tbl_transactions_log`.`Forwarded_To` AS `destination`, `tbl_transactions_log`.`Trans_status` AS `purpose`, tbl_transactions_log.details FROM `tbl_transactions` INNER JOIN `tbl_transactions_log` ON `tbl_transactions`.`TransCode` = `tbl_transactions_log`.`Transaction_code` WHERE `tbl_transactions`.`TransCode`='{$id}' ORDER BY `datetime` DESC LIMIT 1;");
}

function documentLogs($id)
{
    return query("SELECT Date_recieved AS `datetime`, Recieved_by AS `user`, From_office AS `from`, Forwarded_to AS `to`, Trans_status AS `status`, `details`, `attachment` FROM tbl_transactions_log WHERE Transaction_code='{$id}' ORDER BY Date_recieved DESC;");
}

function createDocumentLog($id, $user, $station, $destination, $purpose, $status = 'New', $details = '', $attachment = '')
{
    nonQuery("INSERT INTO tbl_transactions_log VALUES (null, NOW(), '{$user}', '{$station}', '{$destination}', '{$purpose}', '{$id}', '{$status}', '{$details}', '{$attachment}');");
}

function updateDocumentLog($id, $user, $station, $destination, $purpose, $status = 'New', $details = '', $attachment = '', $change_date = true)
{
    $date = $change_date ? "Date_Recieved=NOW(), " : '';
    nonQuery("UPDATE tbl_transactions_log SET " . $date . " Recieved_by='{$user}', From_office='{$station}', Forwarded_to='{$destination}', Trans_status='{$purpose}', `Status`='{$status}', `details`='{$details}', `attachment`='{$attachment}' WHERE Transaction_code='{$id}' ORDER BY Date_Recieved DESC LIMIT 1;");
}

function updateDocumentLogsDone($id)
{
    nonQuery("UPDATE tbl_transactions_log SET `Status`='Done' WHERE Transaction_code='{$id}';");
}

function updateDocumentStatus($id, $purpose, $status = 'Unread', $details = '')
{
    nonQuery("UPDATE tbl_transactions SET Trans_Stats='{$purpose}', `Status`='{$status}', details='{$details}' WHERE TransCode='{$id}' LIMIT 1;");
}

function updateTransactionLogFrom($newAlias, $oldAlias)
{
    nonQuery("UPDATE tbl_transactions_log SET `From_office`='{$newAlias}' WHERE `From_office`='{$oldAlias}';");
}

function updateTransactionLogTo($newAlias, $oldAlias)
{
    nonQuery("UPDATE tbl_transactions_log SET `Forwarded_To`='{$newAlias}' WHERE `Forwarded_To`='{$oldAlias}';");
}

function updateTransactionFrom($newAlias, $oldAlias)
{
    nonQuery("UPDATE tbl_transactions SET `Trans_from`='{$newAlias}' WHERE `Trans_from`='{$oldAlias}';");
}

function documentByStatus($status, $id, $station, $from = '', $to = '')
{
    return query("SELECT * FROM `tbl_system_logs` WHERE `Status`='{$status}' AND `target_id` LIKE '{$station}%' AND Emp_ID='{$id}' AND Time_log BETWEEN '{$from}' AND DATE(DATE_ADD('{$to}', INTERVAL 1 DAY));");
}

function documentSearch($string, $station)
{
    return query("SELECT `TransCode` AS `id`, `Title` AS `description`, `Date_time` AS `datetime`, `Trans_from` AS `from`, `Trans_Stats` AS `status` FROM `tbl_transactions` INNER JOIN `tbl_transactions_log` ON `tbl_transactions`.`TransCode`=`tbl_transactions_log`.`Transaction_code` WHERE (`tbl_transactions`.`TransCode` LIKE '%{$string}%' OR `tbl_transactions`.`Title` LIKE '%{$string}%' OR `tbl_transactions_log`.`details` LIKE '%{$string}%') AND (`tbl_transactions_log`.`From_office`='{$station}' OR `tbl_transactions_log`.`Forwarded_to`=
    '{$station}') GROUP BY `tbl_transactions`.`TransCode`;");
}
