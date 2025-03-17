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
            <th>Last Step Date</th>
            <th>From</th>
            <th>To</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = employeeStepIncrement();

        while ($row = fetchArray($query)) :
            $employeeName = toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
            $sg = $row['sg'];
            $step = !empty($row['step']) ? $row['step'] : 1;
            $lastStepDate = $row['last_step_date'];
            $now = new DateTime('now');
            $dls = new DateTime($lastStepDate);
            $count = (int)($now->diff($dls)->y / 3);
            $nextStep = (int)$step + $count;
            $nextStep = $nextStep <= 8 ? $nextStep : 8;
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= strtoupper($employeeName) ?></td>
                <td><?= strtoupper(fetchAssoc(positions($row['position']))['position']) ?></td>
                <td><?= strtoupper(fetchAssoc(schoolById($row['station']))['name']) ?></td>
                <td><?= date('F j, Y', strtotime($lastStepDate)) ?></td>
                <td><?= "'{$sg}-{$step}" ?></td>
                <td><?= "'{$sg}-{$nextStep}" ?></td>
            </tr>
        <?php endwhile ?>

        <tr>
            <td colspan="7"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>