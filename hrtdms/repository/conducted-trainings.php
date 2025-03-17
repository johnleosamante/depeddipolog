<?php
// hrtdms/repository/conducted-trainings.php
?>

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
        <table class="table table-striped table-bordered table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="align-middle" width="65%">Title of Division Training</th>
                    <th class="align-middle" width="35%">Conducted on</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $trainings = conductedTrainings($fromDate, $toDate);
                while ($training = fetchAssoc($trainings)) : ?>
                    <tr class="text-uppercase">
                        <td class="align-middle text-left">
                            <?php linkItem(customUri('hrtdms/repository', 'Training Details', $training['no']), $training['title']) ?>
                        </td>
                        <td class="align-middle">
                            <?= empty($training['unconsecutive_date']) ? toDateRange($training['from'], $training['to']) : toHandleEncoding($training['unconsecutive_date']) ?>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>

            <tfoot>
                <tr>
                    <th class="align-middle" width="65%">Title of Division Training</th>
                    <th class="align-middle" width="35%">Conducted on</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>