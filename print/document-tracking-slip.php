<?php
// print/document-tracking-slip.php
$logoSize = 19.5;
$margin = 25.4;
$width = 210;
$height = 297;
$lineY = 55;
$multiplePage = true;
$showBarCode = true;
$showQR = true;
$showStationInfo = false;
$isSchoolPortal = $stationId !== divisionId();
$section = strtoupper(stationName($station));
$school = fetchArray(schoolDetailsById($stationId));
$stationLogo = !empty($school['logo']) ? root() . '/' . $school['logo'] : null;
$address = $school['address'];
$telephone = $school['telephone'];
$email = $school['email'];
$website = $school['website'];
$fbPage = $school['fb_page'];
$code = strtoupper(sanitize(decode($_GET['id'])));
$title = $url . ' : ' . $code;

require_once(root() . '/print/print-layout.php');

$pdf = new PDF('P', 'mm', array($width, $height));
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->SetMargins($margin, 11 + $logoSize, $margin);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B', 'calibrib.php');

require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');

$document = fetchAssoc(documentOrigin($code));
$dateCreated = toDate($document['datetime'], 'F d, Y');
$description = toHandleEncoding($document['description']);
$employee = toHandleEncoding(userName($document['user'], true));
$employeePosition = toHandleEncoding(fetchAssoc(position($document['user']))['position']);
$documentStatus = strtolower($document['status']);
$status = str_contains($documentStatus, 'complete') ? ' (Completed)' : '';
$status = str_contains($documentStatus, 'cancel') ? ' (Canceled)' : $status;
$pdf->SetFont('calibrib',  'B', 18);
$pdf->Cell(0, 0, 'DOCUMENT TRACKING SLIP', 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibri',  '', 9);
$pdf->Cell(0, 0, '(Document Attachment)', 0, 0, 'C');
$pdf->Ln(15);
$pdf->SetFont('calibri',  '', 11);
$pdf->Cell(0, 0, $dateCreated, 0, 0, 'R');
$pdf->Ln(10);
$pdf->SetFont('calibrib',  'B', 17);
$pdf->Cell(0, 0, $code . toHandleEncoding($status));
$pdf->Ln(10);
$pdf->SetFont('calibri',  '', 11);
$pdf->Write(5, $description);
$pdf->Ln(20);
$innerPage = $width - ($margin * 2);
$pdf->Cell($innerPage / 2, 0, 'Prepared by:');
$pdf->Ln(15);
$pdf->SetFont('calibrib', 'B', 11);
$pdf->Cell($innerPage / 2, 0, $employee, 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell($innerPage / 2, 0, $employeePosition, 0, 0, 'C');

if ($document['user'] !== $document['head']) {
    $stationHead = toHandleEncoding(userName($document['head'], true));
    $stationHeadPosition = toHandleEncoding(fetchAssoc(position($document['head']))['position']);
    $pdf->Ln(10);
    $pdf->SetX($width / 2);
    $pdf->Cell($innerPage / 2, 0, 'Noted by:');
    $pdf->Ln(15);
    $pdf->SetX($width / 2);
    $pdf->SetFont('calibrib', 'B', 11);
    $pdf->Cell($innerPage / 2, 0, $stationHead, 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->SetX($width / 2);
    $pdf->SetFont('calibri', '', 11);
    $pdf->Cell($innerPage / 2, 0, $stationHeadPosition, 0, 0, 'C');
    $pdf->Ln();
}
