<?php
// modules/documents/summary-report.php
if (!$isDts) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Summary</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('Transactions Summary') ?>
    </div>

    <div class="card-body">
        <form action="" method="POST" class="mb-3">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-2 d-flex align-items-center">
                                <label for="date-from" class="font-weight-bold m-0">From:</label>
                            </div>
                            <div class="col-10">
                                <input class="form-control" id="date-from" type="date" name="date-from" value="<?= $from ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-2 d-flex align-items-center">
                                <label for="date-to" class="font-weight-bold m-0">To:</label>
                            </div>
                            <div class="col-10">
                                <input class="form-control" id="date-to" type="date" name="date-to" value="<?= $to ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block" name="transactions-summary-filter">Filter Date <i class="fa fa-filter"></i></button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="20%">User</th>
                        <th class="align-middle" width="25%">Position</th>
                        <th class="align-middle" width="10%">Created</th>
                        <th class="align-middle" width="10%">Received</th>
                        <?php if (!$isSchoolPortal) : ?>
                            <th class="align-middle" width="10%">Forwarded</th>
                        <?php endif ?>
                        <th class="align-middle" width="10%">Completed</th>
                        <th class="align-middle" width="10%">Canceled</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $query = portalUsers($station, $from, $to);

                    while ($row = fetchArray($query)) :
                        $employeeName = toName($row['lname'], $row['fname'], $row['mname'], $row['ext']);
                        $photo = file_exists(root() . '/' . $row['picture']) ? uri() . '/' . $row['picture'] : uri() . '/assets/img/user.png';
                    ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div class="image-container">
                                    <span class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                                        <img height="100%" src="<?= $photo ?>" alt="<?= $employeeName ?>">
                                    </span>
                                    <div class="sex-sign"><?php sex($row['sex']) ?></div>
                                </div>
                            </td>
                            <td class="align-middle text-left"><?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['id']), $employeeName) ?></td>
                            <td class="align-middle"><?= fetchAssoc(positions($row['position']))['position'] ?></td>
                            <td class="align-middle"><?= number_format(numRows(documentByStatus('Created Document', $row['id'], $code, $from, $to))) ?></td>
                            <td class="align-middle"><?= number_format(numRows(documentByStatus('Received Document', $row['id'], $code, $from, $to))) ?></td>
                            <?php if (!$isSchoolPortal) : ?>
                                <td class="align-middle"><?= number_format(numRows(documentByStatus('Forwarded Document', $row['id'], $code, $from, $to))) ?></td>
                            <?php endif ?>
                            <td class="align-middle"><?= number_format(numRows(documentByStatus('Completed Document', $row['id'], $code, $from, $to))) ?></td>
                            <td class="align-middle"><?= number_format(numRows(documentByStatus('Canceled Document', $row['id'], $code, $from, $to))) ?></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="20%">User</th>
                        <th class="align-middle" width="25%">Position</th>
                        <th class="align-middle" width="10%">Created</th>
                        <th class="align-middle" width="10%">Received</th>
                        <?php if (!$isSchoolPortal) : ?>
                            <th class="align-middle" width="10%">Forwarded</th>
                        <?php endif ?>
                        <th class="align-middle" width="10%">Completed</th>
                        <th class="align-middle" width="10%">Canceled</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>