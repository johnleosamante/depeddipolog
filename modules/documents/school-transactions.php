<?php
// modules/documents/school-transactions.php
?>

<div class="tab-pane fade show active" id="school-transactions">
    <div class="row my-3">
        <div class="col table-responsive">
            <?php if ($isDmis) { ?>
                <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                    <div class="d-inline-block">
                        <?php linkButtonSplit(customUri('export', 'school-transactions'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
                    </div>
                </div>
            <?php } ?>

            <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table-previous" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">Logo</th>
                        <th class="align-middle" width="35%">School Name / Alias / ID / District / Address</th>
                        <th class="align-middle" width="15%">Incoming</th>
                        <th class="align-middle" width="15%">Pending</th>
                        <th class="align-middle" width="15%">Outgoing</th>
                        <th class="align-middle" width="15%">Ongoing</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $schools = schoolsExcept(divisionID());
                    while ($school = fetchAssoc($schools)) :
                        $logo = !empty($school['logo']) ? uri() . '/' . $school['logo'] : uri() . '/uploads/division/division.png';
                        $schoolName = $school['name'];
                        $district = fetchAssoc(district($school['district']))['name'];
                    ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div class="image-container">
                                    <span class="d-flex justify-content-center align-middle school-logo overflow-hidden">
                                        <img height="100%" src="<?= $logo ?>" alt="<?= $schoolName ?>">
                                    </span>
                                </div>
                            </td>
                            <td class="align-middle text-left">
                                <div><?php linkItem(customUri($activeApp, 'School Information', $school['id']), $schoolName . ' (' . $school['alias'] . ')') ?></div>
                                <div class="small"><?= $school['id'] . ' | ' . $district . ' | ' . $school['address'] ?></div>
                            </td>
                            <td class="align-middle"><?= number_format(numRows(incomingDocuments($school['alias']))) ?></td>
                            <td class="align-middle"><?= number_format(numRows(pendingDocuments($school['alias']))) ?></td>
                            <td class="align-middle"><?= number_format(numRows(outgoingDocuments($school['alias']))) ?></td>
                            <td class="align-middle"><?= number_format(numRows(ongoingDocuments($school['alias']))) ?></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">Logo</th>
                        <th class="align-middle" width="35%">School Name / Alias / ID / District / Address</th>
                        <th class="align-middle" width="15%">Incoming</th>
                        <th class="align-middle" width="15%">Pending</th>
                        <th class="align-middle" width="15%">Outgoing</th>
                        <th class="align-middle" width="15%">Ongoing</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>