<?php
// modules/employees/tabs/learning-development.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'learning-development', 'show active') ?>" id="learning-development">
    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="45%">Title of Learning &amp; Development Interventions / Training Programs</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="5%">Number of Hours</th>
                        <th class="align-middle" width="10%">Type of Learning &amp; Development</th>
                        <th class="align-middle" width="30%">Conducted / Sponsored by</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $learnings = attendedTrainings($employeeId);

                    if (numRows($learnings) > 0) {
                        while ($learning = fetchAssoc($learnings)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= $learning['title'] ?></td>
                                <td class="align-middle"><?= toDate($learning['from']) ?></td>
                                <td class="align-middle"><?= toDate($learning['to']) ?></td>
                                <td class="align-middle"><?= $learning['hours'] ?></td>
                                <td class="align-middle"><?= $learning['type'] ?></td>
                                <td class="align-middle"><?= $learning['sponsor'] ?></td>
                            </tr>
                        <?php endwhile;
                    } else { ?>
                        <tr>
                            <td colspan="6" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="45%">Title of Learning &amp; Development Interventions / Training Programs</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="5%">Number of Hours</th>
                        <th class="align-middle" width="10%">Type of Learning &amp; Development</th>
                        <th class="align-middle" width="30%">Conducted / Sponsored by</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>