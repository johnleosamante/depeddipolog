<?php
// modules/documents/document-search.php

if (!$isDts) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$search = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$documents = documentSearch($search, $station);
$results = numRows($documents);
$isDts = $activeApp === 'dts';

if ($results === 0) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink("Document Search : \"{$search}\"", uri() . '/dts') ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="10%">Code</th>
                        <th class="align-middle" width="35%">Description</th>
                        <th class="align-middle" width="20%">From</th>
                        <th class="align-middle" width="15%">Date</th>
                        <th class="align-middle" width="15%">Status</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = fetchArray($documents)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?php linkItem(customUri('dts', 'Document Information', $row['id']), $row['id']) ?></td>
                            <td class="text-left align-middle"><?= $row['description'] ?></td>
                            <td class="align-middle text-uppercase">
                                <?= stationName($row['from']) ?>
                            </td>
                            <td class="align-middle"><?= toDatetime($row['datetime']) ?></td>
                            <td class="align-middle"><?= $row['status'] ?></td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php linkDropdownItem(customUri('dts', 'Document Information', $row['id']), 'View', 'fa-eye', 'View Document Information');

                                        linkDropdownItem(customUri('print', 'Document Tracking Slip', $row['id']), 'Print', 'fa-print', 'Print Document Tracking Slip', true);
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="10%">Code</th>
                        <th class="align-middle" width="35%">Description</th>
                        <th class="align-middle" width="20%">From</th>
                        <th class="align-middle" width="15%">Date</th>
                        <th class="align-middle" width="15%">Status</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>