<?php
// hrmis/sidebar-menu.php
sidebarDivider();
sidebarHeading('Employees');

$countActive = number_format(numRows(activeEmployees()));
$countRetirable = number_format(numRows(retirableEmployees()));
$countStepIncrement = number_format(numRows(employeeStepIncrement()));
$countLoyaltyAward = number_format(numRows(employeeLoyaltyAward()));
$districtCount = number_format(numRows(districts()));
$schoolCount = number_format(numRows(schools()));
$sectionCount = number_format(numRows(sections()));

sidebarModalItem(uri() . '/modules/employees/save-employee-dialog.php', 'Add Employee', 'fa-user-plus');
sidebarMenuItem(customUri('hrmis', 'Active Employees'), 'Active', 'fa-user-check', isset($url) && str_contains($url, 'Active'), $countActive);
sidebarMenuItem(customUri('hrmis', 'Retirable Employees'), 'Retirable', 'fa-user-clock', isset($url) && str_contains($url, 'Retirable'), $countRetirable);
sidebarMenuItem(customUri('hrmis', 'Celebrant Employees'), 'Celebrants', 'fa-birthday-cake', isset($url) && str_contains($url, 'Celebrant'));
sidebarMenuItem(customUri('hrmis', 'Archived Employees'), 'Archived', 'fa-archive', isset($url) && str_contains($url, 'Archived'));
sidebarDivider();
sidebarMenuItem(customUri('hrmis', 'Step Increment'), 'Step', 'fa-plus', isset($url) && str_contains($url, 'Step'), $countStepIncrement);
sidebarMenuItem(customUri('hrmis', 'Loyalty Award'), 'Loyalty', 'fa-award', isset($url) && str_contains($url, 'Loyalty'), $countLoyaltyAward);
sidebarDivider();
sidebarMenuItem(customUri('hrmis', 'Districts'), 'Districts', 'fa-map-marked-alt', isset($url) && str_contains($url, 'District'), $districtCount);
sidebarMenuItem(customUri('hrmis', 'Schools'), 'Schools', 'fa-school', isset($url) && str_contains($url, 'School'), $schoolCount);
sidebarMenuItem(customUri('hrmis', 'Sections'), 'Sections', 'fa-map-signs', isset($url) && str_contains($url, 'Section'), $sectionCount);
