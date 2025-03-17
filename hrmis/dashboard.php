<?php
// dts/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitleWithModal('Dashboard', uri() . '/modules/employees/save-employee-dialog.php', 'Add Employee', 'fa-plus');
?>

<div class="row mt-4">
    <?php
    card('Active Employees', customUri('hrmis', 'Active Employees'), 'fa-user-check', 'primary', $countActive);
    card('Retirable Employees', customUri('hrmis', 'Retirable Employees'), 'fa-user-clock', 'success', $countRetirable);
    card('Celebrant Employees', customUri('hrmis', 'Celebrant Employees'), 'fa-birthday-cake', 'info');
    card('Archived Employees', customUri('hrmis', 'Archived Employees'), 'fa-archive', 'warning');
    card('Districts', customUri('hrmis', 'Districts'), 'fa-map-marked-alt', 'danger', $districtCount);
    card('Schools', customUri('hrmis', 'Schools'), 'fa-school', 'secondary', $schoolCount);
    card('Sections', customUri('hrmis', 'Sections'), 'fa-map-signs', 'primary', $sectionCount);
    ?>
</div>

<script src="<?= uri() ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= uri() ?>/assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?= uri() ?>/assets/js/chart-custom.js"></script>

<div class="row">
    <div class="col-xl-3 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Gender</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="gender-pie-chart"></canvas>
                    <script>
                        generateDoughnutChart(<?= json_encode(fetchAllAssoc(employeeGender())) ?>, <?= json_encode(array('#02a3fe', '#ec49a6')) ?>, 'gender-pie-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employee Gender by Category</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="gender-comparative-bar-chart"></canvas>
                    <script>
                        generateComparativeBarChart(<?= json_encode(fetchAllAssoc(employeeGenderCategory())) ?>, <?= json_encode(array('#02a3fe', '#ec49a6')) ?>, 'gender-comparative-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Category</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="category-doughnut-chart"></canvas>
                    <script>
                        <?php $employeeCategory = employeeCategory() ?>
                        generatePieChart(<?= json_encode(fetchAllAssoc($employeeCategory)) ?>, generateColorPallete(<?= numRows($employeeCategory) ?>), 'category-doughnut-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Position</h6>

                    <div class="dropdown no-arrow">
                        <?php dropdownEllipsis() ?>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                            <?php linkDropdownItem(customUri('hrmis', 'Employees by Position'), 'View', 'fa-user');
                            linkDropdownItem(customUri('export', 'employee-positions'), 'Export', 'fa-file-excel') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="position-bar-chart"></canvas>
                    <script>
                        <?php $employeePositions = employeePosition() ?>
                        generateBarChart(<?= json_encode(fetchAllAssoc($employeePositions)) ?>, generateColorPallete(<?= numRows($employeePositions) ?>), 'position-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by District</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="district-polar-area-chart"></canvas>
                    <script>
                        <?php $districtEmployees = districtEmployee() ?>
                        generatePolarAreaChart(<?= json_encode(fetchAllAssoc($districtEmployees)) ?>, generateColorPallete(<?= numRows($districtEmployees) ?>), 'district-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Assignment</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="station-bar-chart"></canvas>
                    <script>
                        <?php $employeeStations = employeeStation() ?>
                        generateBarChart(<?= json_encode(fetchAllAssoc($employeeStations)) ?>, generateColorPallete(<?= numRows($employeeStations) ?>), 'station-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>