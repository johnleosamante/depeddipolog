<?php
// modules/documents/pending-documents.php
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
            <li class="breadcrumb-item active">Pending</li>
        </ol>
    </nav>

    <div class="d-inline-block">
        <?php modalButtonSplit(uri() . '/modules/documents/save-document-dialog.php', 'New Document', 'fa-plus') ?>
    </div>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Pending Documents', uri() . '/dts') ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="45%">Description</th>
                        <th class="align-middle" width="20%">Received by</th>
                        <th class="align-middle" width="15%">Received on</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = pendingDocuments($station);
                    while ($row = fetchArray($query)) {
                    ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?php linkItem(customUri('dts', 'Document Information', $row['id']), $row['id']) ?></td>
                            <td class="text-left align-middle"><?= $row['description'] ?></td>
                            <td class="align-middle">
                                <div>
                                    <?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['user']), userName($row['user'])) ?>
                                </div>
                                <div class="small"><?= fetchAssoc(position($row['user']))['position'] ?></div>
                            </td>
                            <td class="align-middle"><?= toDatetime($row['datetime']) ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php linkDropdownItem(customUri('dts', 'Document Information', $row['id']), 'View', 'fa-eye', 'View Document Information');

                                        if (!$isSchoolPortal) {
                                            modalDropdownItem(uri() . '/modules/documents/forward-document-dialog.php?id=' . cipher($row['id']), 'Forward', 'fa-share', 'Forward Document');
                                        }

                                        modalDropdownItem(uri() . '/modules/documents/complete-document-dialog.php?id=' . cipher($row['id']), 'Mark Completed', 'fa-check-circle', 'Mark Complete Document');

                                        if ($row['station'] === $station) {
                                            linkDropdownItem(customUri('print', 'Document Tracking Slip', $row['id']), 'Print', 'fa-print', 'Print Document Tracking Slip', true);

                                            if (!$isSchoolPortal) {
                                                modalDropdownItem(uri() . '/modules/documents/cancel-document-dialog.php?id=' . cipher($row['id']), 'Cancel', 'fa-trash-alt', 'Cancel Document');
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="45%">Description</th>
                        <th class="align-middle" width="20%">Received by</th>
                        <th class="align-middle" width="15%">Received on</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>