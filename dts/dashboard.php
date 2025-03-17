<?php
// dts/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitleWithModal('Dashboard', uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus');
?>

<div class="row mt-4">
	<?php
	card('Incoming Documents', customUri('dts', 'Incoming Documents'), 'fa-file-download', 'primary', $countIncoming);
	card('Pending Documents', customUri('dts', 'Pending Documents'), 'fa-history', 'success', $countPending);
	card('Outgoing Documents', customUri('dts', 'Outgoing Documents'), 'fa-file-upload', 'info', $countOutgoing);
	card('Ongoing Documents', customUri('dts', 'Ongoing Documents'), 'fa-tasks', 'warning', $countOngoing);
	card('Completed Documents', customUri('dts', 'Completed Documents'), 'fa-check-circle', 'secondary');

	if (!$isSchoolPortal) {
		card('Received Documents', customUri('dts', 'Received Documents'), 'fa-hand-holding-medical', 'dark');
	}

	card('Canceled Documents', customUri('dts', 'Canceled Documents'), 'fa-trash-alt', 'danger');
	card('Transactions Summary', customUri('dts', 'Transactions Summary'), 'fa-chart-bar', 'primary');
	?>
</div>