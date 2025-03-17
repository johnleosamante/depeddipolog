<?php
// hrtdms/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitleWithModal('Dashboard', uri() . '/modules/trainings/save-training-dialog.php', 'Add Training', 'fa-plus');
?>

<div class="row mt-4">
	<?php
	card('Scheduled Trainings', customUri('hrtdms', 'Scheduled Trainings'), 'fa-calendar-alt', 'primary', $countScheduled);
	card('Conducted Trainings', customUri('hrtdms', 'Conducted Trainings'), 'fa-chalkboard-teacher', 'success');
	card('Employees', customUri('hrtdms', 'Employees'), 'fa-users', 'info', $countActive);
	card('Districts', customUri('hrtdms', 'Districts'), 'fa-map-marked-alt', 'warning', $districtCount);
	card('Schools', customUri('hrtdms', 'Schools'), 'fa-school', 'danger', $schoolCount);
	card('Sections', customUri('hrtdms', 'Sections'), 'fa-map-signs', 'secondary', $sectionCount);
	?>
</div>

<script src="<?= uri() ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= uri() ?>/assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?= uri() ?>/assets/js/chart-custom.js"></script>

<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
		<div class="card shadow">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary text-uppercase">Conducted Trainings</h6>
			</div>
			<div class="card-body">
				<div class="chart-bar h-auto">
					<canvas id="conducted-trainings-bar-chart"></canvas>
					<script>
						<?php $conductedTrainingByYear = conductedTrainingsByYear() ?>
						generateBarChart(<?= json_encode(fetchAllAssoc($conductedTrainingByYear)) ?>, generateColorPallete(<?= numRows($conductedTrainingByYear) ?>), 'conducted-trainings-bar-chart');
					</script>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
		<div class="card shadow">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary text-uppercase">Trained Employees</h6>
			</div>
			<div class="card-body">
				<div class="chart-bar h-auto">
					<canvas id="trained-employees-bar-chart"></canvas>
					<script>
						<?php $trainedEmployeesByYear = trainedEmployeesByYear() ?>
						generateBarChart(<?= json_encode(fetchAllAssoc($trainedEmployeesByYear)) ?>, generateColorPallete(<?= numRows($trainedEmployeesByYear) ?>), 'trained-employees-bar-chart');
					</script>
				</div>
			</div>
		</div>
	</div>
</div>