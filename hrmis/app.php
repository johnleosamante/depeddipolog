<?php
// hrmis/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrmis';
$page = $appTitle = 'Human Resource Management Information System';

if (!isset($userId)) {
    redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
    redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('hrmis', 'Employee Search', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['add-employee'])) {
    $employeeId = getDatetimeAsId();
    $lname = sanitize($_POST['lname']);
    $fname = sanitize($_POST['fname']);
    $mname = sanitize($_POST['mname']);
    $ext = sanitize($_POST['ext']);
    $sex = sanitize($_POST['sex']);
    $bdate = strtotime(sanitize($_POST['bdate']));
    $bmonth = date('m', $bdate);
    $bday = date('d', $bdate);
    $byear = date('Y', $bdate);
    $ePositionId = sanitize($_POST['position']);
    $eStationId = sanitize($_POST['station']);
    $email = sanitize($_POST['email']);
    $mobile = sanitize($_POST['mobile']);
    $image = 'assets/img/user.png';
    $status = sanitize($_POST['status']);
    $showAlert = true;
    $employee = toName($lname, $fname, $mname, $ext, true);
    $success = false;
    $today = date('Y-m-d');

    if (!isValidEmail($email, 'deped.gov.ph')) {
        $message = 'The DepEd Email Address you entered is invalid! Operation has been cancelled.';
        return;
    }

    $names = employeeName($lname, $fname, $mname, $ext);

    if (numRows($names) > 0) {
        $name = fetchAssoc($names);
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $name['id']) . '" title="View ' . $employee . ' employee information">' . strtoupper($employee) . '</a>] already exist!  Operation has been cancelled.';
        return;
    }

    createEmployee($employeeId, $lname, $fname, $mname, $ext, $sex, $bmonth, $bday, $byear, $email, $mobile, $image, $status);
    createFamily('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $employeeId);
    createOtherInformation(0, 0, '', 0, '', 0, '0000-00-00', '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', $employeeId);
    createStation($today, $eStationId, $ePositionId, $employeeId);
    $sg = fetchAssoc(positions($ePositionId))['salary_grade'];
    createPsipop('', 'Permanent', $today, $today, '', $employeeId);
    createStepIncrement($today, '1', $sg, $employeeId);

    createIdentification('', '', '', $today, $employeeId);
    createAccount($employeeId, hashPassword(generateStrongRandomPassword()));

    if (affectedRows()) {
        $success = true;
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . $employee . ' employee information">' . strtoupper($employee) . '</a>] was saved successfully.';

        createSystemLog($stationId, $userId, 'Registered employee', $employeeId, clientIp());
    } else {
        $message = 'Employee was not saved successfully.';
    }
}

