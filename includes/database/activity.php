<?php
// includes/database/activity.php
// tbl_calendar_of_activity
function hasHoliday()
{
    return numRows(query("SELECT `No` FROM `tbl_calendar_of_activity` WHERE (`EndDate` >= CURDATE() AND `StartDate` <= CURDATE()) AND `isHoliday`=1;")) > 0;
}

function calendar()
{
    return query("SELECT `Activity` AS `activity`, `StartDate` AS `from`, `EndDate` AS `to`, isHoliday FROM `tbl_calendar_of_activity` WHERE `EndDate` >= CURDATE() ORDER BY `StartDate`;");
}
