<?php
// includes/layout/content.php
if (!isset($url) || $url === 'dashboard') {
    require_once('dashboard.php');
} else {
    $file = '';

    switch ($url) {
        case 'Incoming Documents':
            $file = 'documents/incoming-documents';
            break;
        case 'Pending Documents':
            $file = 'documents/pending-documents';
            break;
        case 'Outgoing Documents':
            $file = 'documents/outgoing-documents';
            break;
        case 'Ongoing Documents':
            $file = 'documents/ongoing-documents';
            break;
        case 'Completed Documents':
            $file = 'documents/completed-documents';
            break;
        case 'Received Documents':
            $file = 'documents/received-documents';
            break;
        case 'Canceled Documents':
            $file = 'documents/canceled-documents';
            break;
        case 'Document Information':
            $file = 'documents/document-information';
            break;
        case 'Document Search':
            $file = 'documents/document-search';
            break;
        case 'Receive Document':
            $file = 'documents/receive-document';
            break;
        case 'Forward Document':
            $file = 'documents/forward-document';
            break;
        case 'Approve Document':
            $file = 'documents/approve-document';
            break;
        case 'Transactions':
            $file = 'documents/transactions';
            break;
        case 'Active Employees':
        case 'Employees':
            $file = 'employees/active-employees';
            break;
        case 'Retirable Employees':
            $file = 'employees/retirable-employees';
            break;
        case 'Archived Employees':
            $file = 'employees/archived-employees';
            break;
        case 'Employee Information':
        case 'Edit Employee Information':
            $file = 'employees/employee-information';
            break;
        case 'Service Record':
            $file = 'service-record/page';
            break;
        case '201 Files':
            $file = '201-file/page';
            break;
        case 'Payslip':
            $file = 'payslip/page';
            break;
        case 'Step Increment':
            $file = 'step-increment/page';
            break;
        case 'Loyalty Award':
            $file = 'loyalty-award/page';
            break;
        case 'Employee Search':
            $file = 'employees/employee-search';
            break;
        case 'Celebrant Employees':
            $file = 'employees/celebrant-employees';
            break;
        case 'Employees by Position':
            $file = 'employees/employees-position';
            break;
        case 'Users':
            $file = 'users/page';
            break;
        case 'Trainings':
            $file = 'trainings/attended-trainings';
            break;
        case 'Scheduled Trainings':
            $file = 'trainings/scheduled-trainings';
            break;
        case 'Conducted Trainings':
            $file = 'trainings/conducted-trainings';
            break;
        case 'Training Details':
            $file = 'trainings/training-details';
            break;
        case 'Add Training Participants':
            $file = 'trainings/add-training-participants';
            break;
        case 'Districts':
            $file = 'districts/page';
            break;
        case 'District Information':
            $file = 'districts/district-information';
            break;
        case 'Schools':
            $file = 'schools/page';
            break;
        case 'School Information':
            $file = 'schools/school-information';
            break;
        case 'Sections':
            $file = 'sections/page';
            break;
        case 'Section Information':
            $file = 'sections/section-information';
            break;
        case 'Activity Log':
            $file = 'activity/page';
            break;
        case 'Edit History':
            $file = 'activity/edit-history';
            break;
        case 'System Logs':
            $file = 'activity/system-log';
            break;
        case 'Transactions Summary':
            $file = 'documents/transactions-summary';
            break;
        case 'Settings':
            $file = 'settings/page';
            break;
        case '404':
        default:
            $file = 'error/404';
            break;
    }

    require_once(root() . "/modules/{$file}.php");
}