if (isset($_POST['update-personal-information'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $employeePhoto = isset($_POST['image-verifier']) ? sanitize(decipher($_POST['image-verifier'])) : $defaultImage;
    $ext = null;
    $showAlert = true;
    $success = false;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'personal-information';

    if (is_uploaded_file($_FILES['image-upload']['tmp_name'])) {
        $temp = $_FILES['image-upload']['tmp_name'];

        if ($_FILES['image-upload']['size'] > $imageUploadSizeLimit) {
            $message = 'The chosen file exceeds the upload file limit (2.5 MB). No changes have been made to personal information.';
            return;
        }

        $mimeType = mime_content_type($temp);
        $allowedFileTypes = ['image/png', 'image/jpeg'];

        if (!in_array($mimeType, $allowedFileTypes)) {
            $message = 'The chosen file is not an image file. No changes have been made to personal information.';
            return;
        }

        $ext = pathinfo($_FILES['image-upload']['name'], PATHINFO_EXTENSION);

        if (!empty($employeePhoto) && file_exists(root() . '/' . $employeePhoto) && basename(root() . '/' . $employeePhoto) !== 'user.png') {
            unlink(root() . '/' . $employeePhoto);
        }

        $uploadDate = date('YmdHis');

        $employeePhoto = "uploads/images/{$employeeId}/{$employeeId}{$uploadDate}.{$ext}";

        move_uploaded_file($temp, '../' . $employeePhoto);
    }

    $dob = isset($_POST['dob']) ? strtotime($_POST['dob']) : strtotime(date('Y-m-d'));
    $byear = date("Y", $dob);
    $bmonth = date("m", $dob);
    $bday = date("d", $dob);
    $email = sanitize($_POST['email']);

    updateEmployee(sanitize($_POST['lname']), sanitize($_POST['fname']), sanitize($_POST['mname']), sanitize($_POST['ext']), $bmonth, $bday, $byear, sanitize($_POST['pob']), sanitize($_POST['sex']), sanitize($_POST['civil-status']), sanitize($_POST['civil-status-specify']), sanitize($_POST['citizenship']), sanitize($_POST['dual-citizenship']), sanitize($_POST['dual-citizenship-country']), sanitize($_POST['rlot']), sanitize($_POST['rstreet']), sanitize($_POST['rsubdivision']), sanitize($_POST['rbarangay']), sanitize($_POST['rcity']), sanitize($_POST['rprovince']), sanitize($_POST['rzip']), sanitize($_POST['plot']), sanitize($_POST['pstreet']), sanitize($_POST['psubdivision']), sanitize($_POST['pbarangay']), sanitize($_POST['pcity']), sanitize($_POST['pprovince']), sanitize($_POST['pzip']), sanitize($_POST['height']), sanitize($_POST['weight']), sanitize($_POST['blood-type']), sanitize($_POST['crn']), sanitize($_POST['bp']), sanitize($_POST['pagibig']), sanitize($_POST['philhealth']), sanitize($_POST['sss']), sanitize($_POST['telephone']), sanitize($_POST['mobile']), $email, sanitize($_POST['tin']), sanitize($_POST['agency-id']), $employeePhoto, $employeeId);

    if (!affectedRows()) {
        $message = 'No changes have been made to personal information.';
        return;
    }

    $message = 'Personal information has been updated successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Updated employee personal information', $employeeId, clientIp());
}

if (isset($_POST['update-family-background'])) {
    $employeeId = sanitize(decipher($_POST['verifier']));
    $slast = sanitize($_POST['slast']);
    $sfirst = sanitize($_POST['sfirst']);
    $sext = sanitize($_POST['sext']);
    $smiddle = sanitize($_POST['smiddle']);
    $swork = sanitize($_POST['swork']);
    $sbusiness = sanitize($_POST['sbusiness']);
    $sbusinessAddress = sanitize($_POST['sbusiness-address']);
    $stelephone = sanitize($_POST['stelephone']);
    $flast = sanitize($_POST['flast']);
    $ffirst = sanitize($_POST['ffirst']);
    $fext = sanitize($_POST['fext']);
    $fmiddle = sanitize($_POST['fmiddle']);
    $mlast = sanitize($_POST['mlast']);
    $mfirst = sanitize($_POST['mfirst']);
    $mmiddle = sanitize($_POST['mmiddle']);
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'family-background';

    if (numRows(family($employeeId)) === 0) {
        createFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId);
    } else {
        updateFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId);
    }

    if (affectedRows()) {
        $message = 'Family background has been updated successfully.';

        createSystemLog($stationId, $userId, 'Updated employee family background', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to family background.';
        $success = false;
    }
}

