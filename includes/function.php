<?php
// include/function.php
require_once('config.php');

$onError = function ($level, $message, $file, $line) {
    throw new ErrorException($message, 0, $level, $file, $line);
};

function hashPassword($string)
{
    return md5($string);
}

function cipher($string)
{
    return base64_encode($string);
}

function decipher($string)
{
    return base64_decode($string);
}

function encode($string)
{
    return urlencode(cipher($string));
}

function decode($string)
{
    return urldecode(decipher($string));
}

function root()
{
    return $_SERVER['DOCUMENT_ROOT'];
}

function uri($domain = null)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $root = $domain !== null ? $domain : $_SERVER['HTTP_HOST'];
    return $protocol . $root;
}

function isWeekend()
{
    $day = date('N');
    return $day > 5;
}

function isOfficialTime($startTime = '06:30:00', $endTime = '18:30:00')
{
    return (time() >= strtotime($startTime) && time() <= strtotime($endTime));
}

function restrictPublicAccess($isHoliday)
{
    if (isWeekend() || !isOfficialTime() || $isHoliday) {
        redirect(uri() . '/oops');
    }
}

function customUri($page, $view, $id = null, $domain = null)
{
    $value = ($id !== null) ? '&id=' . encode($id) : '';

    return uri($domain) . "/{$page}?&v=" . encode($view) . $value;
}

function title($page = null)
{
    return $page === null ? SITE_TITLE : $page . ' | ' . SITE_TITLE;
}

function alias()
{
    return SITE_ALIAS;
}

function description()
{
    return SITE_DESCRIPTION;
}

function author()
{
    return SITE_AUTHOR;
}

function division()
{
    return DIVISION;
}

function divisionId()
{
    return DIVISION_ID;
}

function region()
{
    return REGION;
}

function clientIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function redirect($url = null)
{
    if ($url !== null) {
        header("Location: {$url}");
        exit;
    }
}

function getDatetimeAsId()
{
    return date('YmdHis');
}

function getSeconds($hours = 1)
{
    return $hours * 60 * 60;
}

function setActiveItem($reference, $value, $class = 'active')
{
    return strtolower($reference) === strtolower($value) ? " {$class}" : '';
}

function setActiveNavigation($condition, $class = 'active')
{
    return $condition ? " {$class}" : '';
}

function isValidEmail($email, $domain = null)
{
    if ($domain === null) {
        return preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email);
    }

    return preg_match("/^[a-zA-Z0-9_.-]+@+" . $domain . "+$/", $email);
}

function setOptionSelected($reference, $value)
{
    return strtolower($reference) === strtolower($value) ? ' selected' : '';
}

function setItemChecked($condition)
{
    return $condition ? ' checked' : '';
}

function getDateDifference($year, $month, $day)
{
    $now = new DateTime();
    $bdate = new DateTime("{$year}-{$month}-{$day}");
    return $now->diff($bdate)->y;
}

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle)
    {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

require_once('initialization.php');
