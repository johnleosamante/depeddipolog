<?php
// export/retirable-employees.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
	require_once('../includes/function.php');
	redirect(uri() . '/login');
}
?>

<table>
	<thead>
		<tr>
			<th>#</th>
			<th>School/Office</th>
			<th>Employee ID</th>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Ext Name</th>
			<th>Sex</th>
			<th>Date of Birth</th>
			<th>Age</th>
			<th>Position</th>
			<th>GSIS CRN No.</th>
			<th>GSIS BP No.</th>
			<th>PAGIBIG ID No.</th>
			<th>PhilHealth ID No.</th>
			<th>SSS No.</th>
			<th>TIN No.</th>
			<th>Contact No.</th>
			<th>Email Address</th>
			<th>Residential Address</th>
		</tr>
	</thead>

	<tbody>
		<?php
		$i = 1;
		$rows = query("SELECT * FROM (SELECT tbl_employee.EmpNo AS id, tbl_employee.Emp_LName AS lname, tbl_employee.Emp_FName AS fname, tbl_employee.Emp_MName AS mname, tbl_employee.Emp_Extension AS ext, tbl_employee.Emp_Sex AS sex, tbl_employee.Emp_Month AS `bmonth`, tbl_employee.Emp_Day AS `bday`, tbl_employee.Emp_Year AS `byear`, YEAR(CURRENT_DATE) - CONVERT(tbl_employee.Emp_Year, DECIMAL) AS year_age, tbl_employee.Emp_GSIS AS crn, tbl_employee.Emp_GSIS_BP AS bp, tbl_employee.Emp_PAGIBIG AS pagibig, tbl_employee.Emp_PHILHEALTH AS philhealth, tbl_employee.Emp_SSS AS sss, tbl_employee.Emp_TIN AS tin, tbl_employee.Emp_Cell_No AS contact, tbl_employee.Emp_Email AS email, tbl_job.Job_description AS position, tbl_school.SchoolName AS school, tbl_employee.Emp_Res_Street AS street, tbl_employee.Emp_Res_Subdivision AS subdivision, tbl_employee.Emp_Res_Barangay AS barangay, tbl_employee. Emp_Res_City AS city, tbl_employee.Emp_Address AS province FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE Emp_Status='Active') AS retirables WHERE year_age >= 60 ORDER BY school, lname;");
		foreach ($rows as $row) : ?>
			<tr>
				<td><?= $i++ ?></td>
				<td><?= strtoupper($row['school']) ?></td>
				<td><?= $row['id'] ?></td>
				<td><?= strtoupper($row['lname']) ?></td>
				<td><?= strtoupper($row['fname']) ?></td>
				<td><?= strtoupper($row['mname']) ?></td>
				<td><?= strtoupper($row['ext']) ?></td>
				<td><?= strtoupper($row['sex'])[0] ?></td>
				<td><?= $row['byear'] . '-' . $row['bmonth'] . '-' . $row['bday'] ?></td>
				<td><?= getDateDifference($row['byear'], $row['bmonth'], $row['bday']) ?></td>
				</td>
				<td><?= strtoupper($row['position']) ?></td>
				<td><?= $row['crn'] ?></td>
				<td><?= $row['bp'] ?></td>
				<td><?= $row['pagibig'] ?></td>
				<td><?= $row['philhealth'] ?></td>
				<td><?= $row['sss'] ?></td>
				<td><?= $row['tin'] ?></td>
				<td><?= $row['contact'] ?></td>
				<td><?= strtolower($row['email']) ?></td>
				<td><?= strtoupper(toAddress('', $row['street'], $row['subdivision'], $row['barangay'], $row['city'], $row['province'])) ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>