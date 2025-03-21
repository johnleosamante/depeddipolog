<?php
// print/service-record.php
$logoSize = 19.5;
$margin = 8.89;
$width = 215.9;
$height = 330.2;
$lineY = 50;
$multiplePage = true;
$showQR = false;
$showStationInfo = true;
$isSchoolPortal = false;
$section = null;
$school = fetchArray(schoolDetailsById(divisionId()));
$stationLogo = root() . '/' . $school['logo'];
$address = $school['address'];
$telephone = $school['telephone'];
$email = $school['email'];
$website = $school['website'];
$fbPage = $school['fb_page'];
$footerSpace = 0;

require_once(root() . '/print/print-layout.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/experience.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/utility.php');

$employeeId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;

if (numRows(employee($employeeId)) === 0) {
    redirect(customUri($activeApp, 'Service Record'));
}

$employee = fetchAssoc(employee($employeeId));
$lname = $employee['lname'];
$fname = $employee['fname'];
$mname = $employee['mname'];
$ext = $employee['ext'];
$title = $url . ' | ' . toName($lname, $fname, $mname, $ext, true) . ' | ' . date('Y-m-d');
$bp = toHandleNull($employee['bp']);
$agencyId = toHandleNull($employee['agency_id']);
$bmonth = $employee['month'];
$bday = $employee['day'];
$byear = $employee['year'];
$bdate = date('F d, Y', strtotime("$byear-$bmonth-$bday"));
$bplace = $employee['pob'];
$signatory = fetchAssoc(section('PER'))['head'];
$position = fetchAssoc(position($signatory))['position'];
$pdf = new PDF('P', 'mm', array($width, $height));
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->SetMargins($margin, 11 + $logoSize, $margin);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B', 'calibrib.php');
$pdf->AddFont('calibrii', 'I', 'calibrii.php');
$pdf->AddFont('timesb', 'B', 'timesb.php');
$tableWidth = $width - ($margin * 2);
$lineHeight = 8;
$colOne = $tableWidth * 0.12;
$colTwo = $tableWidth * 0.37;
$colThree = $tableWidth * 0.2;
$colFour = $tableWidth * 0.12;
$colFive = $tableWidth * 0.12;
$colSix = $tableWidth * 0.07;
$minCounter = 15;
$maxCounter = 23;

