<?php
// print/index.php
require_once('../includes/function.php');
require_once(root() . '/includes/string.php');

$departmentSeal = root() . '/uploads/division/deped-seal.png';
$footerLogos = root() . '/uploads/division/footer-logos.png';
$country = 'Republic of the Philippines';
$department = 'Department of Education';

$page = $url = sanitize(decode($_GET['v']));
$file = $title = '';

switch ($url) {
    case 'Document Tracking Slip':
        if (!isset($_SESSION[alias() . '_userId']) || !isset($_SESSION[alias() . '_portal'])) {
            redirect(uri() . '/login');
        }
        $file = 'document-tracking-slip';
        break;
    case 'Certificate of Appearance':
        if (!isset($_GET['id']) || !isset($_GET['p'])) {
            redirect(customUri($activeApp, '404'));
        }
        $file = 'certificate-of-appearance';
        break;
    case 'Certificate of Participation':
        if (!isset($_GET['id']) || !isset($_GET['p'])) {
            redirect(customUri($activeApp, '404'));
        }
        $file = 'certificate-of-participation';
        break;
    case 'Service Record':
        $file = 'service-record';
        break;
    default:
        redirect(customUri($activeApp, '404'));
        break;
}

require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/plugin/fpdf/fpdf.php');
require_once(root() . '/includes/plugin/code128/code128.php');
require_once(root() . '/includes/plugin/phpqrcode/qrlib.php');
require_once(root() . "/print/{$file}.php");

$pdf->Output("I", "{$title}.pdf");
