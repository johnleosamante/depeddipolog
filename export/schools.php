<?php
// export/schools.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/utility.php');
?>

<table>
    <thead>
        <tr>
            <th rowspan="3">#</th>
            <th rowspan="3">School ID</th>
            <th rowspan="3">School Name</th>
            <th rowspan="3">District</th>
            <th rowspan="3">Category</th>
            <th rowspan="3">Head of Office</th>
            <th colspan="9">Personnel</th>
        </tr>
        <tr>
            <th colspan="4">Male</th>
            <th colspan="4">Female</th>
            <th rowspan="2">Total</th>
        </tr>
        <tr>
            <th>Teaching</th>
            <th>Teaching-Related</th>
            <th>Non-Teaching</th>
            <th>Total</th>
            <th>Teaching</th>
            <th>Teaching-Related</th>
            <th>Non-Teaching</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = schoolEmployeeCount();

        while ($row = fetchArray($query)) : ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= strtoupper($row['name']) ?></td>
                <td><?= strtoupper($row['district']) ?></td>
                <td><?= strtoupper($row['category']) ?></td>
                <td><?= strtoupper(userName($row['head'])) ?></td>
                <td><?= $row['tmale'] ?></td>
                <td><?= $row['trmale'] ?></td>
                <td><?= $row['ntmale'] ?></td>
                <td><strong><?= $row['male'] ?></strong></td>
                <td><?= $row['tfemale'] ?></td>
                <td><?= $row['trfemale'] ?></td>
                <td><?= $row['ntfemale'] ?></td>
                <td><strong><?= $row['female'] ?></strong></td>
                <td><strong><?= $row['total'] ?></strong></td>
            </tr>
        <?php endwhile ?>
        <tr>
            <td colspan="15"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>