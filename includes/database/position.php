<?php
// includes/database/position.php
// tbl_job
// tbl_station
function position($id)
{
    return query("SELECT tbl_station.Emp_ID AS `user`, tbl_station.Emp_DOA AS `date`, tbl_station.Emp_Position AS position_id, tbl_job.Job_description AS `position`, tbl_station.Emp_Station AS station_id, tbl_school.SchoolName AS station FROM (`tbl_station` INNER JOIN tbl_job ON tbl_job.Job_code = tbl_station.Emp_Position) INNER JOIN `tbl_school` ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_station.Emp_ID='{$id}' ORDER BY `position` DESC LIMIT 1;");
}

function positions($id = null)
{
    $filter = $id === null ? '' : "WHERE Job_code='{$id}'";
    return query("SELECT Job_code AS id, Job_description AS position, Job_Category AS category, Salary_Grade AS salary_grade FROM tbl_job {$filter} ORDER BY Job_description ASC;");
}

function positionCategories()
{
    return query("SELECT Job_Category AS `category` FROM tbl_job GROUP BY Job_Category ORDER BY Job_Category;");
}

function positionsByCategory($category)
{
    return query("SELECT Job_code AS id, Job_description AS position, Job_Category AS category FROM tbl_job WHERE Job_Category='{$category}' ORDER BY salary_grade DESC, Job_description ASC;");
}
