<?php
// hrtdms/sidebar-menu.php
sidebarDivider();
sidebarHeading('Trainings');

$countScheduled = number_format(numRows(scheduledTrainings()));
$countActive = number_format(numRows(activeEmployees()));
$districtCount = number_format(numRows(districts()));
$schoolCount = number_format(numRows(schools()));
$sectionCount = number_format(numRows(sections()));

sidebarModalItem(uri() . '/modules/trainings/save-training-dialog.php', 'Add Training', 'fa-plus');
sidebarMenuItem(customUri('hrtdms', 'Scheduled Trainings'), 'Scheduled', 'fa-calendar-alt', isset($url) && str_contains($url, 'Scheduled'), $countScheduled);
sidebarMenuItem(customUri('hrtdms', 'Conducted Trainings'), 'Conducted', 'fa-chalkboard-teacher', isset($url) && str_contains($url, 'Conducted'));
sidebarDivider();
sidebarMenuItem(customUri('hrtdms', 'Employees'), 'Employees', 'fa-users', isset($url) && str_contains($url, 'Employees'), $countActive);
sidebarMenuItem(customUri('hrtdms', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('hrtdms', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
sidebarMenuItem(customUri('hrtdms', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Section'), $sectionCount);
