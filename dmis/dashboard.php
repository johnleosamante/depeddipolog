<?php
// dmis/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitle('Dashboard');
?>

<div class="row mt-4">
	<?php
	card('Employees', customUri('dmis', 'Employees'), 'fa-users', 'primary', $employeeCount);
	card('Districts', customUri('dmis', 'Districts'), 'fa-map-marked-alt', 'success', $districtCount);
	card('Schools', customUri('dmis', 'Schools'), 'fa-school', 'info', $schoolCount);
	card('Sections', customUri('dmis', 'Sections'), 'fa-map-signs', 'warning', $sectionCount);
	card('Users', customUri('dmis', 'Users'), 'fa-user-friends', 'danger', $userCount);
	card('Transactions', customUri('dmis', 'Transactions'), 'fa-exchange-alt', 'secondary');
	card('System Logs', customUri('dmis', 'System Logs'), 'fa-file-alt', 'dark');
	?>
</div>