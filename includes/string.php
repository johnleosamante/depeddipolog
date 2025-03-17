<?php
// include/string.php
function toString($string, $prefix = null, $suffix = null, $ischar = false)
{
    if (empty($string)) return '';
    if (strtolower($string) === 'n/a') return '';
    if ($ischar) $string = $string[0];
    return $prefix . $string . $suffix;
}

function toName($lastName, $firstName, $middleName = '', $extension = '', $fnameFirst = false, $middleInitial = true)
{
    if (strlen($middleName) > 0 && $middleName !== ' ' && strtoupper($middleName) !== 'n/a') {
        $suffix = $middleInitial ? '.' : '';
        $middleName = toString($middleName, ' ', $suffix, $middleInitial);
    } else {
        $middleName = '';
    }

    if (!$fnameFirst) {
        return $lastName . toString($firstName, ', ') . toString($extension, ' ') . $middleName;
    } else {
        return $firstName . toString($middleName) . toString($lastName, ' ') . toString($extension, ', ');
    }
}

function toAddress($lot, $street, $subdivision, $barangay, $city, $province = '')
{
    return toString($lot, '', ', ') . toString($street, '', ', ') . toString($subdivision, '', ', ') . toString($barangay, '', ', ') . toString($city) . toString($province, ', ');
}

function toHandleNull($value, $default = '')
{
    return !empty($value) ? $value : $default;
}

function toDate($date, $format = 'm/d/Y', $default = '')
{
    return strtotime($date) ? date($format, strtotime($date)) : $default;
}

function toLongDate($date, $default = '')
{
    return toDate($date, 'F j, Y', $default);
}

function toDatetime($date)
{
    return strtotime($date) ? date('F j, Y', strtotime($date)) . '<br>' . date('h:i:s A', strtotime($date)) : $date;
}

function toCurrency($value, $currency = '&#8369;')
{
    $number = is_numeric($value) ? $value : 0;
    return $currency . ' ' . number_format(floatval($number), 2);
}

function sanitize($input)
{
    return isset($input) ? htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES) : '';
}

function removeTags($input)
{
    return isset($input) ? strip_tags($input) : null;
}

function convertTags($input)
{
    return isset($input) ? htmlentities($input) : null;
}

function toHandleEncoding($string)
{
    return mb_convert_encoding(html_entity_decode($string, ENT_QUOTES), 'ISO-8859-1', 'UTF-8');
}

function randomPassword($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*?';
    $charLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }

    return $randomString;
}

function checkPasswordStrength($password)
{
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    $hasSpecialCharacter = preg_match('/[^a-zA-Z\d]/', $password);
    return $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialCharacter;
}

function generateStrongRandomPassword()
{
    $strongPassword = false;
    $randomPassword = '';
    $length = rand(10, 12);

    while (!$strongPassword) {
        $randomPassword = randomPassword($length);
        $strongPassword = checkPasswordStrength($randomPassword);
    }

    return $randomPassword;
}

function toDateRange($from, $to)
{
    $from = strtotime($from);
    $to = strtotime($to);
    $sameDay = $from === $to;
    $sameYear = date('Y', $from) === date('Y', $to);
    $sameMonth = date('m', $from) === date('m', $to);

    if ($sameDay) {
        return date('F j, Y', $from);
    } elseif ($sameYear && $sameMonth) {
        return date('F j', $from) . '-' . date('j, Y', $to);
    } elseif ($sameYear && !$sameMonth) {
        return date('F j', $from) . ' - ' . date('F j, Y', $to);
    } else {
        return date('F j, Y', $from) . ' - ' . date('F j, Y', $to);
    }
}

function toOrdinal($number)
{
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return $number . 'th';
    } else {
        return $number . $ends[$number % 10];
    }
}
