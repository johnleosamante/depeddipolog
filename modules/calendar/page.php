<?php
// modules/calendar/page.php
?>

<div id="calendar-panel" class="card">
    <div class="card-header text-uppercase text-center font-weight-bold">
        Calendar of Activities
    </div>

    <div id="calendar" class="card-body">
        <?php
        $calendarActivities = calendar();

        if (numRows($calendarActivities) === 0) { ?>
            <div class="text-center">No scheduled activities</div>
        <?php } else { ?>
            <ul class="fa-ul mb-0 ml-4">
                <?php while ($calendar = fetchAssoc($calendarActivities)) { ?>
                    <li class="py-1">
                        <?php $isHoliday = $calendar['isHoliday'] ?>
                        <span class="fa-li">
                            <i class="fas fa-calendar-alt <?= $isHoliday ? 'text-danger' : 'text-primary' ?>"></i>
                        </span>

                        <span class="<?= $isHoliday ? 'text-danger' : 'text-primary' ?>">
                            <?= $calendar['activity'] ?>
                        </span>

                        <div class="small"><?= toDateRange(strtotime($calendar['from']), strtotime($calendar['to'])) ?></div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>