if (isset($_POST['save-child'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $childId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $clast = sanitize($_POST['clast']);
    $cfirst = sanitize($_POST['cfirst']);
    $cext = sanitize($_POST['cext']);
    $cmiddle = sanitize($_POST['cmiddle']);
    $cdob = sanitize($_POST['cdob']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';

    if (numRows(child($employeeId, $childId)) === 0) {
        createChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId);

        $logMessage = 'Added employee child';
        $message = 'Child has been added successfully.';
    } else {
        updateChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId, $childId);

        $logMessage = 'Updated employee child';
        $message = 'Child has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to children.';
        $success = false;
    }
}

if (isset($_POST['delete-child'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $childId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';

    deleteChild($employeeId, $childId);

    if (affectedRows()) {
        $message = 'Child has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee child', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to children.';
        $success = false;
    }
}

if (isset($_POST['save-education'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $educationId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $level = sanitize($_POST['level']);
    $school = sanitize($_POST['school']);
    $course = sanitize($_POST['course']);
    $from = sanitize($_POST['from']);
    $to = sanitize($_POST['to']);
    $isPresent = isset($_POST['is-present']) ? '1' : '0';
    $highest = sanitize($_POST['highest']);
    $year = $isPresent ? null : sanitize($_POST['year']);
    $scholarship = sanitize($_POST['scholarship']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'educational-background';

    if (empty($educationId)) {
        createEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId);

        $logMessage = 'Added employee education';
        $message = 'Educational background has been added successfully.';
    } else {
        updateEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId, $educationId);

        $logMessage = 'Updated employee education';
        $message = 'Educational background has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to educational background.';
        $success = false;
    }
}

if (isset($_POST['delete-education'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $educationId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'educational-background';

    deleteEducation($employeeId, $educationId);

    if (affectedRows()) {
        $message = 'Educational background has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee education', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to educational background.';
        $success = false;
    }
}

if (isset($_POST['save-eligibility'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $eligibilityId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $career = sanitize($_POST['career']);
    $rating = sanitize($_POST['rating']);
    $examDate = sanitize($_POST['exam-date']);
    $examPlace = sanitize($_POST['exam-place']);
    $license = sanitize($_POST['license']);
    $isApplicable = isset($_POST['is-applicable']) ? '1' : '0';
    $validity = sanitize($_POST['validity']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'civil-service-eligibility';

    if (empty($eligibilityId)) {
        createEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId);

        $logMessage = 'Added employee eligibility';
        $message = 'Civil service eligibility has been added successfully.';
    } else {
        updateEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId, $eligibilityId);

        $logMessage = 'Updated employee eligibility';
        $message = 'Civil service eligibility has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to civil service eligibility.';
        $success = false;
    }
}

if (isset($_POST['delete-eligibility'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $eligibilityId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'civil-service-eligibility';

    deleteEligibility($employeeId, $eligibilityId);

    if (affectedRows()) {
        $message = 'Civil service eligibility has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee eligibility', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to civil service eligibility.';
    }
}

if (isset($_POST['save-voluntary-work'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $voluntaryId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $organization = sanitize($_POST['organization']);
    $from = sanitize($_POST['from']);
    $isPresent = isset($_POST['is-present']) ? '1' : '0';
    $to = sanitize($_POST['to']);
    $hours = isset($_POST['hours']) ? $_POST['hours'] : 0;
    $position = sanitize($_POST['position']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';

    if (empty($voluntaryId)) {
        createVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId);

        $logMessage = 'Added employee voluntary work';
        $message = 'Voluntary work has been added successfully.';
    } else {
        updateVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId, $voluntaryId);

        $logMessage = 'Updated employee voluntary work';
        $message = 'Voluntary work has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to voluntary work.';
        $success = false;
    }
}

if (isset($_POST['delete-voluntary-work'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $voluntaryId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';

    deleteVoluntaryWork($employeeId, $voluntaryId);

    if (affectedRows()) {
        $message = 'Voluntary work has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee voluntary work', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to voluntary work.';
        $success = false;
    }
}

if (isset($_POST['save-special-skill'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $skillId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $skill = sanitize($_POST['skill']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';

    if (empty($skillId)) {
        createSpecialSkill($skill, $employeeId);

        $logMessage = 'Added employee special skill';
        $message = 'Special skill / hobby has been added successfully.';
    } else {
        updateSpecialSkill($skill, $employeeId, $skillId);

        $logMessage = 'Updated employee special skill';
        $message = 'Special skill / hobby has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to special skill / hobby.';
        $success = false;
    }
}

if (isset($_POST['delete-special-skill'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $skillId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';

    deleteSpecialSkill($employeeId, $skillId);

    if (affectedRows()) {
        $message = 'Special skill / hobby has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee special skill', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to special skill / hobby.';
        $success = false;
    }
}

if (isset($_POST['save-recognition'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $recognitionId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $recognition = sanitize($_POST['recognition']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';

    if (empty($recognitionId)) {
        createRecognition($recognition, $employeeId);

        $logMessage = 'Added employee recognition';
        $message = 'Non-academic distinction / recognition has been added successfully.';
    } else {
        updateRecognition($recognition, $employeeId, $recognitionId);

        $logMessage = 'Updated employee recognition';
        $message = 'Non-academic distinction / recognition has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to non-academic distinction / recognition.';
        $success = false;
    }
}

if (isset($_POST['delete-recognition'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $recognitionId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';

    deleteRecognition($employeeId, $recognitionId);

    if (affectedRows()) {
        $message = 'Non-academic distinction / recognition has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee recognition', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to non-academic distinction / recognition.';
        $success = false;
    }
}

if (isset($_POST['save-membership'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $membershipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $membership = sanitize($_POST['membership']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';

    if (empty($membershipId)) {
        createMembership($membership, $employeeId);

        $logMessage = 'Added employee membership';
        $message = 'Membership in Association / Organization has been added successfully.';
    } else {
        updateMembership($membership, $employeeId, $membershipId);

        $logMessage = 'Updated employee membership';
        $message = 'Membership in association / organization has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to membership in association / organization.';
        $success = false;
    }
}

if (isset($_POST['delete-membership'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $membershipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';

    deleteMembership($employeeId, $membershipId);

    if (affectedRows()) {
        $message = 'Membership in association / organization has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee membership', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to membership in association / organization.';
        $success = false;
    }
}

if (isset($_POST['update-other-information'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $hasThirdDegree = sanitize($_POST['has-third-degree']);
    $hasFourthDegree = sanitize($_POST['has-fourth-degree']);
    $relatedDetails = $hasFourthDegree ? sanitize($_POST['related-details']) : 'N/A';
    $wasGuilty = sanitize($_POST['was-guilty']);
    $guiltyDetails = $wasGuilty ? sanitize($_POST['guilty-details']) : 'N/A';
    $wasCharged = sanitize($_POST['was-charged']);
    $dateFiled = sanitize($_POST['date-filed']);
    $caseStatus = $wasCharged ? sanitize($_POST['case-status']) : 'N/A';
    $wasConvicted = sanitize($_POST['was-convicted']);
    $convictedDetails = $wasConvicted ? sanitize($_POST['convicted-details']) : 'N/A';
    $wasSeparated = sanitize($_POST['was-separated']);
    $separatedDetails = $wasSeparated ? sanitize($_POST['separated-details']) : 'N/A';
    $wasCandidate = sanitize($_POST['was-candidate']);
    $candidateDetails = $wasCandidate ? sanitize($_POST['candidate-details']) : 'N/A';
    $resigned = sanitize($_POST['resigned']);
    $resignedDetails = $resigned ? sanitize($_POST['resigned-details']) : 'N/A';
    $immigrant = sanitize($_POST['immigrant']);
    $immigrantCountry = $immigrant ? sanitize($_POST['immigrant-country']) : 'N/A';
    $isIndigenous = sanitize($_POST['is-indigenous']);
    $indigenousSpecify = $isIndigenous ? sanitize($_POST['indigenous-specify']) : 'N/A';
    $isDifferentlyAbled = sanitize($_POST['is-differently-abled']);
    $differentlyAbledSpecify = $isDifferentlyAbled ? sanitize($_POST['differently-abled-specify']) : 'N/A';
    $isSoloParent = sanitize($_POST['is-solo-parent']);
    $soloParentSpecify = $isSoloParent ? sanitize($_POST['solo-parent-specify']) : 'N/A';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'other-information';

    if (numRows(otherInformation($employeeId)) === 0) {
        createOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId);
    } else {
        updateOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId);
    }

    if (affectedRows()) {
        $message = 'Other information has been updated successfully.';

        createSystemLog($stationId, $userId, 'Updated employee other information', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to other information.';
        $success = false;
    }
}

if (isset($_POST['save-reference'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $referenceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $name = sanitize($_POST['name']);
    $address = sanitize($_POST['address']);
    $contact = sanitize($_POST['telephone']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';

    if (empty($referenceId)) {
        createReference($name, $address, $contact, $employeeId);

        $logMessage = 'Added employee reference';
        $message = 'Reference has been added successfully.';
    } else {
        updateReference($name, $address, $contact, $employeeId, $referenceId);

        $logMessage = 'Updated employee reference';
        $message = 'Reference has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to reference.';
        $success = false;
    }
}

if (isset($_POST['delete-reference'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $referenceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';

    deleteReference($employeeId, $referenceId);

    if (affectedRows()) {
        $message = 'Reference has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee reference', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to reference.';
        $success = false;
    }
}

if (isset($_POST['reassign-employee'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $positions = position($employeeId);

    $positionId = numRows($positions) > 0 ? fetchAssoc($positions)['position_id'] : '';
    $eStationId = sanitize($_POST['assignment']);
    $date = sanitize($_POST['assignment-date']);

    if (empty($employeeId) || empty($positionId) || empty($eStationId) || empty($date)) {
        return;
    }

    $showAlert = true;

    if (numRows(user($employeeId)) > 0) {
        deleteUserRoles($employeeId);
    }

    if (numRows(station($employeeId)) === 0) {
        createStation($date, $eStationId, $positionId, $employeeId);
    } else {
        updateEmployeeStatus('Active', $employeeId);
        updateStation($date, $eStationId, $positionId, $employeeId);
    }

    if (affectedRows()) {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been reassigned successfully to [<a href="' . customUri('hrmis', 'School Information', $eStationId) . '" title="View ' . stationName($eStationId) . ' information">' . strtoupper(stationName($eStationId)) . '</a>].';

        createSystemLog($stationId, $userId, 'Reassigned employee', $employeeId, clientIp());
    } else {
        $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] assignment has been made.';
        $success = false;
    }
}

if (isset($_POST['promote-employee'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $positionId = sanitize($_POST['position']);
    $position = strtoupper(fetchAssoc(positions($positionId))['position']);
    $stations = station($employeeId);
    $eStationId = '';

    if (numRows($stations) > 0) {
        $station = fetchAssoc($stations);
        $eStationId = $station['station_id'];
    }

    $datePromoted = sanitize($_POST['effectivity-date']);

    if (empty($employeeId) || empty($positionId) || empty($eStationId) || empty($datePromoted)) {
        return;
    }

    $showAlert = true;

    $psipops = psipop($employeeId);
    $status = $doa = $eligibility = null;

    if (numRows($psipops) > 0) {
        $psipop = fetchAssoc($psipops);
        $status = $psipop['status'];
        $doa = $psipop['original_appointment'] ?? date('Y-m-d');
        $eligibility = $psipop['eligibility'];
        updatePsipop('', $status, $doa, $datePromoted, $eligibility, $employeeId);
    }

    if (numRows(getEmployeeStepIncrement($employeeId)) > 0) {
        $sg = fetchAssoc(positions($positionId))['salary_grade'];
        updateStepIncrement($datePromoted, '1', $sg, $employeeId);
    }

    if (numRows(station($employeeId)) === 0) {
        createStation($datePromoted, $eStationId, $positionId, $employeeId);
    } else {
        updateEmployeeStatus('Active', $employeeId);
        updateStation($datePromoted, $eStationId, $positionId, $employeeId);
    }

    if (affectedRows()) {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been promoted successfully to [' . $position . '].';

        createSystemLog($stationId, $userId, 'Promoted employee', $employeeId, clientIp());
    } else {
        $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
        $success = false;
    }
}

if (isset($_POST['remove-employee'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $reason = sanitize($_POST['reason']);
    $showAlert = true;

    if (empty($employeeId) || empty($reason)) {
        return;
    }

    if (numRows(employee($employeeId)) > 0) {
        updateEmployeeStatus($reason, $employeeId);
    }

    if (affectedRows()) {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been removed successfully.';

        createSystemLog($stationId, $userId, 'Removed employee', $employeeId, clientIp());
    } else {
        $message = 'No changes to employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] status has been made.';
        $success = false;
    }
}

if (isset($_POST['set-school-head'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $schoolId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;

    if (numRows(employee($employeeId)) > 0) {
        updateSchoolHead($schoolId, $employeeId);
    }

    if (affectedRows()) {
        $success = true;
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been successfully set as school head of [<a href="#" title="View ' . stationName($schoolId) . ' school information">' . strtoupper(stationName($schoolId)) . '</a>].';

        createSystemLog($stationId, $userId, 'Set School Head', $employeeId, clientIp());
    } else {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] was not set as school head of [<a href="#" title="View ' . stationName($schoolId) . ' school information">' . strtoupper(stationName($schoolId)) . '</a>].';
        $success = false;
    }
}

if (isset($_POST['save-service-record'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $serviceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $from = sanitize($_POST['from']);
    $isPresent = isset($_POST['is-present']) ? '1' : '0';
    $to = sanitize($_POST['to']);
    $position = sanitize($_POST['position']);
    $positionCode = sanitize($_POST['position-code']);
    $status = sanitize($_POST['status']);
    $isGovernment = sanitize($_POST['is-government']);
    $sg = sanitize($_POST['sg-step']);
    $salary = isset($_POST['salary']) ? sanitize($_POST['salary']) : '0';
    $station = sanitize($_POST['station']);
    $stationAlias = sanitize($_POST['station-alias']);
    $leaveDates = sanitize($_POST['leave']);
    $isSeparation = isset($_POST['is-separation']) ? '1' : '0';
    $separationDate = $separationCause = null;
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'work-experience';

    if ($isSeparation === '1') {
        $separationDate = sanitize($_POST['separation-date']);
        $separationCause = sanitize($_POST['separation-cause']);
    }

    if (empty($serviceId)) {
        createExperience($from, $to, $isPresent, $position, $positionCode, $status, $isGovernment, $sg, $salary, $station, $stationAlias, $leaveDates, $isSeparation, $separationDate, $separationCause, $employeeId);

        $logMessage = 'Added service record';
        $message = 'Service record has been added successfully.';
    } else {
        updateExperience($from, $to, $isPresent, $position, $positionCode, $status, $isGovernment, $sg, $salary, $station, $stationAlias, $leaveDates, $isSeparation, $separationDate, $separationCause, $employeeId, $serviceId);

        $logMessage = 'Updated service record';
        $message = 'Service record has been updated successfully.';
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to service record.';
        $success = false;
    }
}

if (isset($_POST['delete-service-record'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $serviceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'work-experience';

    deleteExperience($employeeId, $serviceId);

    if (affectedRows()) {
        $message = 'Service record has been deleted successfully.';

        createSystemLog($stationId, $userId, 'Deleted employee service record', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to service record.';
        $success = false;
    }
}

if (isset($_POST['save-psipop'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $item = sanitize($_POST['item']);
    $doa = sanitize($_POST['doa']);
    $dlp = sanitize($_POST['dlp']);
    $positionId = fetchAssoc(position($employeeId))['position_id'];
    $salaryGrade = fetchAssoc(positions($positionId))['salary_grade'];
    $employeeStep = getEmployeeStepIncrement($employeeId);
    $step = '1';
    $status = sanitize($_POST['status']);
    $eligibility = sanitize($_POST['eligibility']);
    $showAlert = true;

    if (numRows($employeeStep) === 0) {
        createStepIncrement($dlp, $step, $salaryGrade, $employeeId);
    } else {
        $esi = fetchAssoc($employeeStep);
        $step = $esi['step'];

        if (empty($esi['date_last_step'])) {
            updateStepIncrement($dlp, $step, $salaryGrade, $employeeId);
        }
    }

    $employeeAward = getEmployeeLoyaltyAward($employeeId);

    if (numRows($employeeAward) === 0) {
        createLoyaltyAward($doa, $employeeId);
    } else {
        $ela = fetchAssoc($employeeAward);

        if (empty($ela['last_awarded_on'])) {
            updateLoyaltyAward($doa, $employeeId);
        }
    }

    updatePsipop($item, $status, $doa, $dlp, $eligibility, $employeeId);

    if (affectedRows()) {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>]' . "'s PSIPOP information has been updated successfully.";

        createSystemLog($stationId, $userId, 'Updated PSIPOP', $employeeId, clientIp());
    } else {
        $message = 'No changes have been made to employee PSIPOP information.';
        $success = false;
    }
}

if (isset($_POST['save-201-file'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $fileId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $description = sanitize($_POST['description']);
    $filename = isset($_POST['file-verifier']) ? sanitize(decipher($_POST['file-verifier'])) : null;
    $ext = $logMessage = '';
    $message = 'No changes have been made to 201 file.';
    $showAlert = true;
    $success = false;

    if (is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
        $temp = $_FILES['file-upload']['tmp_name'];

        if ($_FILES['file-upload']['size'] > $fileUploadSizeLimit) {
            $message = 'The choosen file exceeds the upload file limit (20 MB). No changes have been made to 201 file.';
            return;
        }

        $mimeType = mime_content_type($temp);
        $allowedFileTypes = ['application/pdf'];

        if (!in_array($mimeType, $allowedFileTypes)) {
            $message = 'The choosen file is not an acceptable file (pdf). No changes have been made to 201 file.';
            return;
        }

        $ext = pathinfo($_FILES['file-upload']['name'], PATHINFO_EXTENSION);

        if (!empty($filename) && file_exists(root() . '/' . $filename)) {
            unlink(root() . '/' . $filename);
        }

        $filename = 'uploads/201_files/' . $employeeId . '/' . $employeeId . '-' . date('YmdHis') . '.' . $ext;

        move_uploaded_file($temp, '../' . $filename);
    }

    if (empty($filename)) {
        $message = 'No changes have been made to 201 file.';
        $success = false;
        return;
    } else {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
    }

    if (numRows(fileAttachment($employeeId, $fileId)) === 0) {
        createFileAttachment($description, $filename, $ext, $employeeId);

        $logMessage = 'Added 201 file';
        $message = '201 file has been added successfully.';
    } else {
        updateFileAttachment($description, $filename, $ext, $employeeId, $fileId);

        $logMessage = 'Updated 201 file';
        $message = '201 file has been updated successfully.';
    }

    if (!affectedRows()) {
        $message = 'No changes have been made to 201 file.';
        return;
    }

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    $success = true;
}

if (isset($_POST['delete-201-file'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $fileId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $filename = null;
    $files = fileAttachment($employeeId, $fileId);

    if (numRows($files) > 0) {
        $file = fetchAssoc($files);
        $filename = $file['filename'];
        deleteFileAttachment($employeeId, $fileId);
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, 'Deleted employee 201 file', $employeeId, clientIp());
        unlink(root() . '/' . $filename);
        $message = '201 file has been deleted successfully.';
    } else {
        $message = 'No changes have been made to 201 file.';
        $success = false;
    }
}

if (isset($_POST['approve-step-increment'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;

    $positions = fetchAssoc(position($employeeId));
    $positionId = $positions['position_id'];
    $sg = fetchAssoc(positions($positionId))['salary_grade'];

    $stepIncrement = getEmployeeStepIncrement($employeeId);

    if (numRows($stepIncrement) > 0) {
        $esi = fetchAssoc($stepIncrement);
        $lastStep = $esi['date_last_step'];
        $step = (int)$esi['step'];
        $now = new DateTime('now');
        $dls = new DateTime($lastStep);
        $serviceDuration = $now->diff($dls)->y;

        $count = $serviceDuration < 21 ? (int)($serviceDuration / 3) : 7;
        $increment = $serviceDuration < 21 ? 3 * $count : 21;
        $step = $step < 8 ? $step + $count : 8;

        updateStepIncrement(date('Y-m-d', strtotime("+{$increment} years", strtotime($esi['date_last_step']))), $step, $sg, $employeeId);
    }

    if (affectedRows()) {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>]' . "'s step increment " . 'has been approved successfully.';

        createSystemLog($stationId, $userId, 'Approved employee step increment', $employeeId, clientIp());
    } else {
        $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
        $success = false;
    }
}

if (isset($_POST['approve-loyalty-award'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;

    $loyaltyAward = getEmployeeLoyaltyAward($employeeId);

    if (numRows($loyaltyAward) > 0) {
        $ela = fetchAssoc($loyaltyAward);

        $doa = new DateTime($ela['last_awarded_on']);
        $now = new DateTime('now');

        $count = (int)($now->diff($doa)->y / 5);
        $increment = ($count === 2) ? 10 : 5 * $count;

        updateLoyaltyAward(date('Y-m-d', strtotime("+{$increment} years", strtotime($ela['last_awarded_on']))), $employeeId);
    }

    if (affectedRows()) {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>]' . "'s loyalty award " . 'has been approved successfully.';

        createSystemLog($stationId, $userId, 'Approved employee loyalty award', $employeeId, clientIp());
    } else {
        $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
        $success = false;
    }
}
