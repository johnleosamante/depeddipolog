<?php
// export/index.php
require_once('../includes/function.php');

if (!isset($userId)) {
	redirect(uri() . '/login');
}

if (!isset($_GET['v'])) {
	redirect(uri() . '/' . $activeApp);
}

require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/string.php');

$request = sanitize(decode($_GET['v']));
$identifier = isset($_GET['id']) ? sanitize(decode($_GET['id'])) . '-' : '';
$fileName = $request . '-' . $identifier . date('Y-m-d') . '.xls';
$isPis = $activeApp === 'pis';
$isDts = $activeApp === 'dts';
$isHrmis = $activeApp === 'hrmis';
$isHrtdms = $activeApp === 'hrtdms';
$isDmis = $activeApp === 'dmis';

if (file_exists($request . ".php")) :
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; Filename=" . $fileName);
?>

	<style>
		table,
		th,
		td {
			border: 1px solid;
		}

		table {
			border-collapse: collapse;
		}
	</style>

<?php require_once($request . '.php');
else :
	redirect(uri() . '/login');
endif;
?>