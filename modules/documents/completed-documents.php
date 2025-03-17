<?php
// modules/documents/completed-documents.php
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
            <li class="breadcrumb-item active">Completed</li>
        </ol>
    </nav>

    <div class="d-inline-block">
        <?php modalButtonSplit(uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus') ?>
    </div>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Completed Documents', uri() . '/dts') ?>
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
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="50%">Description</th>
                        <th class="align-middle" width="15%">Posted on</th>
                        <th class="align-middle" width="15%">Completed on</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = completedDocuments($station, $from, $to);
                    while ($row = fetchArray($query)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?php linkItem(customUri('dts', 'Document Information', $row['id']), $row['id']) ?></td>
                            <td class="text-left align-middle"><?= $row['description'] ?></td>
                            <td class="align-middle"><?= toDatetime($row['postedon']) ?></td>
                            <td class="align-middle"><?= toDatetime($row['completedon']) ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php linkDropdownItem(customUri('dts', 'Document Information', $row['id']), 'View', 'fa-eye', 'View Document Information');

                                        if ($row['station'] === $station) {
                                            linkDropdownItem(customUri('print', 'Document Tracking Slip', $row['id']), 'Print', 'fa-print', 'Print Document Tracking Slip', true);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="50%">Description</th>
                        <th class="align-middle" width="15%">Posted on</th>
                        <th class="align-middle" width="15%">Completed on</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>