<?php
// export/users.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Position</th>
            <th>Station</th>
            <th>Date of Original Appointment</th>
            <th>Years in Service</th>
            <th>Date Last Awarded</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = employeeLoyaltyAward();

        while ($row = fetchArray($query)) :
            $employeeName = toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= strtoupper($employeeName) ?></td>
                <td><?= strtoupper(fetchAssoc(positions($row['position']))['position']) ?></td>
                <td><?= strtoupper(fetchAssoc(schoolById($row['station']))['name']) ?></td>
                <td><?= toDate($row['original_appointment'], 'F j, Y') ?></td>
                <td><?= $row['years_active'] ?></td>
                <td><?= toDate($row['last_awarded_on'], 'F j, Y') ?></td>
            </tr>
        <?php endwhile ?>

        <tr>
            <td colspan="7"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>