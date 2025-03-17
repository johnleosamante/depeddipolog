<?php
// modules/trainings/attended-trainings.php
if (!$isPis && !$isHrmis && !$isHrtdms) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employeeId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;

if ($isPis && $userId !== $employeeId) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$employees = employee($employeeId);

if (numRows($employees) > 0) {
    $employee = fetchAssoc($employees);
    $employeeId = $employee['id'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Trainings</li>
        </ol>
    </nav>
</div>

<?php
if ($isHrmis) {
    require_once(root() . '/modules/employees/employee-tabs.php');
}
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isPis) {
            contentTitleWithLink('Trainings : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])), uri() . '/pis');
        } else {
            contentTitle('Trainings : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'])));
        } ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="35%">Title of Learning &amp; Development Interventions / Training Programs</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="5%">Number of Hours</th>
                        <th class="align-middle" width="10%">Type of Learning &amp; Development</th>
                        <th class="align-middle" width="15%">Conducted / Sponsored by</th>
                        <th class="align-middle" width="20%">Venue</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $trainings = attendedTrainings($employeeId);
                    while ($training = fetchAssoc($trainings)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= $training['title'] ?></td>
                            <td class="align-middle"><?= toDate($training['from']) ?></td>
                            <td class="align-middle"><?= toDate($training['to']) ?></td>
                            <td class="align-middle"><?= $training['hours'] ?></td>
                            <td class="align-middle"><?= $training['type'] ?></td>
                            <td class="align-middle"><?= $training['sponsor'] ?></td>
                            <td class="align-middle"><?= $training['venue'] ?></td>
                            <td class="align-middle text-capitalize">
                                <?php if ($training['generate_certificate'] === '1') : ?>
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-righ shadow animated--fade-in">
                                            <?php
                                            linkDropdownItem(customUri('print', 'Certificate of Participation', $training['no']) . '&p=' . encode($employeeId), 'Download', 'fa-download', 'Download Certificate', true);
                                            linkDropdownItem(customUri('print', 'Certificate of Appearance', $training['no']) . '&p=' . encode($employeeId), 'Appearance', 'fa-stamp', 'View Certificate of Appearance', true);
                                            ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="35%">Title of Learning &amp; Development Interventions / Training Programs</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="5%">Number of Hours</th>
                        <th class="align-middle" width="10%">Type of Learning &amp; Development</th>
                        <th class="align-middle" width="15%">Conducted / Sponsored by</th>
                        <th class="align-middle" width="20%">Venue</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>