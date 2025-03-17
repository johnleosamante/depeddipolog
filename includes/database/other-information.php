<?php
// includes/database/other-information.php
// tbl_other_information
function otherInformation($id)
{
    return query("SELECT * FROM tbl_other_information WHERE Emp_ID='{$id}' LIMIT 1;");
}

function createOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $id)
{
    nonQuery("INSERT INTO tbl_other_information (hasthirddegree, hasfourthdegree, relateddetails, wasguilty, guiltydetails, wascharged, datefiled, casestatus, wasconvicted, convicteddetails, wasseparated, separateddetails, wascandidate, candidatedetails, resigned, resigneddetails, immigrant, immigrantcountry, isindigenous, indigenousspecify, isdifferentlyabled, differentlyabledspecify, issoloparent, soloparentspecify, Emp_ID) VALUES ({$hasThirdDegree}, {$hasFourthDegree}, '{$relatedDetails}', {$wasGuilty}, '{$guiltyDetails}', {$wasCharged}, '{$dateFiled}', '{$caseStatus}', {$wasConvicted}, '{$convictedDetails}', {$wasSeparated}, '{$separatedDetails}', {$wasCandidate}, '{$candidateDetails}', {$resigned}, '{$resignedDetails}', {$immigrant}, '{$immigrantCountry}', {$isIndigenous}, '{$indigenousSpecify}', {$isDifferentlyAbled}, '{$differentlyAbledSpecify}', {$isSoloParent}, '{$soloParentSpecify}', '{$id}');");
}

function updateOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $id)
{
    nonQuery("UPDATE tbl_other_information SET hasthirddegree={$hasThirdDegree}, hasfourthdegree={$hasFourthDegree}, relateddetails='{$relatedDetails}', wasguilty={$wasGuilty}, guiltydetails='{$guiltyDetails}', wascharged={$wasCharged}, datefiled='{$dateFiled}', casestatus='{$caseStatus}', wasconvicted={$wasConvicted}, convicteddetails='{$convictedDetails}', wasseparated={$wasSeparated}, separateddetails='{$separatedDetails}', wascandidate={$wasCandidate}, candidatedetails='{$candidateDetails}', resigned={$resigned}, resigneddetails='{$resignedDetails}', immigrant={$immigrant}, immigrantcountry='{$immigrantCountry}', isindigenous={$isIndigenous}, indigenousspecify='{$indigenousSpecify}', isdifferentlyabled={$isDifferentlyAbled}, differentlyabledspecify='{$differentlyAbledSpecify}', issoloparent={$isSoloParent}, soloparentspecify='{$soloParentSpecify}' WHERE Emp_ID='{$id}' LIMIT 1;");
}

function deleteOtherInformation($id)
{
    nonQuery("DELETE FROM tbl_other_information WHERE Emp_ID='{$id}';");
}
