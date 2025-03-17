<?php
// includes/database/utility.php
function stationName($id)
{
    $station = section($id, true);

    if (numRows($station) > 0) {
        return fetchAssoc($station)['name'];
    }

    $station = schoolByAlias($id);

    if (numRows($station) > 0) {
        return fetchAssoc($station)['name'];
    }

    $station = schoolById($id);

    if (numRows($station) > 0) {
        return fetchAssoc($station)['name'];
    }

    return $id;
}

function userName($id, $uppercase = false)
{
    $users = employee($id);

    if (numRows($users) > 0) {
        $user = fetchAssoc($users);
        $name = $uppercase ? strtoupper(toName($user['lname'], $user['fname'], $user['mname'], $user['ext'], true)) : toName($user['lname'], $user['fname'], $user['mname'], $user['ext'], true);
        return toString($user['btitle'], '', ' ') . $name . toString($user['atitle'], ', ');
    }

    return $id;
}

function pdsProgress($id)
{
    $progress = 15;
    $education = numRows(educationalBackgrounds($id));

    if ($education === 1) {
        $progress += 5;
    } elseif ($education === 2) {
        $progress += 15;
    } elseif ($education >= 3) {
        $progress += 25;
    }

    if (numRows(eligibilities($id)) > 0) {
        $progress += 25;
    }

    if (numRows(experiences($id)) > 0) {
        $progress += 20;
    }

    if (numRows(attendedTrainings($id)) > 0) {
        $progress += 15;
    }

    return $progress;
}
