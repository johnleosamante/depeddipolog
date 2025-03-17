<?php
// modules/activity/system-log.php
if (!$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">System Log</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('System Log') ?>
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
                                <input class="form-control" id="date-from" type="date" name="date-from" value="<?= $fromDate ?>">
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
                                <input class="form-control" id="date-to" type="date" name="date-to" value="<?= $toDate ?>">
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
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="20%">Date/Time</th>
                        <th class="align-middle" width="50%">Activity</th>
                        <th class="align-middle" width="25%">User</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = systemLogs($fromDate, $toDate);
                    $no = 0;
                    while ($row = fetchAssoc($query)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= ++$no ?></td>
                            <td class="align-middle"><?= toDatetime($row['datetime']) ?></td>
                            <td class="text-left align-middle"><?= $row['activity'] ?></td>
                            <td class="text-center align-middle">
                                <?php $userLabel = $userId === $row['target'] ? 'YOU' : userName($row['target']);
                                modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['target']), $userLabel);

                                if ($isDmis || $isHrmis) : ?>
                                    <br><small><?= '(' . $row['ip'] . ')' ?></small>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="20%">Date/Time</th>
                        <th class="align-middle" width="50%">Activity</th>
                        <th class="align-middle" width="25%">User</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>