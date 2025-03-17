<?php
// dts/sidebar-menu.php
sidebarDivider();

$countIncoming = number_format(numRows(incomingDocuments($station)));
$countPending = number_format(numRows(pendingDocuments($station)));
$countOutgoing = number_format(numRows(outgoingDocuments($station)));
$countOngoing = number_format(numRows(ongoingDocuments($station)));

sidebarModalItem(uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus');
sidebarMenuItem(customUri('dts', 'Incoming Documents'), 'Incoming', 'fa-file-download', isset($url) && str_contains($url, 'Incoming'), $countIncoming);
sidebarMenuItem(customUri('dts', 'Pending Documents'), 'Pending', 'fa-history', isset($url) && str_contains($url, 'Pending'), $countPending);
sidebarMenuItem(customUri('dts', 'Outgoing Documents'), 'Outgoing', 'fa-file-upload', isset($url) && str_contains($url, 'Outgoing'), $countOutgoing);
sidebarDivider();
sidebarMenuItem(customUri('dts', 'Ongoing Documents'), 'Ongoing', 'fa-tasks', isset($url) && str_contains($url, 'Ongoing'), $countOngoing);
sidebarDivider();
sidebarMenuItem(customUri('dts', 'Completed Documents'), 'Completed', 'fa-check-circle', isset($url) && str_contains($url, 'Completed'));

if (!$isSchoolPortal) {
	sidebarMenuItem(customUri('dts', 'Received Documents'), 'Received', 'fa-hand-holding-medical', isset($url) && str_contains($url, 'Received'));
}

sidebarMenuItem(customUri('dts', 'Canceled Documents'), 'Canceled', 'fa-trash-alt', isset($url) && str_contains($url, 'Canceled'));
sidebarDivider();
sidebarMenuItem(customUri('dts', 'Transactions Summary'), 'Summary', 'fa-chart-bar', isset($url) && str_contains($url, 'Summary'));
