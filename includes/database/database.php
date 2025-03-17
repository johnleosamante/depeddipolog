<?php
// include/database/database.php
try {
    set_error_handler($onError);
    $con = mysqli_connect(HOSTNAME, USER, PASSWORD, DATABASE);
} catch (Throwable $throwable) {
    redirect(uri() . '/oops');
} finally {
    restore_error_handler();
}

function connection()
{
    global $con;
    return $con;
}

function affectedRows()
{
    return mysqli_affected_rows(connection());
}

function query($query)
{
    return mysqli_query(connection(), $query);
}

function nonQuery($query)
{
    mysqli_query(connection(), $query);
}

function fetchAllAssoc($result)
{
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function fetchAssoc($result)
{
    return mysqli_fetch_assoc($result);
}

function fetchArray($result)
{
    return mysqli_fetch_array($result);
}

function numRows($result)
{
    return mysqli_num_rows($result);
}
