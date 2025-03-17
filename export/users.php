<?php
// export/users.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/account.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Station</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = users();

        while ($row = fetchArray($query)) :
            $employeeName = toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= strtoupper($employeeName) ?></td>
                <td><?= strtolower($row['email']) ?></td>
                <td><?= strtoupper(fetchAssoc(positions($row['position']))['position']) ?></td>
                <td><?= strtoupper(fetchAssoc(schoolById($row['assignment']))['name']) ?></td>
                <td><?= strtoupper($row['status']) ?></td>
            </tr>
        <?php endwhile ?>

        <tr>
            <td colspan="6"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>