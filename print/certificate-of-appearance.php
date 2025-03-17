<?php
// print/certificate-of-appreciation.php
$logoSize = 12;
$margin = 8;
$width = 210;
$height = 148.5;

$school = fetchArray(schoolDetailsById(divisionId()));
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
$trainingId = $training['no'];
$trainingTitle = toHandleEncoding($training['title']);
$trainingDate = empty($training['unconsecutive_date']) ? toDateRange($training['from'], $training['to']) : toHandleEncoding($training['unconsecutive_date']);
$trainingVenue = toHandleEncoding($training['venue']);
$lastDate = strtotime($training['to']);
$lastDay = toOrdinal(date('j', $lastDate));
$givenDate = $lastDay . ' day of ' . date('F, Y', $lastDate);
$signatory = $training['signatory'];
$employeeTraining = fetchAssoc(attendedTraining($trainingId, $employeeId));
$controlNo = !empty($employeeTraining['control_no']) ? 'Control Number: ' . $employeeTraining['control_no'] : '';

if (empty($signatory)) {
    redirect(customUri($activeApp, '404'));
}

$signatoryName = toHandleEncoding(userName($signatory, true));
$signatureWidth = 35;
$position = toHandleEncoding(fetchAssoc(position($signatory))['position']);

$pdf = new FPDF('L', 'mm', array($width, $height));
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true);
$pdf->AddPage();
$pdf->AddFont('OLDENGL', '', 'OLDENGL.php');
$pdf->AddFont('TrajanPro-Regular', '', 'TrajanPro-Regular.php');
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B', 'calibri.php');
$pdf->AddFont('timesb', 'B', 'timesb.php');

// Head
$pdf->Image($departmentSeal, ($width / 2) - ($logoSize / 2), $logoSize / 2, $logoSize);
$pdf->Ln(10);
$pdf->SetFont('OLDENGL', '', 9);
$pdf->Cell(0, 0, $country, 0, 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('OLDENGL', '', 12);
$pdf->Cell(0, 0, $department, 0, 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('TrajanPro-Regular', '', 7);
$pdf->Cell(0, 0, region(), 0, 0, 'C');
$pdf->Ln(3);
$pdf->Cell(0, 0, division(), 0, 0, 'C');
$pdf->Line($margin, 33, $width - $margin, 33);

// Body
$pdf->Ln(8);
$pdf->SetFont('timesb', 'B', 14);
$pdf->Cell(0, 0, 'CERTIFICATE OF APPEARANCE', 0, 0, 'C');
$pdf->Ln(8);
$pdf->SetFont('timesb', 'B', 12);
$pdf->Cell(0, 0, 'TO WHOM IT MAY CONCERN:');
$pdf->Ln(7);
$pdf->SetFont('calibri', '', 10);
$pdf->Write(5, '                    This is to certify that the Officer/Employee, whose name and designation are sworn, appeared in this Office as indicated and for the purpose/s as stated below.');
$pdf->Ln(12);
$pdf->Cell(30, 0, 'Name');
$pdf->Cell(3, 0, ':');
$pdf->Cell(0, 0, $employeeName);
$lineWidth = $width - ($margin * 1.60);
$pdf->Line(44, 72.5, $lineWidth, 72.5);
$pdf->Ln(4);
$pdf->Cell(30, 0, 'Position');
$pdf->Cell(3, 0, ':');
$pdf->Cell(0, 0, '');
$pdf->Line(44, 76.5, $lineWidth, 76.5);
$pdf->Ln(4);
$pdf->Cell(30, 0, 'Inclusive Dates');
$pdf->Cell(3, 0, ':');
$pdf->Cell(0, 0, $trainingDate);
$pdf->Line(44, 80.5, $lineWidth, 80.5);
$pdf->Ln(4);
$pdf->Cell(30, 0, 'Purpose/s');
$pdf->Cell(3, 0, ':');
$pdf->SetY(81);
$pdf->SetX(43);
$pdf->MultiCell(155, 4, $trainingTitle);
$pdf->Line(44, 84.5, $lineWidth, 84.5);
$pdf->Line(44, 88.5, $lineWidth, 88.5);
$pdf->Line(44, 92.5, $lineWidth, 92.5);
$pdf->Line(102, 101, 175, 101);
$pdf->SetY(97);
$pdf->Write(5, '                    This certification is issued at the request of Mr./Ms.                                                                                              for the purpose of establishing the evidence and duration of his/her appearance hereto, the truth of which is hereby vouched-safe and guaranteed by the undersigned.');
$currentOrdinate = $pdf->GetY();
$pdf->Image(root() . '/uploads/signature/' . $signatory . '/' . $signatory . '.png', ($width / 2) - ($signatureWidth / 2), $currentOrdinate - 4, $signatureWidth);
$pdf->Ln(12);
$pdf->SetFont('timesb', 'B', 10);
$pdf->Cell(0, 0, $signatoryName, 0, 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('calibri', '', 9);
$pdf->Cell(0, 0, $position, 0, 0, 'C');

$pdf->Cell(0, 0, $controlNo, 0, 0, 'R');

// Foot
$pdf->Line($margin, $height - 21, $width - $margin, $height - 21);
$pdf->Image($footerLogos, $margin, $height - 20, 0, $logoSize);
$pdf->SetFont('calibri', '', 8);

$pdf->SetY(-18.5);

if (strlen($address) > 0) {
    $pdf->SetX(145);
    $pdf->Cell(0, 0, "Address: {$address}");
    $pdf->Ln(3);
}

if (strlen($telephone) > 0) {
    $pdf->SetX(145);
    $pdf->Cell(0, 0, "Telephone No: {$telephone}");
    $pdf->Ln(3);
}

if (strlen($email) > 0) {
    $pdf->SetX(145);
    $pdf->Cell(0, 0, "Email Address: {$email}");
    $pdf->Ln(3);
}

if (strlen($website) > 0) {
    $pdf->SetX(145);
    $pdf->Cell(0, 0, "Website: {$website}");
    $pdf->Ln(3);
}

if (strlen($fbPage) > 0) {
    $pdf->SetX(145);
    $pdf->Cell(0, 0, "FB Page: {$fbPage}");
}
