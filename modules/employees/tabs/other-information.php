<?php
// modules/employees/tabs/other-information.php
$otherInformation = otherInformation($employeeId);
$hasThirdDegree = $hasFourthDegree = $wasGuilty = $wasCharged = $wasConvicted = $wasSeparated = $wasCandidate = $resigned = $immigrant = $isIndigenous = $isDifferentlyAbled = $isSoloParent = '0';
$relatedDetails = $guiltyDetails = $caseStatus = $convictedDetails = $separatedDetails = $candidateDetails = $resignedDetails = $immigrantCountry = $isIndigenousSpecify = $isDifferentlyAbledSpecify = $soloParentSpecify = '';
$dateFiled = '0001-01-01';

if (numRows($otherInformation) > 0) {
    $information = fetchAssoc($otherInformation);
    $hasThirdDegree = $information['hasthirddegree'];
    $hasFourthDegree = $information['hasfourthdegree'];
    $relatedDetails = $information['relateddetails'];
    $wasGuilty = $information['wasguilty'];
    $guiltyDetails = $information['guiltydetails'];
    $wasCharged = $information['wascharged'];
    $dateFiled = $wasCharged ? toDate($information['datefiled'], 'Y-m-d') : date('Y-m-d');
    $caseStatus = $information['casestatus'];
    $wasConvicted = $information['wasconvicted'];
    $convictedDetails = $information['convicteddetails'];
    $wasSeparated = $information['wasseparated'];
    $separatedDetails = $information['separateddetails'];
    $wasCandidate = $information['wascandidate'];
    $candidateDetails = $information['candidatedetails'];
    $resigned = $information['resigned'];
    $resignedDetails = $information['resigneddetails'];
    $immigrant = $information['immigrant'];
    $immigrantCountry = $information['immigrantcountry'];
    $isIndigenous = $information['isindigenous'];
    $isIndigenousSpecify = $information['indigenousspecify'];
    $isDifferentlyAbled = $information['isdifferentlyabled'];
    $isDifferentlyAbledSpecify = $information['differentlyabledspecify'];
    $isSoloParent = $information['issoloparent'];
    $soloParentSpecify = $information['soloparentspecify'];
}
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'other-information', 'show active') ?>" id="other-information">
    <?php if ($editMode) : ?>
        <form action="" method="POST">
        <?php endif ?>

        <div class="mt-3">
            <p class="mb-1">Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,</p>

            <ol type="a" class="mb-0 pl-3">
                <li>within the third degree?
                    <div class="py-1">
                        <input id="has-third-degree-yes" name="has-third-degree" type="radio" value="1" <?= setActiveItem($hasThirdDegree, '1', 'checked');
                                                                                                        echo !$editMode ? ' disabled' : '' ?>>
                        <label for="has-third-degree-yes" class="px-1 mr-3">Yes</label>

                        <input id="has-third-degree-no" name="has-third-degree" type="radio" value="0" <?= setActiveItem($hasThirdDegree, '0', 'checked');
                                                                                                        echo !$editMode ? ' disabled' : '' ?>>
                        <label for="has-third-degree-no" class="px-1">No</label>
                    </div>
                </li>

                <li>within the fourth degree (for Local Government Unit - Career Employees)?
                    <div class="py-1">
                        <input id="has-fourth-degree-yes" name="has-fourth-degree" type="radio" value="1" <?= setActiveItem($hasFourthDegree, '1', 'checked');
                                                                                                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="has-fourth-degree-yes" class="px-1 mr-3">Yes</label>

                        <input id="has-fourth-degree-no" name="has-fourth-degree" type="radio" value="0" <?= setActiveItem($hasFourthDegree, '0', 'checked');
                                                                                                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="has-fourth-degree-no" class="px-1">No</label>
                    </div>
                </li>
            </ol>

            <div class="form-group mb-0 pl-3">
                <label for="related-details" class="m-0">If YES, give details:</label>
                <input id="related-details" name="related-details" type="text" value="<?= $relatedDetails ?>" class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>></label>
            </div>
        </div>

        <hr class="my-4">

        <div>
            <ol type="a" class="pl-3 mb-0">
                <li>Have you ever been found guilty of any administrative offense?
                    <div class="py-1">
                        <input id="was-guilty-yes" name="was-guilty" type="radio" value="1" <?= setActiveItem($wasGuilty, '1', 'checked');
                                                                                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-guilty-yes" class="px-1 mr-3">Yes</label>

                        <input id="was-guilty-no" name="was-guilty" type="radio" value="0" <?= setActiveItem($wasGuilty, '0', 'checked');
                                                                                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-guilty-no" class="px-1">No</label>

                        <div class="form-group">
                            <label for="guilty-details" class="m-0">If YES, give details:</label>
                            <input id="guilty-details" name="guilty-details" type="text" value="<?= $guiltyDetails ?>" class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>

                <li>Have you been criminally charged before any court?
                    <div class="py-1">
                        <input id="was-charged-yes" name="was-charged" type="radio" value="1" <?= setActiveItem($wasCharged, '1', 'checked');
                                                                                                echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-charged-yes" class="px-1 mr-3">Yes</label>

                        <input id="was-charged-no" name="was-charged" type="radio" value="0" <?= setActiveItem($wasCharged, '0', 'checked');
                                                                                                echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-charged-no" class="px-1">No</label>

                        <div class="mb-1">If YES, give details:</div>

                        <div class="form-group mb-2">
                            <label for="date-filed" class="m-0">Date Filed:</label>
                            <input id="date-filed" name="date-filed" type="date" value="<?= $wasCharged ? $dateFiled : date('Y-m-d') ?>" class="form-control" title="Required field if YES" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>

                        <div class="form-group mb-0">
                            <label for="case-status" class="m-0">Status of Case/s:</label>
                            <input id="case-status" name="case-status" type="text" value="<?= $caseStatus ?>" class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <hr class="my-4">

        <div>
            <p class="mb-1">Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</p>

            <div class="pl-3">
                <input id="was-convicted-yes" name="was-convicted" type="radio" value="1" <?= setActiveItem($wasConvicted, '1', 'checked');
                                                                                            echo !$editMode ? ' disabled' : '' ?>>
                <label for="was-convicted-yes" class="px-1 mr-3">Yes</label>

                <input id="was-convicted-no" name="was-convicted" type="radio" value="0" <?= setActiveItem($wasConvicted, '0', 'checked');
                                                                                            echo !$editMode ? ' disabled' : '' ?>>
                <label for="was-convicted-no" class="px-1">No</label>

                <div class="form-group mb-0">
                    <label for="convicted-details" class="mb-0">If YES, give details:</label>
                    <input id="convicted-details" name="convicted-details" type="text" value="<?= $convictedDetails ?>" class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div>
            <p class="mb-1">Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</p>

            <div class="pl-3">
                <input id="was-separated-yes" name="was-separated" type="radio" value="1" <?= setActiveItem($wasSeparated, '1', 'checked');
                                                                                            echo !$editMode ? ' disabled' : '' ?>>
                <label for="was-separated-yes" class="px-1 mr-3">Yes</label>

                <input id="was-separated-no" name="was-separated" type="radio" value="0" <?= setActiveItem($wasSeparated, '0', 'checked');
                                                                                            echo !$editMode ? ' disabled' : '' ?>>
                <label for="was-separated-no" class="px-1">No</label>

                <div class="form-group mb-0">
                    <label for="separated-details" class="mb-0">If YES, give details:</label>
                    <input id="separated-details" name="separated-details" type="text" value="<?= $separatedDetails ?>" class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div>
            <ol type="a" class="pl-3 mb-0">
                <li>Have you ever been a candidate in a national or local election (except Barangay election)?
                    <div class="my-1">
                        <input id="was-candidate-yes" name="was-candidate" type="radio" value="1" <?= setActiveItem($wasCandidate, '1', 'checked');
                                                                                                    echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-candidate-yes" class="px-1 mr-3">Yes</label>

                        <input id="was-candidate-no" name="was-candidate" type="radio" value="0" <?= setActiveItem($wasCandidate, '0', 'checked');
                                                                                                    echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-candidate-no" class="px-1">No</label>

                        <div class="form-group">
                            <label for="candidate-details" class="m-0">If YES, give details:</label>
                            <input id="candidate-details" name="candidate-details" type="text" value="<?= $candidateDetails ?>" class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>

                <li>Have you resigned from the government service during the three (3)-month period the last election to promote/actively campaign for a national or local candidate?
                    <div class="my-1">
                        <input id="resigned-yes" name="resigned" type="radio" value="1" <?= setActiveItem($resigned, '1', 'checked');
                                                                                        echo !$editMode ? ' disabled' : '' ?>>
                        <label for="resigned-yes" class="px-1 mr-3">Yes</label>

                        <input id="resigned-no" name="resigned" type="radio" value="0" <?= setActiveItem($resigned, '0', 'checked');
                                                                                        echo !$editMode ? ' disabled' : '' ?>>
                        <label for="resigned-no" class="px-1">No</label>

                        <div class="form-group mb-0">
                            <label for="resigned-details" class="m-0">If YES, give details:</label>
                            <input id="resigned-details" name="resigned-details" type="text" value="<?= $resignedDetails ?>" class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <hr class="my-4">

        <div>
            <p class="mb-1">Have you acquired the status of an immigrant or permanent resident of another country?</p>

            <div class="pl-3">
                <input id="immigrant-yes" name="immigrant" type="radio" value="1" <?= setActiveItem($immigrant, '1', 'checked');
                                                                                    echo !$editMode ? ' disabled' : '' ?>>
                <label for="immigrant-yes" class="px-1 mr-3">Yes</label>

                <input id="immigrant-no" name="immigrant" type="radio" value="0" <?= setActiveItem($immigrant, '0', 'checked');
                                                                                    echo !$editMode ? ' disabled' : '' ?>>
                <label for="immigrant-no" class="px-1">No</label>

                <div class="form-group mb-0">
                    <label for="immigrant-country" class="m-0">If YES, give details (country):</label>
                    <?php if (!$editMode) : ?>
                        <?php
                        $immigrantCountryName = 'N/A';
                        $immigrantCountries = country($immigrantCountry);
                        if (numRows($immigrantCountries) > 0) {
                            $immigrantCountry = fetchAssoc($immigrantCountries);
                            $immigrantCountryName = $immigrantCountry['name'];
                        }
                        ?>
                        <input id="immigrant-country" name="immigrant-country" type="text" value="<?= $immigrantCountryName ?>" class="form-control" title="Leave N/A if NO" readonly>
                    <?php else : ?>
                        <select class="form-control" id="immigrant-country" name="immigrant-country" title="Leave N/A if NO">
                            <option value="">N/A</option>
                            <?php $countries = countries();
                            while ($country = fetchAssoc($countries)) : ?>
                                <option value="<?= $country['id'] ?>" <?= setOptionSelected($country['id'], $immigrantCountry) ?>><?= $country['name'] ?></option>
                            <?php endwhile ?>
                        </select>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="mb-3">
            <p class="mb-1">Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972); please answer the following items:</p>

            <ol type="a" class="mb-0 pl-3">
                <li>Are you a member of any indigenous group?
                    <div class="my-1">
                        <input id="is-indigenous-yes" name="is-indigenous" type="radio" value="1" <?= setActiveItem($isIndigenous, '1', 'checked');
                                                                                                    echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-indigenous-yes" class="px-1 mr-3">Yes</label>

                        <input id="is-indigenous-no" name="is-indigenous" type="radio" value="0" <?= setActiveItem($isIndigenous, '0', 'checked');
                                                                                                    echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-indigenous-no" class="px-1">No</label>

                        <div class="form-group mb-0">
                            <label for="indigenous-specify" class="m-0">If YES, please specify:</label>
                            <input id="indigenous-specify" name="indigenous-specify" type="text" value="<?= $isIndigenousSpecify ?>" title="Leave blank if NO" class="form-control" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>
                <li>Are you differently abled?
                    <div class="my-1">
                        <input id="is-differently-abled-yes" name="is-differently-abled" type="radio" value="1" <?= setActiveItem($isDifferentlyAbled, '1', 'checked');
                                                                                                                echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-differently-abled-yes" class="px-1 mr-3">Yes</label>

                        <input id="is-differently-abled-no" name="is-differently-abled" type="radio" value="0" <?= setActiveItem($isDifferentlyAbled, '0', 'checked');
                                                                                                                echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-differently-abled-no" class="px-1">No</label>

                        <div class="form-group mb-0">
                            <label for="differently-abled-specify" class="m-0">If YES, please specify ID No:</label>
                            <input id="differently-abled-specify" name="differently-abled-specify" type="text" value="<?= $isDifferentlyAbledSpecify ?>" title="Leave blank if NO" class="form-control" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>
                <li>Are you a solo parent?
                    <div class="my-1">
                        <input id="is-solo-parent-yes" name="is-solo-parent" type="radio" value="1" <?= setActiveItem($isSoloParent, '1', 'checked');
                                                                                                    echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-solo-parent-yes" class="px-1 mr-3">Yes</label>

                        <input id="is-solo-parent-no" name="is-solo-parent" type="radio" value="0" <?= setActiveItem($isSoloParent, '0', 'checked');
                                                                                                    echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-solo-parent-no" class="px-1">No</label>

                        <div class="form-group mb-0">
                            <label for="solo-parent-specify" class="m-0">If YES, please specify ID No:</label>
                            <input id="solo-parent-specify" name="solo-parent-specify" type="text" value="<?= $soloParentSpecify ?>" class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <?php if ($editMode) : ?>
            <div class="form-group mb-3">
                <input type="hidden" name="verifier" value="<?= cipher($employeeId) ?>">
                <button class="btn btn-primary btn-block" name="update-other-information"><i class="fas fa-save fa-fw"></i>Update Other Information</button>
            </div>
        </form>
    <?php endif ?>
</div>