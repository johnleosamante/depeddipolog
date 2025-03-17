<?php
// logout/index.php
require_once('../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/activity.php');
require_once(root() . '/includes/database/system-log.php');

if (isset($_SESSION[alias() . '_userId'])) {
    createSystemLog($stationId, $userId, 'Logged out', $userId, clientIp());
    session_destroy();
    setcookie(alias() . '_login', '', time() - getSeconds(8), '/', uri(), false, true);
    redirect(uri() . '/login');
}
