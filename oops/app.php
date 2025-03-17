<?php
// oops/app.php
$code = !isset($_GET['e']) ? http_response_code() : $_GET['e'];

switch ($code) {
    case '403':
        $file = '403';
        $error = 'Access Denied';
        break;
    case '404':
        $file = '404';
        $error = 'Page Not Found';
        break;
    default:
        $file = 'error';
        $error = 'Unexpected Error';
        break;
}

$page = $appTitle = $error;
