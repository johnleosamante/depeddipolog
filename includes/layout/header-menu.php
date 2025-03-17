<?php
// includes/layout/header-menu.php
$user = fetchAssoc(employee($userId));
$displayName = toName($user['lname'], $user['fname'], $user['mname'], $user['ext'], true, true);
$position = fetchAssoc(position($userId))['position'];
$displayPhoto = file_exists(root() . '/' . $user['picture']) ? uri() . '/' . $user['picture'] : uri() . '/assets/img/user.png';
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <?php if ($isDts || $isHrmis || $isHrtdms) : ?>
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-0 my-2 my-md-0 mw-100 navbar-search" method="POST" action="">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search..." aria-label="Search" name="primary-search-text" autofocus required>

                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="primary-search-button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    <?php endif ?>

    <ul class="navbar-nav ml-auto">
        <?php if ($isDts || $isHrmis || $isHrtdms) : ?>
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search" method="POST" action="">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search..." aria-label="Search" name="primary-search-text" required>

                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" name="primary-search-button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
        <?php endif ?>

        <li class="nav-item dropdown no-arrow mx-1">
            <?php
            $increment = 1;
            $alertCount = 0;
            $hasStepIncrement = $hasLoyaltyAward = false;
            $employeeSteps = stepIncrement($userId);
            $employeeLoyalties = loyaltyAward($userId);

            if (numRows($employeeSteps) > 0) {
                $employeeStep = fetchAssoc($employeeSteps);
                $increment = (int)$employeeStep['step'];
                $hasStepIncrement = true;
                $alertCount++;
                $increment++;
            }

            if (numRows($employeeLoyalties) > 0) {
                $hasLoyaltyAward = true;
                $alertCount++;
            }
            ?>

            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <?php if ($alertCount) : ?>
                    <span class="badge badge-danger badge-counter"><?= $alertCount ?></span>
                <?php endif ?>
            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                <?php if ($alertCount) : ?>
                    <?php if ($hasStepIncrement) : ?>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500"><?= date('F d, Y') ?></div>
                                <span class="font-weight-bold">You are qualified for Step Increment <?= $increment ?>!</span>
                            </div>
                        </a>
                    <?php endif ?>

                    <?php if ($hasLoyaltyAward) : ?>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-award text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500"><?= date('F d, Y') ?></div>
                                <span class="font-weight-bold">You are qualified for a Loyalty Award!</span>
                            </div>
                        </a>
                    <?php endif ?>
                <?php else : ?>
                    <div class="dropdown-item d-flex align-items-center">
                        <div class="font-weight-light text-center my-2">No new alerts at the moment.</div>
                    </div>
                <?php endif ?>
            </div>
        </li>

        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="completionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks fa-fw"></i>
            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="completionDropdown">
                <h6 class="dropdown-header bg-primary border-primary">
                    My Employee Information Status
                </h6>

                <a class="dropdown-item py-3" href="<?= customUri('pis', 'Employee Information', $userId) ?>">
                    <div class="font-weight-bold text-left pb-1">
                        <?php
                        $pdsProgress = pdsProgress($userId);
                        echo "$pdsProgress% Complete";
                        ?>
                    </div>

                    <?php progressBar($pdsProgress) ?>
                </a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?= strtoupper($displayName) ?>">
                <span class="mr-2 d-none d-md-inline">
                    <div class="text-gray-600 small"><?= strtoupper($displayName) ?></div>

                    <div class="text-xs text-gray-500"><?= strtoupper($position) ?></div>
                </span>

                <span class="d-flex justify-content-center align-middle img-profile rounded-circle overflow-hidden">
                    <img src="<?= $displayPhoto ?>" alt="<?= $displayName ?>" height="100%">
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <?php
                linkDropdownItem(uri() . '/pis', 'Profile', 'fa-user-tie', 'Personnel Information System');

                if (numRows(dtsUser($userId)) > 0) {
                    linkDropdownItem(uri() . '/dts', 'Tracking', 'fa-exchange-alt', 'Document Tracking System');
                }

                if (isStationUser($userId, 'hrmis')) {
                    linkDropdownItem(uri() . '/hrmis', 'HR Management', 'fa-users', 'Human Resource Management Information System');
                }

                if (isStationUser($userId, 'hrtdms')) {
                    linkDropdownItem(uri() . '/hrtdms', 'HR Trainings', 'fa-chalkboard-teacher', 'Human Resource Training &amp; Development Management System');
                }

                if (isStationUser($userId, 'dmis')) {
                    linkDropdownItem(uri() . '/dmis', 'Division Management', 'fa-industry', 'Division Management Information System');
                }
                ?>

                <div class="dropdown-divider"></div>

                <?php
                linkDropdownItem(customUri($activeApp, 'Activity Log'), 'Activity Log', 'fa-list', 'View activity log');
                linkDropdownItem(customUri($activeApp, 'Edit History'), 'Edit History', 'fa-history', 'View edit history');
                linkDropdownItem(customUri($activeApp, 'Settings'), 'Settings', 'fa-cogs', 'Go to settings');
                ?>

                <div class="dropdown-divider"></div>

                <?php modalDropdownItem(uri() . '/logout/logout-dialog.php', 'Logout', 'fa-sign-out-alt', 'Logout') ?>
            </div>
        </li>
    </ul>
</nav>

<div class="background-cover banner text-uppercase text-gray-700">
    <?php
    $schools = schoolDetailsById($stationId);

    if (numRows($schools)) :
        $school = fetchAssoc($schools) ?>
        <h1 class="h3 m-0"><?= $school['name'] ?></h1>

        <?php if (!empty($school['address'])) : ?>
            <div class="small m-0"><?= $school['address'] ?></div>
    <?php endif;
    endif ?>

    <h2 class="h1 m-0 mt-4"><?= strtoupper($appTitle) ?></h2>

    <?php if ($hasPortal && !$isSchoolPortal && $isDts) : ?>
        <h3 class="h4 m-0"><?= stationName($station) ?></h3>
    <?php endif ?>
</div>