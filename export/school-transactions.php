<?php
// export/school-transactions.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/document.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>School Name</th>
            <th>District</th>
            <th>Incoming</th>
            <th>Pending</th>
            <th>Outgoing</th>
            <th>Ongoing</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;

        $schools = schoolsExcept(divisionID());
        while ($school = fetchAssoc($schools)) :
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= strtoupper($school['name']) ?></td>
                <td><?= strtoupper(fetchAssoc(district($school['district']))['name']) ?></td>
                <td><?= number_format(numRows(incomingDocuments($school['alias']))) ?></td>
                <td><?= number_format(numRows(pendingDocuments($school['alias']))) ?></td>
                <td><?= number_format(numRows(outgoingDocuments($school['alias']))) ?></td>
                <td><?= number_format(numRows(ongoingDocuments($school['alias']))) ?></td>
            </tr>
        <?php endwhile ?>
        <tr>
            <td colspan="7"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>