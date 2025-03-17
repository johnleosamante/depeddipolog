<?php
// validate/index.php
require_once('../includes/function.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/utility.php');

function alterCivilService()
{
    echo 'Altering Civil Service...<br>';
    nonQuery("ALTER TABLE `civil_service` ADD `isapplicabledate` BOOLEAN NOT NULL AFTER `Number_of_Hour`;");
    echo 'Completed...<br><br>';
}

function alterEducationalBackground()
{
    echo 'Altering Educational Background...<br>';
    nonQuery("ALTER TABLE `educational_background` ADD `ispresent` BOOLEAN NOT NULL AFTER `To`;");
    echo 'Completed...<br><br>';
}

function alterSystemLogs()
{
    echo 'Altering System Logs...<br>';
    nonQuery("ALTER TABLE `tbl_system_logs` ADD `target_id` VARCHAR(30) NOT NULL AFTER `Status`;");
    echo 'Completed...<br><br>';
}

function alterVoluntaryWork()
{
    echo 'Altering Voluntary Work...<br>';
    nonQuery("ALTER TABLE `voluntary_work` ADD `ispresent` BOOLEAN NOT NULL AFTER `To`;");
    echo 'Completed...<br><br>';
}

function alterWorkExperience()
{
    echo 'Altering Work Experience...<br>';
    nonQuery("ALTER TABLE `work_experience` ADD `ispresent` BOOLEAN NOT NULL AFTER `To`;");
    echo 'Completed...<br><br>';
}

