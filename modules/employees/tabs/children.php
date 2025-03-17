<?php
// modules/employees/tabs/children.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'children', 'show active') ?>" id="children">
	<?php if ($editMode) : ?>
		<div class="d-sm-flex justify-content-end my-3">
			<?php modalButtonSplit(uri() . '/modules/employees/save/save-child-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Child', 'primary') ?>
		</div>
	<?php endif ?>

	<div class="row my-3">
		<div class="col table-responsive">
			<table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center" cellspacing="0">
				<thead>
					<tr>
						<th class="align-middle" width="70%">Name of Child</th>
						<th class="align-middle" width="30%">Date of Birth</th>
						<?php if ($editMode) : ?>
							<th class="align-middle" width="5%">Action</th>
						<?php endif ?>
					</tr>
				</thead>

				<tbody>
					<?php
					$children = children($employeeId);

					if (numRows($children) > 0) {
						while ($child = fetchAssoc($children)) : ?>
							<tr class="text-uppercase">
								<td class="align-middle"><?= toName($child['last'], $child['first'], $child['middle'], $child['ext'], true) ?></td>
								<td class="align-middle"><?= toDate($child['dob']) ?></td>
								<?php if ($editMode) : ?>
									<td class="align-middle text-capitalize">
										<div class="dropdown no-arrow">
											<?php dropdownEllipsis() ?>
											<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
												<?php modalDropdownItem(uri() . '/modules/employees/save/save-child-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($child['no']), 'Edit', 'fa-edit', 'Edit Child');
												modalDropdownItem(uri() . '/modules/employees/save/save-child-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($child['no']), 'Copy', 'fa-copy', 'Copy Child') ?>
												<div class="dropdown-divider"></div>
												<?php modalDropdownItem(uri() . '/modules/employees/delete/delete-child-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($child['no']), 'Delete', 'fa-trash', 'Delete Child') ?>
											</div>
										</div>
									</td>
								<?php endif ?>
							</tr>
						<?php endwhile;
					} else { ?>
						<tr>
							<td colspan="<?= $editMode ? '3' : '2' ?>" class="align-middle">No data available in table</td>
						</tr>
					<?php } ?>
				</tbody>

				<tfoot>
					<tr>
						<th class="align-middle" width="70%">Name of Child</th>
						<th class="align-middle" width="30%">Date of Birth</th>
						<?php if ($editMode) : ?>
							<th class="align-middle" width="5%">Action</th>
						<?php endif ?>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>