$pdf->SetFont('timesb', 'B', 16);
$pdf->Cell(0, 0, 'STATEMENT OF SERVICE RECORD IN THE GOVERNMENT', 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibrii', 'I', 9);
$pdf->Cell(0, 0, '(To Be Accomplished By Employer)', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('calibrib', 'B', 10);
$pdf->Cell(35, 4, $bp, 0, 0, 'C');
$currentY = $pdf->GetY();
$pdf->Line($margin, $currentY + 4, $margin + 35, $currentY + 4);
$pdf->SetX($width - $margin - 35);
$pdf->Cell(35, 4, $agencyId, 0, 0, 'C');
$pdf->Line($width - $margin - 35, $currentY + 4, $width - $margin, $currentY + 4);
$pdf->SetFont('calibri', '', 10);
$pdf->Ln(4);
$pdf->Cell(35, 4, 'BP Number', 0, 0, 'C');
$pdf->SetX($width - $margin - 35);
$pdf->Cell(35, 4, 'Employee Number', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetX($margin + 3);
$pdf->Cell(15, 4, 'NAME:', 0, 0, 'L');
$pdf->SetFont('calibrib', 'B', 10);
$pdf->Cell(40, 4, strtoupper($lname), 0, 0, 'C');
$pdf->Cell(40, 4, strtoupper($fname), 0, 0, 'C');
$pdf->Cell(40, 4, strtoupper(toHandleNull($mname, 'N/A')), 0, 0, 'C');
$pdf->SetFont('calibri', '', 9);
$pdf->Cell(0, 4, '(If married women give also full maiden)', 0, 0, 'L');
$currentY = $pdf->GetY();
$pdf->Line($margin + 18, $currentY + 4, $margin + 138, $currentY + 4);
$pdf->Ln(4);
$pdf->SetX($margin + 18);
$pdf->Cell(40, 4, '(Surname)', 0, 0, 'C');
$pdf->Cell(40, 4, '(Given Name)', 0, 0, 'C');
$pdf->Cell(40, 4, '(Middle Name)', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetX($margin + 3);
$pdf->Cell(15, 4, 'BIRTH:', 0, 0, 'L');
$pdf->SetFont('calibrib', 'B', 10);
$pdf->Cell(35, 4, strtoupper($bdate), 0, 0, 'C');
$pdf->Cell(85, 4, strtoupper(toHandleNull($bplace, 'N/A')), 0, 0, 'C');
$currentY = $pdf->GetY();
$pdf->Line($margin + 18, $currentY + 4, $margin + 138, $currentY + 4);
$pdf->SetFont('calibri', '', 9);
$pdf->Cell(55, 4, '(Data herein should be checked from birth', 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetX($margin + 18);
$pdf->Cell(35, 4, 'DATE', 0, 0, 'C');
$pdf->Cell(85, 4, 'PLACE', 0, 0, 'C');
$pdf->Cell(55, 4, 'or baptismal certificate or some other)', 0, 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('calibri', '', 10);
$pdf->MultiCell($tableWidth, $lineHeight / 2, '            This is to certify that the above named employee actually rendered services in this Office as shown by the service record below, each line of which is supported by appointments and other papers actually issued and approved by the authorities concerned.');
$pdf->Ln($lineHeight / 2);

$pdf->SetFont('calibrib', 'B', 9);
$pdf->MultiCell($colOne, $lineHeight / 2, "SERVICE\n(Inclusive Dates)", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne);
$pdf->Cell($colTwo, $lineHeight, 'RECORDS OF APPOINTMENT', 1, 0, 'C');
$pdf->Cell($colThree, $lineHeight, 'OFFICE ENTITY / DIVISION', 1, 0, 'C');
$pdf->MultiCell($colFour, $lineHeight / 2, "LEAVE\nWITHOUT PAY", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne + $colTwo + $colThree + $colFour);
$pdf->Cell($colFive, $lineHeight, 'SEPARATION', 1, 0, 'C');
$pdf->SetX($margin + $colOne + $colTwo + $colThree + $colFour + $colFive);
$pdf->Cell($colSix, $lineHeight * 2, 'REMARKS', 1, 0, 'C');
$pdf->Ln($lineHeight);
$pdf->Cell($colOne / 2, $lineHeight, 'From', 1, 0, 'C');
$pdf->Cell($colOne / 2, $lineHeight, 'To', 1, 0, 'C');
$pdf->Cell($colTwo / 3, $lineHeight, 'Designation', 1, 0, 'C');
$pdf->MultiCell($colTwo / 3, $lineHeight / 2, "Employment\nStatus", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne + (($colTwo / 3) * 2));
$pdf->MultiCell($colTwo / 3, $lineHeight / 2, "Annual\nSalary", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne + $colTwo);
$pdf->MultiCell($colThree, $lineHeight / 2, "Station/Place/Branch of\n Assignment", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne + $colTwo + $colThree);
$pdf->Cell($colFour / 2, $lineHeight, 'From', 1, 0, 'C');
$pdf->Cell($colFour / 2, $lineHeight, 'To', 1, 0, 'C');
$pdf->Cell($colFive / 2, $lineHeight, 'Date', 1, 0, 'C');
$pdf->Cell($colFive / 2, $lineHeight, 'Cause', 1, 0, 'C');
$pdf->Ln($lineHeight);

$services = governmentService($employeeId);
$pdf->SetFont('calibri', '', 8);

if (numRows($services) > 0) {
    while ($service = fetchAssoc($services)) {
        $pdf->Cell($colOne / 2, $lineHeight - 2, toDate($service['from'], 'm/d/y'), 1, 0, 'C');
        $pdf->Cell($colOne / 2, $lineHeight - 2, $service['ispresent'] ? 'PRESENT' : toDate($service['to'], 'm/d/y'), 1, 0, 'C');
        $pdf->Cell($colTwo / 3, $lineHeight - 2, $service['position'], 1, 0, 'C');
        $pdf->Cell($colTwo / 3, $lineHeight - 2, strtoupper($service['status']), 1, 0, 'C');
        $pdf->Cell($colTwo / 3, $lineHeight - 2, toCurrency($service['salary'] * 12, ''), 1, 0, 'C');
        $pdf->Cell($colThree, $lineHeight - 2, $service['station'], 1, 0, 'C');
        $pdf->Cell($colFour, $lineHeight - 2, toHandleNull($service['leave_dates'], 'N/A'), 1, 0, 'C');
        $pdf->Cell($colFive / 2, $lineHeight - 2, $service['isseparation'] === '1' ? toDate($service['separation_date'], 'm/d/y') : 'N/A', 1, 0, 'C');
        $pdf->Cell($colFive / 2, $lineHeight - 2, $service['isseparation'] === '1' ? toHandleNull($service['separation_cause'], 'N/A') : 'N/A', 1, 0, 'C');
        $pdf->Cell($colSix, $lineHeight - 2, toHandleNull($service['sg']), 1, 0, 'C');
        $pdf->Ln($lineHeight - 2);
    }
} else {
    $pdf->SetFontSize(10);
    $pdf->Cell($tableWidth, $lineHeight * 2, '----- NO DATA AVAILABLE -----', 1, 0, 'C');
}

$pdf->Ln($lineHeight / 2);
$pdf->SetFont('calibri', '', 10);
$pdf->MultiCell($tableWidth, $lineHeight / 2, '            Issued in compliance with Executive Order No. 54 dated August 10, 1954 and in accordance with Circular No. 58 dated August 10, 1954 of the System.');
$pdf->Ln($lineHeight);
$pdf->Cell(0, 0, 'Verified and found correct:');
$pdf->Ln($lineHeight);
$pdf->SetFont('timesb', 'B', 10);
$pdf->Cell($tableWidth / 3 + 5, $lineHeight, userName($signatory, true), 0, 0, 'C');
$pdf->Line($margin, $pdf->GetY() + $lineHeight - 2, $margin + $tableWidth / 3 + 5, $pdf->GetY() + $lineHeight - 2);
$pdf->SetFont('calibri', '', 10);
$pdf->SetX($tableWidth / 3 * 2);
$pdf->Cell(40, $lineHeight, date('F j, Y'), 0, 0, 'C');
$pdf->Line(($tableWidth / 3) * 2, $pdf->GetY() + $lineHeight - 2, (($tableWidth / 3) * 2) + 40, $pdf->GetY() + $lineHeight - 2);
$pdf->Ln($lineHeight / 2);
$pdf->SetFont('calibrii', 'I', '9');
$pdf->Cell($tableWidth / 3 + 5, $lineHeight, '(Chief or Head of Office)', 0, 0, 'C');
$pdf->SetFont('calibri', '', 10);
$pdf->SetX($tableWidth / 3 * 2);
$pdf->Cell(40, $lineHeight, 'Date', 0, 0, 'C');
$pdf->Ln($lineHeight - 2);
$pdf->AddFont('times', '', 'times.php');
$pdf->SetFont('times', '', 10);
$pdf->Cell($tableWidth / 3 + 5, $lineHeight, $position . ' (Personnel Officer)', 0, 0, 'C');
$pdf->Line($margin, $pdf->GetY() + $lineHeight - 2, $margin + $tableWidth / 3 + 5, $pdf->GetY() + $lineHeight - 2);
$pdf->Line(($tableWidth / 3) * 2, $pdf->GetY() + $lineHeight - 2, (($tableWidth / 3) * 2) + 40, $pdf->GetY() + $lineHeight - 2);
$pdf->Ln($lineHeight / 2);
$pdf->SetFont('calibrii', 'I', '9');
$pdf->Cell($tableWidth / 3 + 5, $lineHeight, '(Designation)', 0, 0, 'C');
$pdf->SetFont('calibri', '', 10);
$pdf->SetX($tableWidth / 3 * 2);
$pdf->Cell(40, $lineHeight, 'Control No.', 0, 0, 'C');