function checkEmployeeStation()
{
    echo 'Checking employee station...<br>';

    $activeEmployees = query("SELECT * FROM tbl_employee;");
    $no = 0;

    while ($active = fetchAssoc($activeEmployees)) {
        if (numRows(query("SELECT * FROM tbl_station WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
            echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeAccount()
{
    echo 'Checking employee account...<br>';

    $activeEmployees = query("SELECT * FROM tbl_employee;");
    $no = 0;

    while ($active = fetchAssoc($activeEmployees)) {
        if (numRows(query("SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='" . $active['Emp_Email'] . "';")) === 0) {
            query("INSERT INTO tbl_teacher_account (`Teacher_TIN`, `Teacher_Password`) VALUES ('" . $active['Emp_Email'] . "', '" . hashPassword(generateStrongRandomPassword()) . "');");

            if (affectedRows()) {
                echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
            }
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeStepIncrement()
{
    echo 'Checking employee step increment...<br>';

    $activeEmployees = query("SELECT * FROM tbl_employee;");
    $no = 0;

    while ($active = fetchAssoc($activeEmployees)) {
        if (numRows(query("SELECT * FROM tbl_step_increment WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
            query("INSERT INTO tbl_step_increment (`Date_last_step`, `Step_No`, `No_of_year`, `Emp_ID`) VALUES ('1', '1', '0', '" . $active['Emp_ID'] . "');");

            if (affectedRows()) {
                echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
            }
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeOtherInformation()
{
    echo 'Checking employee other information...<br>';

    $activeEmployees = query("SELECT * FROM tbl_employee;");
    $no = 0;

    while ($active = fetchAssoc($activeEmployees)) {
        if (numRows(query("SELECT * FROM tbl_other_information WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
            query("INSERT INTO tbl_other_information (`Emp_ID`) VALUES ('" . $active['Emp_ID'] . "');");

            if (affectedRows() === 1) {
                echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
            }
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeePsipop()
{
    echo 'Checking employee psipop...<br>';

    $activeEmployees = query("SELECT * FROM tbl_employee;");
    $no = 0;

    while ($active = fetchAssoc($activeEmployees)) {
        if (numRows(query("SELECT * FROM psipop WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
            query("INSERT INTO psipop (`Step`, `Job_status`, `Emp_ID`) VALUES ('1', 'Permanent', '" . $active['Emp_ID'] . "');");

            if (affectedRows() === 1) {
                echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
            }
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeDeployment()
{
    echo 'Checking employee deployment...<br>';

    $activeEmployees = query("SELECT tbl_employee.Emp_ID, tbl_employee.Emp_LName, tbl_employee.Emp_FName, tbl_employee.Emp_MName, tbl_employee.Emp_Extension, tbl_station.Emp_Station, tbl_station.Emp_Position FROM `tbl_employee` INNER JOIN `tbl_station` ON tbl_employee.Emp_ID = tbl_station.Emp_ID;");
    $no = 0;

    while ($active = fetchAssoc($activeEmployees)) {
        if (numRows(query("SELECT * FROM tbl_deployment_history WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
            query("INSERT INTO tbl_deployment_history (`station_assign`, `position_assign`, `No_of_years`, `StepNo`, `Emp_ID`) VALUES ('" . $active['Emp_Station'] . "', '" . $active['Emp_Position'] . "', '0', '1', '" . $active['Emp_ID'] . "');");

            if (affectedRows() === 1) {
                echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
            }
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeFamily()
{
    echo 'Checking employee family...<br>';

    $activeEmployees = query("SELECT * FROM `tbl_employee`;");
    $no = 0;

    while ($active = fetchAssoc($activeEmployees)) {
        if (numRows(query("SELECT * FROM tbl_family_background WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
            query("INSERT INTO tbl_family_background (`Emp_ID`) VALUES ('" . $active['Emp_ID'] . "');");

            if (affectedRows() === 1) {
                echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
            }
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function checkEmployeeValidId()
{
    echo 'Checking employee valid id...<br>';

    $activeEmployees = query("SELECT * FROM `tbl_employee`;");
    $no = 0;

    while ($active = fetchAssoc($activeEmployees)) {
        if (numRows(query("SELECT * FROM tbl_valid_id WHERE Emp_ID='" . $active['Emp_ID'] . "';")) === 0) {
            query("INSERT INTO tbl_valid_id (`Government`, `ID_Number`, `Place_issued`, `Date_issued`, `Emp_ID`) VALUES ('', '', '', NOW(), '" . $active['Emp_ID'] . "');");

            if (affectedRows() === 1) {
                echo ++$no . ' | ' . $active['Emp_ID'] . ' | ' . toName($active['Emp_LName'], $active['Emp_FName'], $active['Emp_MName'], $active['Emp_Extension']) . '<br>';
            }
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function checkTeacherPassword()
{
    echo 'Setting teacher password...<br>';

    $users = query("SELECT `username`, `password` FROM tbl_user WHERE `password` <> '';");
    $no = 0;

    while ($u = fetchAssoc($users)) {
        nonQuery("UPDATE tbl_teacher_account SET `Teacher_Password`='" . $u['password'] . "' WHERE `Teacher_TIN`='" . $u['username'] . "';");

        if (affectedRows() === 1) {
            echo ++$no . ' | ' . $u['username'] . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function setTransactionStatus()
{
    echo 'Setting transaction status...<br>';

    $no = 0;

    nonQuery("UPDATE tbl_transactions SET `Status`='Unread' WHERE Trans_Stats NOT LIKE '%Complete%' OR Trans_Stats NOT LIKE '%Cancel%';");

    $no = affectedRows();

    nonQuery("UPDATE tbl_transactions SET `Status`='Read' WHERE Trans_Stats LIKE '%Complete%' OR Trans_Stats LIKE '%Cancel%';");

    $no = $no + affectedRows();

    echo '(' . $no . ') Completed...<br><br>';
}

function setTransactionLogStatus()
{
    echo 'Setting transaction log status...<br>';
    nonQuery("UPDATE tbl_transactions_Log SET `Status`='Done';");
    echo '(' . affectedRows() . ') Completed...<br><br>';
}

function setLastTransactionLogStatus()
{
    echo 'Setting last transaction log status...<br>';

    $transactions = query("SELECT * FROM tbl_transactions WHERE Trans_Stats NOT LIKE '%Complete%' OR Trans_Stats NOT LIKE '%Cancel%';");
    $no = 0;

    while ($t = fetchAssoc($transactions)) {
        $logs = query("SELECT * FROM tbl_transactions_log WHERE Transaction_code='" . $t['TransCode'] . "' ORDER BY Date_recieved DESC LIMIT 1;");
        $l = fetchAssoc($logs);

        nonQuery("UPDATE tbl_transactions_log SET `Status`='New' WHERE `No`='" . $l['No'] . "' AND Trans_status NOT LIKE '%Complete%' AND Trans_status NOT LIKE '%Cancel%';");

        if (affectedRows() === 1) {
            echo ++$no . ' | ' . $t['TransCode'] . ' | ' . $t['Title'] . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function setActivityStatus($value, $reference)
{
    echo 'Setting activity status (' . $value . ')...<br>';
    nonQuery("UPDATE tbl_system_logs SET `Status`='{$value}' WHERE `Status`='{$reference}';");
    echo '(' . affectedRows() . ') Completed...<br><br>';
}

function setLoginTargetId()
{
    echo 'Setting login target id...<br>';

    $logs = query("SELECT `Emp_ID` AS `id` FROM tbl_system_logs WHERE `Status`='Logged in';");
    $no = 0;

    while ($log = fetchAssoc($logs)) {
        nonQuery("UPDATE tbl_system_logs SET `target_id`='" . $log['id'] . "' WHERE `Status`='Logged in' AND Emp_ID='" . $log['id'] . "';");

        if (affectedRows()) {
            ++$no;
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function setCreatedDocumentTargetId()
{
    echo 'Setting created document target id...<br>';

    $logs = query("SELECT TransCode AS `id`, Date_time AS `datetime` FROM tbl_transactions;");
    $no = 0;

    while ($log = fetchAssoc($logs)) {
        nonQuery("UPDATE tbl_system_logs SET `target_id`='" . $log['id'] . "' WHERE `Status`='Created document' AND Time_Log='" . $log['datetime'] . "';");

        if (affectedRows()) {
            echo ++$no . ' | ' . $log['id'] . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function updateEducationalBackgroundLevel($value, $reference)
{
    echo 'Updating educational background level (' . $value . ')...<br>';
    nonQuery("UPDATE `educational_background` SET `Level`='{$value}' WHERE `Level`='{$reference}';");
    echo '(' . affectedRows() . ') Completed...<br><br>';
}

function addUserPrivilege($id, $email, $station)
{
    echo 'Adding user privilege (' . $email . ')...<br>';
    nonQuery("INSERT INTO tbl_user (`usercode`, `username`, `Station`) VALUES ('{$id}', '{$email}', '{$station}');");
    echo '(' . affectedRows() . ') Completed...<br><br>';
}

function setHeadToTransaction($stationId, $headId, $startDate = null, $endDate = null)
{
    echo "Setting station [$stationId] and station head [" . userName($headId) . "]...<br>";

    $filter = !empty($startDate) && !empty($endDate) ? "AND Date_time BETWEEN '{$startDate}' AND '{$endDate}'" : '';

    nonQuery("UPDATE tbl_transactions SET `SchoolID`='{$headId}' WHERE TransCode LIKE '" . $stationId . "%' {$filter} ORDER BY Date_time ASC;");
    echo affectedRows() . ' affected rows...<br>';
}

function setEmailToUserId()
{
    echo "Setting email to employeeid...<br>";

    $employees = query("SELECT Emp_ID AS `id`, Emp_Email AS `email` FROM tbl_employee;");
    $no = 0;

    while ($employee = fetchAssoc($employees)) {
        nonQuery("UPDATE tbl_teacher_account SET `Teacher_TIN`='" . $employee['id'] . "' WHERE `Teacher_TIN`='" . $employee['email'] . "';");
        if (affectedRows()) {
            echo ++$no . ' | ' . $employee['id'] . ' | ' . $employee['email'] . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function setDateLastStepDefault()
{
    echo 'Setting latest step date to default...<br>';

    $employees = query("SELECT Emp_ID AS `id` FROM tbl_employee;");
    $no = 0;

    while ($employee = fetchAssoc($employees)) {
        nonQuery("UPDATE tbl_step_increment SET `Date_last_step`='" . date('Y-m-d') . "' WHERE `Date_last_step` > NOW() AND `Emp_ID`='" . $employee['id'] . "';");
        if (affectedRows()) {
            echo ++$no . ' | ' . $employee['id'] . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function setStepIncrementSalaryGrade()
{
    echo 'Setting step increment salary grade...<br>';

    $employees = query("SELECT `tbl_station`.`Emp_ID`, `tbl_job`.`Salary_Grade` FROM `tbl_station` INNER JOIN `tbl_job` ON `tbl_station`.`Emp_Position`=`tbl_job`.`Job_code`;");
    $no = 0;

    while ($employee = fetchAssoc($employees)) {
        nonQuery("UPDATE `tbl_step_increment` SET `No_of_year`='" . $employee['Salary_Grade'] . "' WHERE `Emp_ID`='" . $employee['Emp_ID'] . "';");

        if (affectedRows()) {
            echo ++$no . ' | ' . $employee['Emp_ID'] . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function setLoyaltyAwardDOAFromStation()
{
    echo 'Setting loyalty award date of original appointment from station...<br>';

    $employees = query("SELECT `Emp_ID` AS `id`, `Emp_DOA` AS `doa` FROM `tbl_station`;");
    $no = 0;

    while ($employee = fetchAssoc($employees)) {
        if (numRows(query("SELECT `employee_id` AS `id` FROM `tbl_loyalty_award` WHERE `employee_id`='" . $employee['id'] . "';")) > 0) {
            nonQuery("UPDATE `tbl_loyalty_award` SET `last_awarded_on`='" . $employee['doa'] .  "' WHERE `employee_id`='" . $employee['id'] . "';");
        } else {
            nonQuery("INSERT INTO `tbl_loyalty_award` (`employee_id`, `last_awarded_on`) VALUES ('" . $employee['id'] . "', '" . $employee['doa'] . "');");
        }

        if (affectedRows()) {
            echo ++$no . ' | ' . $employee['id'] . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

function setLastStepIncrementFromStation()
{
    echo 'Setting last step increment from station...<br>';

    $employees = query("SELECT `Emp_ID` AS `id`, `Emp_DOA` AS `doa` FROM `tbl_station`;");
    $no = 0;

    while ($employee = fetchAssoc($employees)) {
        if (numRows(query("SELECT `Emp_ID` AS `id` FROM `tbl_step_increment` WHERE `Emp_ID`='" . $employee['id'] . "';")) > 0) {
            nonQuery("UPDATE `tbl_step_increment` SET `Date_last_step`='" . $employee['doa'] .  "' WHERE `Emp_ID`='" . $employee['id'] . "';");
        } else {
            nonQuery("INSERT INTO `tbl_step_increment` (`Emp_ID`, `Date_last_step`) VALUES ('" . $employee['id'] . "', '" . $employee['doa'] . "');");
        }

        if (affectedRows()) {
            echo ++$no . ' | ' . $employee['id'] . '<br>';
        }
    }

    echo '(' . $no . ') Completed...<br><br>';
}

// setLastStepIncrementFromStation();

// $name = 'DepEd Dipolog ICT Unit';
// $sender = 'depeddipolog.ict@deped.gov.ph';
// $to = 'johnleomuitsamante@gmail.com';
// $subject = 'Test Message';
// $message = 'This is a test email from john leo samante.';
// $headers = "From: {$name} <{$sender}>" . PHP_EOL .
//     "Reply-To: {$name} <{$sender}>" . PHP_EOL .
//     'X-Mailer: PHP/' . phpversion();

// echo mail($to, $subject, $message, $headers)
//   ? "Mail send OK"
//   : "Mail send ERROR" ;
