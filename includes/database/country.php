<?php
// includes/database/country.php
// tbl_country
// tbl_nationality
function countries()
{
    return query("SELECT id, country AS `name` FROM tbl_country ORDER BY country;");
}

function country($id)
{
    return query("SELECT id, country AS `name` FROM tbl_country WHERE id='{$id}';");
}

function nationalities()
{
    return query("SELECT id, nationality AS `name` FROM tbl_nationality ORDER BY nationality;");
}

function nationality($id)
{
    return query("SELECT id, nationality AS `name` FROM tbl_nationality WHERE id='{$id}';");
}
