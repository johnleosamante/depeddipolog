<?php
// print/certificate-of-participation.php
$logoSize = 24;
$margin = 25.4;
$width = 297;
$height = 210;
$lineY = 55;
$multiplePage = false;
$showQR = true;
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
$code = strtoupper(sanitize(decode($_GET['id'])));

require_once(root() . '/print/print-layout.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/database/position.php');

$employeeId = isset($_GET['p']) ? sanitize(decode($_GET['p'])) : null;
$trainings = attendedTraining($code, $employeeId);

if (numRows($trainings) === 0) {
    redirect(customUri($activeApp, '404'));
}

$employee = fetchAssoc(employee($employeeId));
$employeeName = strtoupper(toHandleEncoding(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true)));
$title = $url . ' | ' . $code . ' | ' . $employeeName;
$pronoun = $employee['sex'] === 'Male' ? 'his' : 'her';
$training = fetchAssoc($trainings);
$trainingTitle = toHandleEncoding($training['title']);
$trainingDate = empty($training['unconsecutive_date']) ? toDateRange($training['from'], $training['to']) : toHandleEncoding($training['unconsecutive_date']);
$trainingVenue = toHandleEncoding($training['venue']);
$lastDate = strtotime($training['to']);
$lastDay = toOrdinal(date('j', $lastDate));
$givenDate = $lastDay . ' day of ' . date('F, Y', $lastDate);
$signatory = $training['signatory'];

if (empty($signatory)) {
    redirect(customUri($activeApp, 'Certificate of Participation'));
}

$signatoryName = toHandleEncoding(userName($signatory, true));
$signatureWidth = 45;
$position = toHandleEncoding(fetchAssoc(position($signatory))['position']);
$code = customUri('print', 'Certificate of Participation', $code, DOMAIN) . '&p=' . encode($employeeId);

$pdf = new PDF('L', 'mm', array($width, $height));
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->SetMargins($margin, 11 + $logoSize, $margin);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B', 'calibri.php');
$pdf->AddFont('timesb', 'B', 'timesb.php');
$pdf->Ln(0);
$pdf->SetFont('OLDENGL', '', 32);
$pdf->Cell(0, 0, 'Certificate of Participation', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell(0, 0, 'is presented to', 0, 0, 'C');
$pdf->Ln(12);
$pdf->SetFont('timesb', 'B', 28);
$pdf->Cell(0, 0, $employeeName, 0, 0, 'C');
$pdf->Ln(12);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell(0, 0, "for {$pronoun} participation during the", 0, 0, 'C');
$pdf->Ln(3);
$pdf->SetFont('timesb', 'B', 14);
$pdf->MultiCell(0, 6, strtoupper($trainingTitle), 0, 'C');
$pdf->Ln(3);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell(0, 0, "held on {$trainingDate}", 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 0, 'at ' . $trainingVenue . '.', 0, 0, 'C');
$pdf->Ln(9);
$pdf->Cell(0, 0, "Given this {$givenDate}", 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 0, 'at ' . $trainingVenue . '.', 0, 0, 'C');
$currentOrdinate = $pdf->GetY();
$pdf->Image(root() . '/uploads/signature/' . $signatory . '/' . $signatory . '.png', ($width / 2) - ($signatureWidth / 2), $currentOrdinate, $signatureWidth);
$pdf->Ln(20);
$pdf->SetFont('timesb', 'B', 14);
$pdf->Cell(0, 0, $signatoryName, 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibri', '', 10);
$pdf->Cell(0, 0, $position, 0, 0, 'C');
