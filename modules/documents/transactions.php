<?php
// modules/documents/school-trainsactions.php
if (!$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Transactions</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('Transactions') ?>
    </div>

    <div class="card-body pb-2">
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link text-secondary active" href="#school-transactions" data-toggle="tab">Schools</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" href="#section-transactions" data-toggle="tab">Sections</a>
            </li>
        </ul>

        <div class="tab-content mt-2">
            <?php
            require_once(root() . '/modules/documents/school-transactions.php');
            require_once(root() . '/modules/documents/section-transactions.php');
            ?>
        </div>
    </div>
</div>